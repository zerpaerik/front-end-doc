<?php $__env->startSection('content'); ?>

    <style type="text/css">
        .ng-binding{
            width: 300px;            
        }
    </style>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Guías de Remisión</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('home')); ?>">Inicio</a>
                </li>
                <li>
                    <a href="<?php echo e(url('/remission')); ?>">Guías de Remisión</a>
                </li>
                <li class="active">
                    <strong>Nueva Guía de Remisión</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div id="retention" ng-controller="RemissionController as vm" ng-init="vm.loadCombos(<?php echo e($_COOKIE['company_id']); ?>, <?php echo e($_COOKIE['branch_office_id']); ?>);vm.company.id=<?php echo e($_COOKIE['company_id']); ?>; vm.setBranch(<?php echo e($_COOKIE['branch_office_id']); ?>)">
        <div class="wrapper wrapper-content animated fadeInRight" >
            <div class="row">
                <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Datos del Transportista</h5>    
                                        <div class="ibox-tools">
                                            <button type="button" ng-click='vm.resetRemission()' class="btn btn-sm btn-danger btn-outline"><span class="fa fa-close"></span> Deshacer Guía de Remisión</button>
                                            <button type="button" ng-click='vm.createRemission()' class="btn btn-sm btn-info btn-outline" ng-show="vm.EnableTaxButton"><span class="fa fa-list-alt"></span> Emitir Guía de Remisión</button>
                                        </div>                
                                    </div>    
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div angucomplete-alt
                                                  id="transportista"
                                                  placeholder="Buscar transportista"
                                                  pause="100"
                                                  selected-object="vm.selectDispatcher"
                                                  local-data="vm.DispatcherList"
                                                  search-fields="identification_number,social_reason"
                                                  title-field="identification_number,social_reason"
                                                  minlength="1"
                                                  input-class="form-control form-control-small"
                                                  match-class="highlight">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-primary btn-sm" alt="Nuevo Transportista" data-toggle="modal" data-target="#myModal">
                                                    <i class="fa fa-plus"></i><span> Nuevo Transportista</span>
                                                </button>
                                            </div>     
                                            <div class="col-lg-4 text-right">                                          
                                                <p>
                                                    <span><strong>Fecha de Emisión Guía Remisión:</strong> {{vm.FechaHoy | date: 'dd/MM/yyyy'}}</span><br/>
                                                </p>
                                            </div>                                      
                                        </div>
                                        <form name="FrmRemission" novalidate="novalidate" ng-submit="vm.createRemission()">
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="identification">RUC/Cédula:</label>
                                                    <div class="col-lg-6">
                                                        <input name="identification" disabled="" type="text" value="{{vm.dispatcher.identification}}" placeholder="" class="form-control">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" id="social_reason">Razón Social:</label>
                                                    <div class="col-lg-9">
                                                        <input name="social_reason" disabled="" type="text" placeholder="" class="form-control" value="{{vm.dispatcher.social_reason}}">
                                                    </div>
                                                 </div>
                                            </div>                                      
                                        </div>
                                        <br>
                                         <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="phone">Teléfono:</label>
                                                    <div class="col-lg-8">
                                                        <input name="phone" disabled="" type="text" value="{{vm.dispatcher.phone}}" placeholder="" class="form-control btn-sm">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" id="address">Dirección:</label>
                                                    <div class="col-lg-9">
                                                        <input name="address" disabled="" type="text" placeholder="" class="form-control" value="{{vm.dispatcher.address}}">
                                                    </div>
                                                 </div>
                                            </div>                                   
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="email">Email:</label>
                                                    <div class="col-lg-8">
                                                        <input name="email" disabled="" type="text" value="{{vm.dispatcher.email}}" placeholder="" class="form-control btn-sm">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" id="email">Placa:</label>
                                                    <div class="col-lg-9">
                                                        <input name="placa" type="text" ng-model="vm.TaxDocument.car_register" placeholder="Placa del Transporte" class="form-control btn-sm" required>
                                                    </div>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Destinatario</h5>    
                                    </div>    
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div angucomplete-alt
                                                  id="factura"
                                                  placeholder="Ingresa Número de Factura"
                                                  pause="100"
                                                  selected-object="vm.selectInvoice"
                                                  local-data="vm.InvoiceList"
                                                  search-fields="referral_code"
                                                  title-field="referral_code"
                                                  minlength="1"
                                                  input-class="form-control form-control-small"
                                                  match-class="highlight">
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-4 text-right">                                          
                                                <p>
                                                    <span><strong>Fecha Emisión de Factura:</strong> {{vm.Invoice.invoice_date | date: 'dd/MM/yyyy'}}</span><br/>
                                                </p>
                                            </div>                                      
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="identification">RUC/Cédula:</label>
                                                    <div class="col-lg-6">
                                                        <input name="identification" disabled="" type="text" value="{{vm.Invoice.client.identification_number}}" placeholder="" class="form-control">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="social_reason">Razón Social:</label>
                                                    <div class="col-lg-8">
                                                        <input name="social_reason" disabled="" type="text" placeholder="" class="form-control" value="{{vm.Invoice.client.social_reason}}">
                                                    </div>
                                                 </div>
                                            </div>                                      
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="email">Motivo Traslado:</label>
                                                    <div class="col-lg-8">
                                                        <input name="starting_point" type="text" ng-model="vm.TaxDocument.reason_transport" placeholder="Motivo de traslado" class="form-control btn-sm" required>
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="email">Número Autorización:</label>
                                                    <div class="col-lg-8">
                                                        <input name="autorizacion" disabled="" type="text" value="{{vm.Invoice.auth_code}}" placeholder="" class="form-control btn-sm">
                                                    </div>
                                                 </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="email">Fecha Salida:</label>
                                                    <div class="col-lg-8">
                                                        <p class="input-group">
                                                          <input type="text" class="form-control" uib-datepicker-popup="{{vm.formatDate}}" ng-model="vm.TaxDocument.startdate_transport" is-open="vm.popup1.opened" datepicker-options="vm.dateOptions" ng-required="true" close-text="Cerrar" alt-input-formats="altInputFormats" required readonly="true" />
                                                          <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default" ng-click="vm.open1()"><i class="glyphicon glyphicon-calendar"></i></button>
                                                          </span>
                                                        </p>
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="email">Fecha Llegada:</label>
                                                    <div class="col-lg-8">
                                                        <p class="input-group">
                                                          <input type="text" class="form-control" uib-datepicker-popup="{{vm.formatDate}}" ng-model="vm.TaxDocument.enddate_transport" is-open="vm.popup2.opened" datepicker-options="vm.dateOptions" ng-required="true" close-text="Cerrar" alt-input-formats="altInputFormats" required readonly="true" />
                                                          <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default" ng-click="vm.open2()"><i class="glyphicon glyphicon-calendar"></i></button>
                                                          </span>
                                                        </p>
                                                    </div>
                                                 </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="email">Origen (Punto de Partida):</label>
                                                    <div class="col-lg-8">
                                                        <input name="source" type="text" ng-model="vm.TaxDocument.starting_point" placeholder="" class="form-control btn-sm">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="email">Destino (Punto de Llegada):</label>
                                                    <div class="col-lg-8">
                                                        <input name="destination" type="text" ng-model="vm.TaxDocument.destination_transport" placeholder="" class="form-control btn-sm" required>
                                                    </div>
                                                 </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="email">Documento Aduanero:</label>
                                                    <div class="col-lg-8">
                                                        <input name="custom_document" type="text" ng-model="vm.TaxDocument.custom_document" placeholder="" class="form-control btn-sm">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="email">Código Establecimiento destino:</label>
                                                    <div class="col-lg-8">
                                                        <input name="destination_branch_code" type="text" ng-model="vm.TaxDocument.destination_branch_code" placeholder="" class="form-control btn-sm" required>
                                                    </div>
                                                 </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="email">Ruta:</label>
                                                    <div class="col-lg-8">
                                                        <input name="route" type="text" ng-model="vm.TaxDocument.route" placeholder="" class="form-control btn-sm" required>
                                                    </div>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5></h5>              
                                    </div>    
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 25%"><center>Código Principal</center></th>
                                                            <th style="width: 25%"><center>Código Auxiliar</center></th>
                                                            <th style="width: 30%"><center>Descripción</center></th>
                                                            <th style="width: 10%"><center>Cantidad</center></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="taxDocumentLine in vm.TaxDocument.taxDocumentLine">
                                                            <td>{{taxDocumentLine.product.principal_code}}</td>
                                                            <td>{{taxDocumentLine.product.auxiliary_code}}</td>
                                                            <td>{{taxDocumentLine.product.name}}</td>
                                                            <td>{{taxDocumentLine.quantity}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>                                   
                                        </div>                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>                                   
            </div>
        </div>    
        
        <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-md">
                    <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <div class="ibox-title">
                            <h5>Nuevo Transportista</h5>         
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="" >
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <form class="horizontal" name="FrmClient" novalidate="novalidate" ng-submit="vm.createDispatcher()">  
                                        <div class="form-group">
                                            <input class="form-control" type="hidden" ng-model="vm.company.id" ng-value="'<?php echo e(Cookie::get('company_id')); ?>'">                                        
                                        </div>

                                        <div class="form-group">
                                            <label>Tipo de Documento</label>
                                            <select ng-model="vm.IdentificationTypeSelected" class="form-control" 
                                                ng-options="identification.name for identification in vm.IdentificationTypeList track by identification.id"
                                                ng-change="vm.selectIdentification(vm.IdentificationTypeSelected)"> 
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Nro. Documento</label>
                                            <input id="nro_documento" type="text" 
                                                ng-model="vm.dispatcher.identification_number" placeholder="Nro. Documento" class="form-control" required ng-minlength="{{vm.MinCharIdentification}}" ng-maxlength="{{vm.MaxCharIdentification}}">  
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Nombre / Razón Social</label>
                                            <input id="social_reason" type="text" 
                                                ng-model="vm.dispatcher.social_reason" placeholder="Nombre / Razon Social" class="form-control" required>  
                                        </div>
                                      
                                        <div class="form-group">
                                            <label>Teléfono</label>
                                            <input id="phone" type="text" 
                                                ng-model="vm.dispatcher.phone" placeholder="Teléfono " class="form-control">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Dirección</label>
                                            <input id="address" ng-model="vm.dispatcher.address" type="text" placeholder="Dirección " class="form-control">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input id="email" ng-model="vm.dispatcher.email" type="email" placeholder="Email" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Activo</label>
                                            <input type="hidden" ng-model="vm.dispatcher.is_active" value="1"/>
                                            
                                            <toggle id="is_client" 
                                                    ng-model="vm.toggleSelected" 
                                                    onstyle="btn-success" on="Si" 
                                                    offstyle="btn-danger" off="No">
                                            </toggle>
                                        </div>   
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                            <button type="submmit" class="btn btn-primary">Guardar</button> 
                                        </div>   
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal inmodal" id="myModalSRI" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <i class="fa fa-laptop modal-icon"></i>
                        <h4 class="modal-title">Esperando respuesta del SRI</h4>
                        
                    </div>
                    <div class="modal-body">
                        <center>
                            <div style="width: 200px; height: 200px">
                                <div class="spiner-example">
                                    <div class="sk-spinner sk-spinner-three-bounce">
                                        <div class="sk-bounce1"></div>
                                        <div class="sk-bounce2"></div>
                                        <div class="sk-bounce3"></div>
                                    </div>
                                </div>
                            </div>
                        </center>
                    </div>                    
                </div>
            </div>
        </div> 

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>