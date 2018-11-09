@extends('layouts.app')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Notas de Crédito</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Inicio</a>
                </li>
                <li>
                    <a href="#">Notas de Crédito</a>
                </li>
                <li class="active">
                    <strong>Nueva Nota de Crédito</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div ng-controller="CreditNoteController as vm" ng-init="vm.loadCombos({{$_COOKIE['company_id']}}, {{$_COOKIE['branch_office_id']}});vm.company.id={{$_COOKIE['company_id']}}">
        <div class="wrapper wrapper-content animated fadeInRight" >
            <div class="row">
                <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Datos de la Factura</h5>    
                                        <div class="ibox-tools">
                                            <button type="button" ng-click="vm.resetCreditNote()" class="btn btn-sm btn-danger btn-outline"><span class="fa fa-close"></span> Deshacer Nota de Crédito</button>
                                            <button type="button" ng-click='vm.createCreditNote()' class="btn btn-sm btn-info btn-outline" ng-show="vm.EnableButtons"><span class="fa fa-list-alt"></span> Emitir Nota de Crédito</button>
                                        </div>                
                                    </div>    
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div angucomplete-alt
                                                  id="clientes"
                                                  placeholder="Buscar Clientes"
                                                  pause="100"
                                                  selected-object="vm.selectClient"
                                                  local-data="vm.ClientList"
                                                  search-fields="identification_number,comercial_name"
                                                  title-field="identification_number,comercial_name"
                                                  minlength="1"
                                                  input-class="form-control form-control-small"
                                                  match-class="highlight">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div angucomplete-alt
                                                  id="factura"
                                                  placeholder="Ingrese Número de Factura"
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
                                            <div class="col-lg-4 text-right">                                          
                                                <p>
                                                    <span><strong>Fecha Emisión Nota de Crédito:</strong> @{{vm.FechaHoy | date: 'dd/MM/yyyy'}}</span><br/>
                                                </p>
                                            </div>                                      
                                        </div>
                                       
                                        <form name="FrmInvoice" ng-submit="vm.create()">
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="identification">RUC/Cédula:</label>
                                                    <div class="col-lg-6">
                                                        <input name="identification" disabled="" type="text" value="@{{vm.invoiceclient.identification}}" placeholder="" class="form-control">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" id="social_reason">Razón Social:</label>
                                                    <div class="col-lg-9">
                                                        <input name="social_reason" disabled="" type="text" placeholder="" class="form-control" value="@{{vm.invoiceclient.social_reason}}">
                                                    </div>
                                                 </div>
                                            </div>                                      
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="phone">Teléfono:</label>
                                                    <div class="col-lg-8">
                                                        <input name="phone" disabled="" type="text" value="@{{vm.invoiceclient.phone}}" placeholder="" class="form-control btn-sm">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" id="comercial_name">Nombre Comercial:</label>
                                                    <div class="col-lg-9">
                                                        <input name="comercial_name" disabled="" type="text" placeholder="" class="form-control" value="@{{vm.invoiceclient.comercial_name}}">
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
                                                        <input name="email" disabled="" type="text" value="@{{vm.invoiceclient.email}}" placeholder="" class="form-control btn-sm">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" id="address">Dirección:</label>
                                                    <div class="col-lg-9">
                                                        <input name="address" disabled="" type="text" placeholder="" class="form-control" value="@{{vm.invoiceclient.address}}">
                                                    </div>
                                                 </div>
                                            </div>                                      
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-6">Fecha de Factura: </label>
                                                    <div class="col-lg-6">@{{vm.Invoice.invoice_date}}</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-lg-3">Razón Nota de Crédito</label>
                                                    <div class="col-lg-9"><input name="concept" ng-disabled="!vm.ReasonCreditNote" type="text" placeholder="" class="form-control" ng-model="vm.CreditNote.concept" ng-change="vm.EnableCreditNote()"></div>
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
                                        <h5>Items</h5>              
                                    </div>    
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 5%"><center>Sel.</center></th>
                                                            <th style="width: 35%"><center>Producto</center></th>
                                                            <th style="width: 10%"><center>Cantidad</center></th>
                                                            <th style="width: 15%"><center>Precio Unitario</center></th>
                                                            <th style="width: 10%"><center>Descuento</center></th>
                                                            <th style="width: 10%"><center>IVA</center></th>
                                                            <th style="width: 10%"><center>Sub-total</center></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="invoiceLine in vm.Invoice.invoiceline">
                                                            <td><sb-checkbox label="" ng-model="invoiceLine.check" checked-icon-name="check_box" unchecked-icon-name="check_box_outline_blank" size="small" callback-fn="vm.updateCreditNote()" ></sb-checkbox>
                                                            </td>
                                                            <td>
                                                                <b>Producto:</b> @{{invoiceLine.name}} 
                                                                <br/> 
                                                                <b>Descripción:</b> @{{invoiceLine.description}}
                                                                <div ng-show="invoiceLine.laboratory !== ''">           
                                                                    <b>Genérico:</b> @{{invoiceLine.generic}} 
                                                                    <br>
                                                                    <b>Ubicación:</b> @{{invoiceLine.location}}
                                                                    <br>
                                                                    <b>Laboratorio:</b> @{{invoiceLine.laboratory}} - <b>F. caducidad:</b> @{{invoiceLine.expired_date}}     
                                                                </div>
                                                            </td>
                                                            <td><input class="form-control centrarInput" type="text" ng-model="invoiceLine.quantity" enter-key="vm.updateCreditNoteLine(invoiceLine)"></td>
                                                            <td class="center"><input class="form-control centrarInput" type="text" ng-model="invoiceLine.unit_price" disabled="true"></td>
                                                            <td class="center"><input class="form-control centrarInput" type="text" ng-model="invoiceLine.discount" disabled="true"></td>
                                                            <td class="center">
                                                                <input class="form-control centrarInput" ng-model="invoiceLine.taxes[0].tax_percentage_name"  disabled="true">
                                                                
                                                            </td>
                                                            <td class="center"><input class="form-control centrarInput" type="text" ng-model="invoiceLine.line_sub_total" ng-readonly="true"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>                                   
                                        </div>                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                            </div>
                            <div class="col-xs-6">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Valores de Factura</h5>              
                                    </div>    
                                    <div class="ibox-content">
                                        <div class="form-group">
                                            <label class="col-lg-7 control-label">Subtotal sin impuestos:</label>
                                            <div class="col-lg-5">
                                                <input name="documento_subtotal_sin_impuestos" disabled="" placeholder="" class="form-control" ng-model="vm.totalInvoiceNoTax" value="@{{vm.totalInvoiceNoTax}}">
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="form-group">
                                            <label class="col-lg-7 control-label" id="etiqueta_subtotal_iva">Subtotal 12 %:</label>

                                            <div class="col-lg-5">
                                                <input name="documento_subtotal_12" disabled="" placeholder="" class="form-control" ng-model="vm.subtotal_iva_12" value="@{{vm.subtotal_iva_12 | number:2}}">
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="form-group">
                                            <label class="col-lg-7 control-label">Subtotal 0 %:</label>
                                            <div class="col-lg-5">
                                                <input name="documento_subtotal_0" disabled="" placeholder="" class="form-control" ng-model="vm.subtotal_iva_0" value="@{{vm.subtotal_iva_0 | number:2}}">
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="form-group">
                                            <label class="col-lg-7 control-label">Subtotal No Objeto de IVA:</label>
                                            <div class="col-lg-5">
                                                <input name="documento_subtotal_no_iva" disabled="" placeholder="" class="form-control" ng-model="vm.subtotal_iva_no_objeto" value="@{{vm.subtotal_iva_no_objeto | number:2}}">
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="form-group ">
                                            <label class="col-lg-7 control-label">Subtotal exento de IVA:</label>
                                            <div class="col-lg-5">
                                                <input name="documento_subtotal_exento_iva" disabled="" placeholder="" class="form-control" ng-model="vm.subtotal_iva_exento" value="@{{vm.subtotal_iva_exento | number:2"}}">
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="form-group">
                                            <label class="col-lg-7 control-label">Total descuento:</label>
                                            <div class="col-lg-5">
                                                <input name="documento_total_descuento" disabled="" placeholder="" class="form-control" ng-model="vm.totalDiscount" value="@{{vm.totalDiscount | number:2}}">
                                            </div>
                                        </div>                                                
                                        <br><br>
                                        <div class="form-group">
                                            <label class="col-lg-7 control-label" id="etiqueta_iva">IVA 12%:</label>
                                            <div class="col-lg-5">
                                                <input name="documento_iva" disabled="" placeholder="" class="form-control" ng-model="vm.total_iva_12" value="@{{vm.total_iva_12 | number:2}}">
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="form-group">
                                            <label class="col-lg-7 control-label">Valor Total:</label>
                                            <div class="col-lg-5">
                                                <input name="documento_valor_total" disabled="" placeholder="" class="form-control" ng-model="vm.totalCreditNote" value="@{{vm.totalCreditNote | number:2}}">
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </form>
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

@endsection
