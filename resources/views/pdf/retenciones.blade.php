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
                      @if($retentionObject->branch->logo)                        
                        <img src="data:image/png;base64,{{$retentionObject->branch->logo}}" style="margin-top: -15px">
                      @else
                        <img src="data:image/png;base64,{{$retentionObject->company->logo}}" style="margin-top: -15px">  
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
                      <td style="font-size: 11px">{{$retentionObject->company->social_reason}}</td>                      
                    </tr>

                    <tr>
                      <td style="font-size: 11px">{{$retentionObject->company->comercial_name}}</td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">Dir. Matriz: </div>{{$retentionObject->company->address}}</td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">Dir. Sucursal: </div>{{$retentionObject->branch->address}}</td>
                    </tr>
                    
                    <tr>
                      <td height="5px"></td>
                    </tr>

                    @if($retentionObject->company->special_code != NULL)
                      <tr>
                        <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">Contribuyente Especial Nro.:</div> {{$retentionObject->company->special_code}}</td>
                      </tr>

                      <tr>
                        <td height="5px"></td>
                      </tr>                      
                    @endif

                    @if($retentionObject->company->is_artisan == 1)
                      <tr>
                        <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">Calificación Artesanal: </div>{{$retentionObject->company->register_number}}</td>
                      </tr>

                      <tr>
                        <td height="5px"></td>
                      </tr>
                    @endif

                    @if($retentionObject->company->is_accounting == 1)
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
        
        <td style="width: 47%; vertical-align:top">
          <table border="1">
            <tbody>        
              
              <tr>        
                <td>

                  <table border="0">
                    <tr>
                      <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">R.U.C.:</div> {{$retentionObject->company->ruc}}</td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td><div style="font-weight: bold; font-size: 11px">COMPROBANTE DE RETENCION</div></td>
                    </tr>
                    <tr>
                      <td style="font-size: 11px">No. {{$retentionObject->company->emission_code . "-" . $retentionObject->branch->emission_point . "-" . $retentionObject->principal_code}}</td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td><div style="font-weight: bold; font-size: 11px">Número de Autorización</div></td>
                    </tr>
                    <tr>
                      <td style="font-size: 11px">{{$retentionObject->auth_code}}</td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td><div style="font-weight: bold; font-size: 11px">Fecha y hora de autorización</div></td>
                    </tr>

                    <tr>
                      <td style="font-size: 11px">{{$retentionObject->auth_date ? $retentionObject->auth_date : ''}}</td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    @if($retentionObject->environment_type == 1)                       
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

                    @if($retentionObject->emission_type == 1)
                      <tr>
                        <td style="font-size: 11px"><div style="font-weight: bold">Emisión: </div> NORMAL</td>
                      </tr>                      
                    @endif

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td style="font-size: 11px"><div style="font-weight: bold">Clave de acceso</div></td>
                      <img style="width: 50%; margin-left: 5px; margin-right: 5px" src="https://barcode.tec-it.com/barcode.ashx?data={{$retentionObject->auth_code}}&code=EANUCC128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0"/> 
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

    <table width="100%" style="border:1px solid black">
      <tbody>
        <tr>
          <td style="width: 1%"></td>
          @if($retentionObject->supplier->social_reason != NULL)
            <td style="width: 70%; font-size: 11px">Razón social / Nombres y Apellidos: <br>{{$retentionObject->supplier->social_reason}}</td>
          @else
            <td style="width: 70%; font-size: 11px">Razón social / Nombres y Apellidos: <br>{{$retentionObject->supplier->comercial_name}}</td>
          @endif
          <td style="width: 1%"></td>
          <td style="width: 25%; font-size: 11px">
            {{$retentionObject->supplier->idClass}}: 
            {{$retentionObject->supplier->identification}}
          </td>
        </tr>
        <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px">Dirección: {{$retentionObject->supplier->address}}</td>
          <td></td>
          <td style="font-size: 11px">Teléfono:<br>{{$retentionObject->supplier->phone}}</td>
        </tr>
        <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px">Fecha de Emisión: {{$retentionObject->emission_date}}</td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>      
    
    <br><br>

    <table width="100%" border="0">
      <thead>
        <tr>
          <th style="width: 20%; font-size: 11px"><center>Comprobante</center></th>
          <th style="width: 18%; font-size: 11px"><center>Número</center></th>
          <th style="width: 10%; font-size: 11px"><center>Fecha Emisión</center></th>
          <th style="width: 12%; font-size: 11px"><center>Ejercicio Fiscal</center></th>            
          <th style="width: 13%; font-size: 11px"><center>Base imponible</center></th>            
          <th style="width: 12%; font-size: 11px"><center>Impuesto</center></th>
          <th style="width: 15%; font-size: 11px"><center>Porcentaje Retención</center></th>
          <th style="width: 15%; font-size: 11px"><center>Valor Retenido</center></th>
        </tr>
      </thead>  
      <tbody>
        @foreach($retentionObject->document_line as $line)
          <tr>
            <td style="font-size: 11px">{{$line->document}}</td>
            <td style="font-size: 11px" align="center">{{$line->referral_document}}</td>            
            <td style="font-size: 11px" align="center">{{$line->doc_emission_date}}</td>            
            <td style="font-size: 11px" align="center">{{$retentionObject->supplier->tax_period}}</td>
            <td style="font-size: 11px" align="center">{{$line->tax_base_amount}}</td>
            <td style="font-size: 11px" align="center">{{$line->tax_name}}</td>            
            <td style="font-size: 11px" align="center">{{$line->tax_percentage}}</td>
            <td style="font-size: 11px" align="center">{{$line->tax_total_amount}}</td>
          </tr>
        @endforeach
      </tbody>
    </table> 

    <br><br>  

    <table width="100%">
      <tbody>
        <tr>
          <td style="width: 58%; vertical-align:top">
            <table style="border:1px solid black" width="100%">      
              <tbody>                
                <tr>
                  <td style="font-weight: bold; font-size: 11px" align="center">Información Adicional</td>
                  <td>
                    <tr> 
                      <td style="font-weight: bold; font-size: 11px" align="center">Dirección</td> 
                      <td style="font-size: 11px">{{$retentionObject->supplier->address}}</td>
                    </tr> 
                  </td>                              
                  <td>
                    <tr> 
                      <td style="font-weight: bold; font-size: 11px" align="center">Email</td> 
                      <td style="font-size: 11px">{{$retentionObject->supplier->email}}</td>
                    </tr>
                  </td>          
                </tr>                
              </tbody>
            </table> 
          </td>          
        </tr>
      </tbody>
    </table>