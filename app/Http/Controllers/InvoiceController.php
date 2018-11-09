<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadeResponse;
use App\Http\Controllers\Controller;
use View;
use GuzzleHttp\Client;
use PDF;
use App\Mail\InvoiceEmail;
use Illuminate\Support\Facades\Mail;
use App\Helpers\LoginChecker;
use App\Helpers\ValidateAccess;
use Cookie;
use Illuminate\Routing\Redirector;

class InvoiceController extends Controller
{
    public function __construct(Redirector $redirect){
        if(LoginChecker::check() !== true){                        
           $redirect->to('login')->send();                     
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(ValidateAccess::checkAccess(env('MODULE_INVOICE', NULL), env('PERMISSION_READ', NULL)))
            return view('invoice.index');
        else
            return redirect('error');
    }

    public function preinvoice()
    {
        if(ValidateAccess::checkAccess(env('MODULE_INVOICE', NULL), env('PERMISSION_READ', NULL)))
            return view('preinvoice.index');
        else
            return redirect('error');   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(ValidateAccess::checkAccess(env('MODULE_INVOICE', NULL), env('PERMISSION_CREATE', NULL)))
            return view('invoice.create');
        else
            return redirect('error');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function validateXML($id){
        $client = new Client();
        $res = $client->request('GET', '' . env('API_HOST', NULL) . '/' . 'invoice/'.$id);
        if($res->getStatusCode() == 200){            
            $res->getBody()->rewind();
            $result         = $res->getBody()->getContents();
            $invoiceObject  = json_decode($result);

            $certificateName = "certificado" . $invoiceObject->company->ruc . ".p12";
            $certificateRoute = base_path() . DIRECTORY_SEPARATOR. "certificates" . DIRECTORY_SEPARATOR . $certificateName;

            $certificateService = $client->request('GET', '' . env('API_HOST', NULL) . '/companyCertificate' . '/'. $invoiceObject->company->id);
            if($certificateService->getStatusCode() == 200){            
                $certificateService->getBody()->rewind();
                $resultCert = $certificateService->getBody()->getContents();
                $resultCert = json_decode($resultCert);                
                $certificate = $resultCert[0][1];                
                $certificate_decoded = base64_decode($certificate);                                      
                file_put_contents($certificateRoute, $certificate_decoded);
            }                                

            $output = View::make('xml.factura', compact('invoiceObject'))->render();              
		#dd($output);

            if($invoiceObject->invoice_payment == NULL){
                $res = $client->request('GET', '' . env('API_HOST', NULL) . '/' . 'preinvoice/deleteCorrelative/'.$id);
                if($res->getStatusCode() == 200){            
                    $res->getBody()->rewind();
                    $result = $res->getBody()->getContents();
                }
                return "Es necesario que añada un método de pago a la factura.";
            }                        

            file_put_contents(base_path() . DIRECTORY_SEPARATOR. "xml" . DIRECTORY_SEPARATOR . "xmlTemp". $invoiceObject->invoice->auth_code .".xml", $output); 

            $auxPath        = "";
            $newBasePath    = "";
            $xmlOrigin      = "";
            $certificate    = "";
            $outputDest     = "";
            $outputFile     = "";
            $pass           = "";
            $signApp        = "";            

            if (DIRECTORY_SEPARATOR == '/') {
                $auxPath = base_path();
                $newBasePath = str_replace('/', "//", $auxPath);                                

                $xmlOrigin      = "" . $newBasePath . '//xml/xmlTemp'. $invoiceObject->invoice->auth_code . '.xml';
                $certificate    = "" . $newBasePath . '//certificates//' . $certificateName;
                $outputDest     = "" . $newBasePath . '//signed_xml//';
                $outputFile     = "signedTemp".$invoiceObject->invoice->auth_code.".xml";
                $pass           = "" . $invoiceObject->company->certP;
                $signApp        = "" . $newBasePath . '//xmlSign//sign.jar';                
            }
            else{
                $auxPath = base_path();
                $newBasePath = str_replace('\\', "\\\\", $auxPath);            

                $xmlOrigin      = "" . $newBasePath . '\\\\xml\\\\xmlTemp'. $invoiceObject->invoice->auth_code . '.xml';
                $certificate    = "" . $newBasePath . '\\\\certificates\\\\' . $certificateName;
                $outputDest     = "" . $newBasePath . '\\\\signed_xml\\\\';
                $outputFile     = "signedTemp".$invoiceObject->invoice->auth_code.".xml";
                $pass           = "" . $invoiceObject->company->certP;
                $signApp        = "" . $newBasePath . '\\\\xmlSign\\\\sign.jar';                
            }            
                        
            $sentence = "java -jar ". $signApp . " " . $certificate . " " . $pass . " " . $xmlOrigin . " " . $outputDest . " " . $outputFile;            
            //ejecutando el .jar desde php para firmar los archivos XML

            $outputXML = shell_exec($sentence);                                                                           

            $sendApp = "";
            $outputResponseSRI = "";

            if (DIRECTORY_SEPARATOR == '/') {
                $sendApp            = "" . $newBasePath . '//servicesSRI//consumirdorWS.jar';   
                $outputResponseSRI  = "" . $newBasePath . '//firmas';
            }
            else{
                $sendApp            = "" . $newBasePath . '\\\\servicesSRI\\\\consumirdorWS.jar';   
                $outputResponseSRI  = "" . $newBasePath . '\\\\firmas';
            }

            $sendToSRI          = "java -jar " . $sendApp . " " . $outputDest . $outputFile . " " . $invoiceObject->company->ruc . " " . $outputResponseSRI . " " . $invoiceObject->company->environment . " " . env('API_INCREMENT_CORRELATIVES', NULL) . $invoiceObject->company->id;                        

            $outputSRI = shell_exec($sendToSRI);            

            $xmlAuth = base_path() . DIRECTORY_SEPARATOR. "firmas" . DIRECTORY_SEPARATOR . "xmlA" . DIRECTORY_SEPARATOR . $outputFile;

            if(file_exists($xmlAuth)){
                $xmlString  = file_get_contents($xmlAuth);
                $xml        = simplexml_load_string($xmlString);
                            
                if($xml->estado == "AUTORIZADO"){         
                    
                    $fechaAutorizacion = (string) $xml->fechaAutorizacion;                    
                    $auxFecha = explode(" ", $fechaAutorizacion);
                    $fecha = $auxFecha[0];
                    $hora  = $auxFecha[1];

                    $auxTime = explode('/', $fecha);
                    $newDate = $auxTime[2] . "-" . $auxTime[1] . "-" . $auxTime[0];                    

                    $newHour = explode(".", $hora);
                    $finalTime = $newDate . " " . $newHour[0];                    

                    $xml_response = $client->post('' . env('API_HOST', NULL). '/invoice/xmlAuthorized/'.$id, 
                            array(
                                'headers'   =>  array('Content-Type'=>'application/json'),
                                'json'      =>  array(
                                                    'auth_date' => $finalTime, 
                                                    'xml'       => $xmlString
                                                )
                            )
                    );

                    if($xml_response->getStatusCode() == 200){                   
                        $xml_response->getBody()->rewind();
                        $resultxml = $res->getBody()->getContents();                                              
                    }
                }
            }
                        
            return $outputSRI;
        }
        else{
            return response('', 404);
        }                            
    }

    public function createPDF($id){

        $client = new Client();
        $res = $client->request('GET', '' . env('API_HOST', NULL) . '/' . 'invoice/' . $id);
        if($res->getStatusCode() == 200){                        
            $res->getBody()->rewind();            
            $result         = $res->getBody()->getContents();
            $invoiceObject  = json_decode($result);             

            $pdf = PDF::loadView('pdf.factura', compact('invoiceObject'), [], ['format' => 'A4']);
            return $pdf->stream('invoice.pdf');            
        }
        else{
            return response('', 404);
        }
    }

    public function mail($id){   
        $client = new Client();
        $res = $client->request('GET', '' . env('API_HOST', NULL) . '/' . 'invoice/'.$id);
        if($res->getStatusCode() == 200){            
            $res->getBody()->rewind();
            $result         = $res->getBody()->getContents();
            $invoiceObject  = json_decode($result);

            $tempFile = base_path() . DIRECTORY_SEPARATOR . "temp_pdf" . DIRECTORY_SEPARATOR . "invoice_" . $invoiceObject->invoice->auth_code . ".pdf";            
            $pdf = PDF::loadView('pdf.factura', compact('invoiceObject'), [], ['format' => 'A4']);
            $pdf->save($tempFile);

            $objDemo = new \stdClass();
            $objDemo->invoice_id    = $id;
            $objDemo->company       = $invoiceObject->company->id;
            $objDemo->token         = $_COOKIE['token'];
            $objDemo->pdf_file      = $tempFile;            

            $authXML = base_path() . DIRECTORY_SEPARATOR . "firmas" . DIRECTORY_SEPARATOR . "xmlA" . DIRECTORY_SEPARATOR . "signedTemp" . $invoiceObject->invoice->auth_code . ".xml";             
            if(file_exists($authXML)){
                $objDemo->xml_file = $authXML;
            }
            else{
                $output = View::make('xml.factura', compact('invoiceObject'))->render();

                $certificateName = "certificado" . $invoiceObject->company->ruc . ".p12";
                $certificateRoute = base_path() . DIRECTORY_SEPARATOR. "certificates" . DIRECTORY_SEPARATOR . $certificateName;

                $certificateService = $client->request('GET', '' . env('API_HOST', NULL) . '/companyCertificate' . '/'. $invoiceObject->company->id);
                if($certificateService->getStatusCode() == 200){            
                    $certificateService->getBody()->rewind();
                    $resultCert = $certificateService->getBody()->getContents();
                    $resultCert = json_decode($resultCert);                
                    $certificate = $resultCert[0][1];                
                    $certificate_decoded = base64_decode($certificate);                                      
                    file_put_contents($certificateRoute, $certificate_decoded);
                }

                file_put_contents(base_path() . DIRECTORY_SEPARATOR . "xml" . DIRECTORY_SEPARATOR . "xmlTemp". $invoiceObject->invoice->auth_code .".xml", $output);
                
                $auxPath        = base_path();
                $newBasePath    = "";
                $xmlOrigin      = "";
                $certificate    = "";
                $outputDest     = "";
                $outputFile     = "";
                $pass           = "";
                $signApp        = "";

                if (DIRECTORY_SEPARATOR == '/') {                    
                    $newBasePath = str_replace('/', "//", $auxPath);                            
                    $xmlOrigin      = "" . $newBasePath . '//xml////xmlTemp'. $invoiceObject->invoice->auth_code . '.xml';
                    $certificate    = "" . $newBasePath . '//certificates//' . $certificateName;
                    $outputDest     = "" . $newBasePath . '//signed_xml//';
                    $outputFile     = "signedTemp".$invoiceObject->invoice->auth_code.".xml";
                    $pass           = "" . $invoiceObject->company->certP;
                    $signApp        = "" . $newBasePath . '//xmlSign//sign.jar';
                }
                else{                    
                    $newBasePath = str_replace('\\', "\\\\", $auxPath);            
                    $xmlOrigin      = "" . $newBasePath . '\\\\xml\\\\xmlTemp'. $invoiceObject->invoice->auth_code . '.xml';
                    $certificate    = "" . $newBasePath . '\\\\certificates\\\\' . $certificateName;
                    $outputDest     = "" . $newBasePath . '\\\\signed_xml\\\\';
                    $outputFile     = "signedTemp".$invoiceObject->invoice->auth_code.".xml";
                    $pass           = "" . $invoiceObject->company->certP;
                    $signApp        = "" . $newBasePath . '\\\\xmlSign\\\\sign.jar';
                }
                
                $sentence = "java -jar ". $signApp . " " . $certificate . " " . $pass . " " . $xmlOrigin . " " . $outputDest . " " . $outputFile;
                
                //ejecutando el .jar desde php para firmar los archivos XML
                $outputXML = shell_exec($sentence);
                

                $signedXML = base_path() . DIRECTORY_SEPARATOR . "signed_xml" . DIRECTORY_SEPARATOR . "signedTemp" . $invoiceObject->invoice->auth_code . ".xml";                

                $objDemo->xml_file = $signedXML;
            }
                           
            Mail::to($invoiceObject->client->email)->send(new InvoiceEmail($objDemo));
        }
    }

    public function mailPDF($id){   
        $client = new Client();
        $res = $client->request('GET', '' . env('API_HOST', NULL) . '/' . 'invoice/'.$id);

        if($res->getStatusCode() == 200){            
            $res->getBody()->rewind();
            $result         = $res->getBody()->getContents();
            $invoiceObject  = json_decode($result);

            $tempFile = base_path() . DIRECTORY_SEPARATOR . "temp_pdf" . DIRECTORY_SEPARATOR . "invoice_" . $invoiceObject->invoice->auth_code . ".pdf";            
            $pdf = PDF::loadView('pdf.factura', compact('invoiceObject'), [], ['format' => 'A4']);
            $pdf->save($tempFile);

            $objDemo = new \stdClass();
            $objDemo->invoice_id    = $id;
            $objDemo->company       = $invoiceObject->company->id;
            $objDemo->token         = $_COOKIE['token'];
            $objDemo->pdf_file      = $tempFile;            
           
            Mail::to($invoiceObject->client->email)->send(new InvoiceEmail($objDemo));
        }
    }

    public function downloadXML($id){        
        $client = new Client();
        $res = $client->request('GET', '' . env('API_HOST', NULL) . '/' . 'invoice/getXML/'.$id);

        if($res->getStatusCode() == 200){            
            $res->getBody()->rewind();
            $result         = $res->getBody()->getContents();
            $invoiceObject  = json_decode($result);
            $output = $invoiceObject->xml_generated;
            $route = base_path() . DIRECTORY_SEPARATOR . "xml" . DIRECTORY_SEPARATOR . "xmlTemp". $invoiceObject->auth_code .".xml";
            file_put_contents($route, $output);            
            return FacadeResponse::download($route);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(ValidateAccess::checkAccess(env('MODULE_INVOICE', NULL), env('PERMISSION_UPDATE', NULL)))        
            return view('preinvoice.edit', compact('id'));
        else
            return redirect('error');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }    
}
