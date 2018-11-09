	<head>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">		
		
		<style type="text/css">
			div.border{
		    border: 1px solid black;
			}
  	</style>
    
    <meta charset="utf-8"> 

	</head>

    <table style="width: 100%">
      <tr>
        <td style="width: 47%;">
          <table>
            <tbody>        
              
              <tr>        
                <td>
                    <div name="logo" style="width: 300px; height: 100px">
                      @if($remissionObject->company->logo)                        
                        <img src="data:image/png;base64,{{$remissionObject->company->logo}}">  
                      @endif
                    </div>
                </td>
              </tr>

              <tr>
                <td height="20px"></td>
              </tr>

              <tr>        
                <td style="border:0px solid black">
                  <table>
                    <tr>
                      <td style="font-size: 11px">{{$remissionObject->company->social_reason}}</td>                      
                    </tr>

                    <tr>
                      <td style="font-size: 11px">{{$remissionObject->company->comercial_name}}</td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">Dir. Matriz: </div>{{$remissionObject->company->address}}</td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">Dir. Sucursal: </div>{{$remissionObject->branch->address}}</td>
                    </tr>
                    
                    <tr>
                      <td height="5px"></td>
                    </tr>

                    @if($remissionObject->company->special_code != NULL)
                      <tr>
                        <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">Contribuyente Especial Nro.:</div> {{$remissionObject->company->special_code}}</td>
                      </tr>

                      <tr>
                        <td height="5px"></td>
                      </tr>                      
                    @endif

                    @if($remissionObject->company->is_artisan == 1)
                      <tr>
                        <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">Calificación Artesanal: </div>{{$remissionObject->company->register_number}}</td>
                      </tr>

                      <tr>
                        <td height="5px"></td>
                      </tr>
                    @endif

                    @if($remissionObject->company->is_accounting == 1)
                      <tr>
                        <td><div style="font-weight: bold; font-size: 11px">OBLIGADO A LLEVAR CONTABILIDAD: SI</div></td>
                      </tr>                    
                    @else
                      <tr>
                        <td><div style="font-weight: bold; font-size: 11px">OBLIGADO A LLEVAR CONTABILIDAD: NO</div></td>
                      </tr>
                    @endif

                  </table>
                  
                </td>
              </tr>
            
            </tbody>  
          </table>
        </td>

        <td style="width: 6%">          
        </td>
        
        <td style="width: 47%; vertical-align:top;">
          <table border="1">
            <tbody>        
              
              <tr>        
                <td>
                  
                  <table border="0">
                    <tr>
                      <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">R.U.C.:</div> {{$remissionObject->company->ruc}}</td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td><div style="font-weight: bold; font-size: 11px">GUÍA DE REMISIÓN</div></td>
                    </tr>
                    <tr>
                      <td style="font-size: 11px">No. {{$remissionObject->company->emission_code . "-" . $remissionObject->branch->emission_point . "-" . $remissionObject->principal_code}}</td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td><div style="font-weight: bold; font-size: 11px">Número de Autorización</div></td>
                    </tr>
                    <tr>
                      <td style="font-size: 11px">{{$remissionObject->auth_code}}</td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td><div style="font-weight: bold; font-size: 11px">Fecha y hora de autorización</div></td>
                    </tr>

                    <tr>
                      <td style="font-size: 11px">{{$remissionObject->auth_date ? $remissionObject->auth_date : ''}}</td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    @if($remissionObject->environment_type == 1)                       
                       <tr>
                         <td style="font-size: 11px"><div style="font-weight: bold">Ambiente:</div> PRUEBAS</td>
                       </tr>
                    @else
                       <tr>
                         <td style="font-size: 11px"><div style="font-weight: bold">Ambiente:</div> PRODUCCIÓN</td>
                       </tr>
                    @endif

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    @if($remissionObject->emission_type == 1)
                      <tr>
                        <td style="font-size: 11px"><div style="font-weight: bold">Emisión: </div> NORMAL</td>
                      </tr>                      
                    @endif

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td style="font-size: 11px"><div style="font-weight: bold">Clave de acceso</div></td>
                      <img style="width: 50%; margin-left: 5px; margin-right: 5px" src="https://barcode.tec-it.com/barcode.ashx?data={{$remissionObject->auth_code}}&code=EANUCC128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0"/> 
                    </tr>
                  </table>
                  
                </td>
              </tr>                          
            </tbody>  
          </table>          
        </td>
      </tr>
    </table>

    <br>                 

    <table width="100%" style="border:1px solid black" border="0">
      <tbody>
        <tr>
          <td style="width: 20%; font-size: 11px; font-weight: bold">Identificación (Transportista): </td>          
          <td style="width: 20%; font-size: 11px;" align="center">{{$remissionObject->dispatcher->identification_number}}</td>
			    <td style="width: 35%; font-size: 11px; font-weight: bold">Razón social / Nombres y Apellidos:</td>
          <td style="width: 30%; font-size: 11px;">{{$remissionObject->dispatcher->social_reason}}</td>
        </tr>        
        
		    <tr>          
          <td style="font-size: 11px; font-weight: bold">Placa: </td>
          <td style="font-size: 11px" align="center">{{$remissionObject->car_register}}</td>
          <td></td>
          <td></td>
        </tr>
		
		    <tr>          
          <td style="font-size: 11px; font-weight: bold">Punto de partida: </td>
          <td style="font-size: 11px" align="center">{{$remissionObject->starting_point}}</td>
          <td></td>
          <td></td>
        </tr>
		
		    <tr>          
          <td style="font-size: 11px; font-weight: bold">Fecha de inicio Transporte: </td>
          <td style="font-size: 11px" align="center">{{$remissionObject->startdate_transport}}</td>
          <td></td>
          <td></td>
        </tr>
		
		    <tr>          
          <td style="font-size: 11px; font-weight: bold">Fecha fin Transporte: </td>
          <td style="font-size: 11px" align="center">{{$remissionObject->enddate_transport}}</td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>      
    
    <br>

    <table width="100%" style="border:1px solid black" border="0">
      <tbody>              
        <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px; font-weight: bold" width="30%">Comprobante de venta:</td>
          <td style="font-size: 12px; width: 50%" align="center">{{"Factura"}}</td>
          <td style="font-size: 12px" align="left">{{substr($remissionObject->invoice->referral_code, 0, 3) . "-" . substr($remissionObject->invoice->referral_code, 3, 3) . "-" . substr($remissionObject->invoice->referral_code, 6)}}</td>
        </tr>

        <tr>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
        </tr>

        <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px; font-weight: bold">Fecha de emisión: </td>
          <td style="font-size: 11px" align="left">{{$remissionObject->modifiedDocumentEmissionDate}}</td>
          <td></td>
        </tr>

        <tr>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
        </tr>
		
		    <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px; font-weight: bold">Número de Autorización: </td>
          <td style="font-size: 11px" align="left">{{$remissionObject->invoice->auth_code}}</td>
          <td></td>
        </tr>

        <tr>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
        </tr>

        <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px; font-weight: bold">Motivo del Traslado:</td>
          <td style="font-size: 11px" align="left">{{$remissionObject->reason_transport}}</td>
          <td></td>
        </tr>
		    
        <tr>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
        </tr>

		    <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px; font-weight: bold">Destino (Punto de llegada):</td>
          <td style="font-size: 11px" align="left">{{$remissionObject->invoice->client->address}}</td>
          <td></td>
        </tr>

        <tr>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
        </tr>
		
		    <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px; font-weight: bold">Identificacion(Destinatario):</td>
          <td style="font-size: 11px" align="left">{{$remissionObject->invoice->client->identification_number}}</td>
          <td></td>
        </tr>

        <tr>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
        </tr>
		
		    <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px; font-weight: bold">Razon Social/Nombres y Apellidos:</td>
          <td style="font-size: 11px" align="left">{{$remissionObject->invoice->client->social_reason}}</td>
          <td></td>
        </tr>

        <tr>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
        </tr>
		
		    <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px; font-weight: bold">Documento Aduanero:</td>
          <td style="font-size: 11px" align="left">{{$remissionObject->custom_document}}</td>
          <td></td>
        </tr>
		  
        <tr>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
        </tr>

		    <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px; font-weight: bold">Codigo Establecimiento Destino:</td>
          <td style="font-size: 11px" align="left">{{$remissionObject->destination_branch_code}}</td>
          <td></td>
        </tr>

        <tr>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
          <td height="5px"></td>
        </tr>
		
		    <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px; font-weight: bold">Ruta:</td>
          <td style="font-size: 11px" align="left">{{$remissionObject->route}}</td>
          <td></td>
		    </tr>    		
		
      </tbody>
    </table> 

    <br>

    <table width="100%" border="0" style="border:1px solid black">
      <thead>
        <tr>
          <td style="font-size: 11px; font-weight: bold" align="center">Cantidad</td>
          <td style="font-size: 11px; font-weight: bold" align="center">Descripción</td>
          <td style="font-size: 11px; font-weight: bold" align="center">Código Principal</td>
          <td style="font-size: 11px; font-weight: bold" align="center">Código Auxiliar</td>
        </tr>
      </thead>
      
      <tbody>
        @foreach($remissionObject->invoiceLine as $line)
          <tr>
            <td style="font-size: 11px; width: 15%" align="center">{{number_format($line->quantity, 2, ',', '.')}}</td>
            <td style="font-size: 11px; width: 40%">{{$line->description}}</td>
            <td style="font-size: 11px; width: 15%" align="center">{{$line->principal_code}}</td>
            <td style="font-size: 11px; width: 15%" align="center">{{$line->auxiliary_code}}</td>                                            
          </tr>
        @endforeach
      </tbody>
    </table>