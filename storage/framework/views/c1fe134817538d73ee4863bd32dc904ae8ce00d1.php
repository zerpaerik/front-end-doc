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
                      <?php if($creditNoteObject->company->logo): ?>                        
                        <img src="data:image/png;base64,<?php echo e($creditNoteObject->company->logo); ?>">  
                      <?php endif; ?>
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
                      <td style="font-size: 11px"><?php echo e($creditNoteObject->company->social_reason); ?></td>                      
                    </tr>

                    <tr>
                      <td style="font-size: 11px"><?php echo e($creditNoteObject->company->comercial_name); ?></td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">Dir. Matriz: </div><?php echo e($creditNoteObject->company->address); ?></td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">Dir. Sucursal: </div><?php echo e($creditNoteObject->branch->address); ?></td>
                    </tr>
                    
                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <?php if($creditNoteObject->company->special_code != NULL): ?>
                      <tr>
                        <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">Contribuyente Especial Nro.:</div> <?php echo e($creditNoteObject->company->special_code); ?></td>
                      </tr>

                      <tr>
                        <td height="5px"></td>
                      </tr>                      
                    <?php endif; ?>

                    <?php if($creditNoteObject->company->is_artisan == 1): ?>
                      <tr>
                        <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">Calificación Artesanal: </div><?php echo e($creditNoteObject->company->register_number); ?></td>
                      </tr>

                      <tr>
                        <td height="5px"></td>
                      </tr>
                    <?php endif; ?>

                    <?php if($creditNoteObject->company->is_accounting == 1): ?>
                      <tr>
                        <td><div style="font-weight: bold; font-size: 11px">OBLIGADO A LLEVAR CONTABILIDAD: SI</div></td>
                      </tr>                    
                    <?php else: ?>
                      <tr>
                        <td><div style="font-weight: bold; font-size: 11px">OBLIGADO A LLEVAR CONTABILIDAD: NO</div></td>
                      </tr>
                    <?php endif; ?>

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
                      <td style="font-size: 11px"><div style="font-weight: bold; font-size: 11px">R.U.C.:</div> <?php echo e($creditNoteObject->company->ruc); ?></td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td><div style="font-weight: bold; font-size: 11px">NOTA DE CRÉDITO</div></td>
                    </tr>
                    <tr>
                      <td style="font-size: 11px">No. <?php echo e($creditNoteObject->company->emission_code . "-" . $creditNoteObject->branch->emission_point . "-" . $creditNoteObject->principal_code); ?></td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td><div style="font-weight: bold; font-size: 11px">Número de Autorización</div></td>
                    </tr>
                    <tr>
                      <td style="font-size: 11px"><?php echo e($creditNoteObject->auth_code); ?></td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td><div style="font-weight: bold; font-size: 11px">Fecha y hora de autorización</div></td>
                    </tr>

                    <tr>
                      <td style="font-size: 11px"><?php echo e($creditNoteObject->auth_date ? $creditNoteObject->auth_date : ''); ?></td>
                    </tr>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <?php if($creditNoteObject->environment_type == 1): ?>                       
                       <tr>
                         <td style="font-size: 11px"><div style="font-weight: bold">Ambiente:</div> PRUEBAS</td>
                       </tr>
                    <?php else: ?>
                       <tr>
                         <td style="font-size: 11px"><div style="font-weight: bold">Ambiente:</div> PRODUCCIÓN</td>
                       </tr>
                    <?php endif; ?>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <?php if($creditNoteObject->emission_type == 1): ?>
                      <tr>
                        <td style="font-size: 11px"><div style="font-weight: bold">Emisión: </div> NORMAL</td>
                      </tr>                      
                    <?php endif; ?>

                    <tr>
                      <td height="5px"></td>
                    </tr>

                    <tr>
                      <td style="font-size: 11px"><div style="font-weight: bold">Clave de acceso</div></td>
                      <img style="width: 50%; margin-left: 5px; margin-right: 5px" src="https://barcode.tec-it.com/barcode.ashx?data=<?php echo e($creditNoteObject->auth_code); ?>&code=EANUCC128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0"/> 
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
          <td style="width: 1%"></td>
          <?php if($creditNoteObject->client->social_reason != NULL): ?>
            <td style="width: 35%; font-size: 11px; font-weight: bold">Razón social / Nombres y Apellidos:</td>
            <td style="width: 30%; font-size: 11px;"><?php echo e($creditNoteObject->client->social_reason); ?></td>
          <?php else: ?>
            <td style="width: 35%; font-size: 11px; font-weight: bold">Razón social / Nombres y Apellidos:</td>
            <td style="width: 30%; font-size: 11px;"><?php echo e($creditNoteObject->client->comercial_name); ?></td>
          <?php endif; ?>
          
          <td style="width: 25%; font-size: 11px">            
              <?php echo e($creditNoteObject->client->idClass); ?>:
              <?php echo e($creditNoteObject->client->identification); ?>                          
          </td>          
        </tr>        
        <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px; font-weight: bold">Fecha de Emisión: </td>
          <td style="font-size: 11px"><?php echo e($creditNoteObject->emission_date); ?></td>
          <td></td>
        </tr>

        <tr>
          <td height="10px"></td>
          <td height="10px"></td>
          <td height="10px"></td>
          <td height="10px"></td>
        </tr>

        <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 12px; font-weight: bold">Comprobante que se modifica:</td>
          <td style="font-size: 12px; width: 20%" align="center"><?php echo e("Factura"); ?></td>
          <td style="font-size: 12px" align="center"><?php echo e(substr($creditNoteObject->invoice->referral_code, 0, 3) . "-" . substr($creditNoteObject->invoice->referral_code, 3, 3) . "-" . substr($creditNoteObject->invoice->referral_code, 6)); ?></td>
        </tr>

        <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px; font-weight: bold">Fecha de emisión (comprobante a modificar): </td>
          <td style="font-size: 11px" align="center"><?php echo e($creditNoteObject->modifiedDocumentEmissionDate); ?></td>
          <td></td>
        </tr>

        <tr>
          <td style="width: 1%"></td>
          <td style="font-size: 11px; font-weight: bold">Razón de la modificación:</td>
          <td style="font-size: 11px" align="center"><?php echo e($creditNoteObject->concept); ?></td>
          <td></td>
        </tr>

      </tbody>
    </table>      
    
    <br><br>

    <table width="100%">
      <thead>
        <tr>
          <th style="width: 10%; font-size: 11px"><center>Cód. Principal</center></th>
          <th style="width: 13%; font-size: 11px"><center>Cód. Auxiliar</center></th>
          <th style="width: 5%; font-size: 11px"><center>Cant.</center></th>
          <th style="width: 36%; font-size: 11px"><center>Descripción</center></th>            
          <th style="width: 12%; font-size: 11px"><center>Precio Unitario</center></th>            
          <th style="width: 12%; font-size: 11px"><center>Descuento</center></th>
          <th style="width: 12%; font-size: 11px"><center>Precio Total</center></th>
        </tr>
      </thead>  
      <tbody>
        <?php $__currentLoopData = $creditNoteObject->document_line; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td style="font-size: 11px"><?php echo e($line->principal_code); ?></td>
            <td style="font-size: 11px"><?php echo e($line->auxiliary_code); ?></td>            
            <td style="font-size: 11px" align="center"><?php echo e((int)$line->quantity); ?></td>
            <td style="font-size: 9px"><?php echo e($line->description); ?></td>
            <td style="font-size: 11px" align="right"><?php echo e(number_format($line->unit_price, 2, ',', '.')); ?></td>
            <td style="font-size: 11px" align="right"><?php echo e($line->discount > 0 ? $line->discount."%" : ''); ?></td>            
            <td style="font-size: 11px" align="right"><?php echo e(number_format($line->totalCostNoTax, 2, ',', '.')); ?></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                      <td style="font-size: 11px"><?php echo e($creditNoteObject->client->address); ?></td>
                    </tr> 
                  </td>                              
                  
                  <td>
                    <tr> 
                      <td style="font-weight: bold; font-size: 11px" align="center">Email</td> 
                      <td style="font-size: 11px"><?php echo e($creditNoteObject->client->email); ?></td>
                    </tr>
                  </td>                  
                </tr>                
              </tbody>
            </table> 
          </td>

          <td style="width: 4%"></td>
          
          <td style="width: 39%">
            <table width="100%" border="0">      
              <tbody>                
                <tr>                  
                  
                  <td>
                    <tr> 
                      <td style="font-weight: bold; width: 50%; font-size: 10px" align="right">SUBTOTAL 12%</td> 
                      <td align="right" style="font-size: 11px">$<?php echo e($creditNoteObject->subtotal_12); ?></td>
                    </tr> 
                  </td>

                  <td>
                    <tr> 
                      <td style="font-weight: bold; width: 50%; font-size: 10px" align="right">SUBTOTAL 0%</td> 
                      <td align="right" style="font-size: 11px">$<?php echo e($creditNoteObject->subtotal_0); ?></td>
                    </tr> 
                  </td>

                  <td>
                    <tr> 
                      <td style="font-weight: bold; width: 50%; font-size: 10px" align="right">SUBTOTAL NO OBJETO DE IVA</td> 
                      <td align="right" style="font-size: 11px">$<?php echo e($creditNoteObject->subtotal_no_objeto); ?></td>
                    </tr> 
                  </td>

                  <td>
                    <tr> 
                      <td style="font-weight: bold; width: 50%; font-size: 10px" align="right">SUBTOTAL EXENTO IVA</td> 
                      <td align="right" style="font-size: 11px">$<?php echo e($creditNoteObject->subtotal_exento); ?></td>
                    </tr> 
                  </td>
                  
                  <td>
                    <tr> 
                      <td style="font-weight: bold; width: 50%; font-size: 10px" align="right">SUBTOTAL SIN IMPUESTOS</td> 
                      <td align="right" style="font-size: 11px">$<?php echo e($creditNoteObject->subtotal_exento); ?></td>
                    </tr> 
                  </td>                                                

                  <td>
                    <tr> 
                      <td style="font-weight: bold; width: 50%; font-size: 10px" align="right">IVA 12%</td> 
                      <td align="right" style="font-size: 11px">$<?php echo e($creditNoteObject->total_12); ?></td>
                    </tr> 
                  </td>                  

                  <td>
                    <tr> 
                      <td style="font-weight: bold; width: 50%; font-size: 10px" align="right">VALOR TOTAL</td> 
                      <td align="right" style="font-size: 11px">$<?php echo e($creditNoteObject->total); ?></td>
                    </tr> 
                  </td>
                </tr>

              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>    