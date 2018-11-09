<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadeResponse;
use App\Http\Controllers\Controller;
use View;
use GuzzleHttp\Client;
use PDF;
use App\Mail\CreditNoteEmail;
use Illuminate\Support\Facades\Mail;
use App\Helpers\LoginChecker;
use App\Helpers\ValidateAccess;
use Cookie;
use Illuminate\Routing\Redirector;

class CreditNoteController extends Controller
{
    public function __construct(Redirector $redirect){
        if(LoginChecker::check() !== true){                        
           $redirect->to('login')->send();                     
        }
    }
    
    public function index()
    {
        // if(ValidateAccess::checkAccess(env('MODULE_TAXDOCUMENT_CREDITNOTE', NULL), env('PERMISSION_READ', NULL)))
            return view('creditnote.index');
        // else
            // return redirect('error');
    }

    public function create()
    {
        // if(ValidateAccess::checkAccess(env('MODULE_TAXDOCUMENT_CREDITNOTE', NULL), env('PERMISSION_CREATE', NULL)))
            return view('creditnote.create');
        // else
        //    return redirect('error');
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

    public function createCreditNotePDF(){
        return view('pdf.notascredito');
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

    public function validateXML($id){
        $client = new Client();
        $res = $client->request('GET', '' . env('API_HOST', NULL) . '/'. 'creditnote/'.$id);
        if($res->getStatusCode() == 200){            
            $res->getBody()->rewind();
            $result = $res->getBody()->getContents();            
            $creditNoteObject = json_decode($result);

            $certificateName = "certificado" . $creditNoteObject->company->ruc . ".p12";
            $certificateRoute = base_path() . DIRECTORY_SEPARATOR. "certificates" . DIRECTORY_SEPARATOR . $certificateName;

            $certificateService = $client->request('GET', '' . env('API_HOST', NULL) . '/companyCertificate' . '/'. $creditNoteObject->company->id);

            if($certificateService->getStatusCode() == 200){            
                $certificateService->getBody()->rewind();
                $resultCert = $certificateService->getBody()->getContents();
                $resultCert = json_decode($resultCert);                
                $certificate = $resultCert[0][1];                
                $certificate_decoded = base64_decode($certificate);                                      
                file_put_contents($certificateRoute, $certificate_decoded);
            }                                            

            $output = View::make('xml.creditnote', compact('creditNoteObject'))->render();            

            file_put_contents(base_path() . DIRECTORY_SEPARATOR. "xml" . DIRECTORY_SEPARATOR . "xmlTemp". $creditNoteObject->auth_code .".xml", $output);             

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

                $xmlOrigin      = "" . $newBasePath . '//xml/xmlTemp'. $creditNoteObject->auth_code . '.xml';
                $certificate    = "" . $newBasePath . '//certificates//' . $certificateName;
                $outputDest     = "" . $newBasePath . '//signed_xml//';
                $outputFile     = "signedTemp".$creditNoteObject->auth_code.".xml";
                $pass           = "" . $creditNoteObject->company->certP;
                $signApp        = "" . $newBasePath . '//xmlSign//sign.jar';                
            }
            else{
                $auxPath = base_path();
                $newBasePath = str_replace('\\', "\\\\", $auxPath);            

                $xmlOrigin      = "" . $newBasePath . '\\\\xml\\\\xmlTemp'. $creditNoteObject->auth_code . '.xml';
                $certificate    = "" . $newBasePath . '\\\\certificates\\\\' . $certificateName;
                $outputDest     = "" . $newBasePath . '\\\\signed_xml\\\\';
                $outputFile     = "signedTemp".$creditNoteObject->auth_code.".xml";
                $pass           = "" . $creditNoteObject->company->certP;
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

            $sendToSRI          = "java -jar " . $sendApp . " " . $outputDest . $outputFile . " " . $creditNoteObject->company->ruc . " " . $outputResponseSRI . " " . $creditNoteObject->company->environment . " " . env('API_INCREMENT_CREDITNOTE_CORRELATIVES', NULL) . $creditNoteObject->company->id;                        

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

                    $xml_response = $client->post('' . env('API_HOST', NULL). '/creditnote/xmlAuthorized/'.$id, 
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

        $res = $client->request('GET', '' . env('API_HOST', NULL) . '/' . 'creditnote/' . $id);
        if($res->getStatusCode() == 200){                        
            $res->getBody()->rewind();            
            $result         = $res->getBody()->getContents();
            $creditNoteObject  = json_decode($result);             
            
            $pdf = PDF::loadView('pdf.creditnote', compact('creditNoteObject'), [], ['format' => 'A4']);
            return $pdf->stream('creditnote.pdf');
            #return view('pdf.factura', compact('invoiceObject'));
        }
        else{
            return response('', 404);
        }
    }

    public function mail($id){   
        $client = new Client();

        $res = $client->request('GET', '' . env('API_HOST', NULL) . '/' . 'creditnote/'.$id);
        if($res->getStatusCode() == 200){            
            $res->getBody()->rewind();
            $result         = $res->getBody()->getContents();
            $creditNoteObject  = json_decode($result);

            $tempFile = base_path() . DIRECTORY_SEPARATOR . "temp_pdf" . DIRECTORY_SEPARATOR . "creditnote_" . $creditNoteObject->auth_code . ".pdf";            
            $pdf = PDF::loadView('pdf.creditnote', compact('creditNoteObject'), [], ['format' => 'A4']);
            $pdf->save($tempFile);

            $objDemo = new \stdClass();
            $objDemo->retention_id  = $id;

            $objDemo->company       = $creditNoteObject->company->id;
            $objDemo->token         = $_COOKIE['token'];
            $objDemo->pdf_file      = $tempFile;            

            $authXML = base_path() . DIRECTORY_SEPARATOR . "firmas" . DIRECTORY_SEPARATOR . "xmlA" . DIRECTORY_SEPARATOR . "signedTemp" . $creditNoteObject->auth_code . ".xml";             
            if(file_exists($authXML)){
                $objDemo->xml_file = $authXML;
            }
            else{

                $output = View::make('xml.creditnote', compact('creditNoteObject'))->render();

                $certificateName = "certificado" . $creditNoteObject->company->ruc . ".p12";
                $certificateRoute = base_path() . DIRECTORY_SEPARATOR. "certificates" . DIRECTORY_SEPARATOR . $certificateName;

                $certificateService = $client->request('GET', '' . env('API_HOST', NULL) . '/companyCertificate' . '/'. $creditNoteObject->company->id);
                if($certificateService->getStatusCode() == 200){            
                    $certificateService->getBody()->rewind();
                    $resultCert = $certificateService->getBody()->getContents();
                    $resultCert = json_decode($resultCert);                
                    $certificate = $resultCert[0][1];                
                    $certificate_decoded = base64_decode($certificate);                                      
                    file_put_contents($certificateRoute, $certificate_decoded);
                }

                file_put_contents(base_path() . DIRECTORY_SEPARATOR . "xml" . DIRECTORY_SEPARATOR . "xmlTemp". $creditNoteObject->auth_code .".xml", $output);
                
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

                    $xmlOrigin      = "" . $newBasePath . '//xml////xmlTemp'. $creditNoteObject->auth_code . '.xml';
                    $certificate    = "" . $newBasePath . '//certificates//' . $certificateName;
                    $outputDest     = "" . $newBasePath . '//signed_xml//';
                    $outputFile     = "signedTemp".$creditNoteObject->auth_code.".xml";
                    $pass           = "" . $creditNoteObject->company->certP;
                    $signApp        = "" . $newBasePath . '//xmlSign//sign.jar';
                }
                else{                    
                    $newBasePath = str_replace('\\', "\\\\", $auxPath);            

                    $xmlOrigin      = "" . $newBasePath . '\\\\xml\\\\xmlTemp'. $creditNoteObject->auth_code . '.xml';
                    $certificate    = "" . $newBasePath . '\\\\certificates\\\\' . $certificateName;
                    $outputDest     = "" . $newBasePath . '\\\\signed_xml\\\\';
                    $outputFile     = "signedTemp".$creditNoteObject->auth_code.".xml";
                    $pass           = "" . $creditNoteObject->company->certP;
                    $signApp        = "" . $newBasePath . '\\\\xmlSign\\\\sign.jar';
                }
                
                $sentence = "java -jar ". $signApp . " " . $certificate . " " . $pass . " " . $xmlOrigin . " " . $outputDest . " " . $outputFile;
                
                //ejecutando el .jar desde php para firmar los archivos XML
                $outputXML = shell_exec($sentence);                

                $signedXML = base_path() . DIRECTORY_SEPARATOR . "signed_xml" . DIRECTORY_SEPARATOR . "signedTemp" . $creditNoteObject->auth_code . ".xml";                

                $objDemo->xml_file = $signedXML;
            }
                                       
            Mail::to($creditNoteObject->client->email)->send(new CreditNoteEmail($objDemo));
        }
    }

    public function downloadXML($id){        
        $client = new Client();

        $res = $client->request('GET', '' . env('API_HOST', NULL) . '/' . 'creditnote/getXML/'.$id);

        if($res->getStatusCode() == 200){            
            $res->getBody()->rewind();
            $result         = $res->getBody()->getContents();

            $creditNoteObject  = json_decode($result);
            
            $output = $creditNoteObject->xml_generated;
            $route = base_path() . DIRECTORY_SEPARATOR . "xml" . DIRECTORY_SEPARATOR . "xmlTemp". $creditNoteObject->auth_code .".xml";
            file_put_contents($route, $output);            
            return FacadeResponse::download($route);
        }
    }
}
