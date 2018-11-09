@extends('layouts.app')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Nota de Débito</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Inicio</a>
                </li>
                <li>
                    <a href="#">Nota de Débito</a>
                </li>
                <li class="active">
                    <strong>Nueva Nota de Débito</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div ng-controller="DebitNoteController as vm" ng-init="vm.loadCombos({{$_COOKIE['company_id']}}, {{$_COOKIE['branch_office_id']}});vm.company.id={{$_COOKIE['company_id']}}">
        <div class="wrapper wrapper-content animated fadeInRight" >
            <div class="row">
                <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Datos de la Factura</h5>    
                                        <div class="ibox-tools">
                                            <button type="button" ng-click="vm.resetDebitNote()" class="btn btn-sm btn-danger btn-outline"><span class="fa fa-close"></span> Deshacer Nota de Débito</button>
                                            <button type="button" ng-click='vm.createDebitNote()' class="btn btn-sm btn-info btn-outline" ng-show="vm.EnableButtons"><span class="fa fa-list-alt"></span> Emitir Nota de Débito</button>
                                        </div>                
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
                                            <div class="col-sm-2">
                                            </div>     
                                            <div class="col-lg-4 text-right">                                          
                                                <p>
                                                    <span><strong>Fecha Emisión Nota Crédito:</strong> @{{vm.FechaHoy | date: 'dd/MM/yyyy'}}</span><br/>
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
                                                        <input name="identification" disabled="" type="text" value="@{{vm.Invoice.client.identification_number}}" placeholder="" class="form-control">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" id="social_reason">Razón Social:</label>
                                                    <div class="col-lg-9">
                                                        <input name="social_reason" disabled="" type="text" placeholder="" class="form-control" value="@{{vm.Invoice.client.social_reason}}">
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
                                                        <input name="phone" disabled="" type="text" value="@{{vm.Invoice.client.phone}}" placeholder="" class="form-control btn-sm">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" id="comercial_name">Nombre Comercial:</label>
                                                    <div class="col-lg-9">
                                                        <input name="comercial_name" disabled="" type="text" placeholder="" class="form-control" value="@{{vm.Invoice.client.comercial_name}}">
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
                                                        <input name="email" disabled="" type="text" value="@{{vm.Invoice.client.email}}" placeholder="" class="form-control btn-sm">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" id="address">Dirección:</label>
                                                    <div class="col-lg-9">
                                                        <input name="address" disabled="" type="text" placeholder="" class="form-control" value="@{{vm.Invoice.client.address}}">
                                                    </div>
                                                 </div>
                                            </div>                                      
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="email">Fecha Emisión:</label>
                                                    <div class="col-lg-8">
                                                        <input name="fecha_emision" disabled="" type="text" value="@{{vm.Invoice.invoice_date | date: 'dd/MM/yyyy'}}" placeholder="" class="form-control btn-sm">
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
                                        <h5>Detalles</h5>              
                                    </div>    
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 25%"><center>Razón de la Modificación</center></th>
                                                            <th style="width: 10%"><center>Valor de la Modificación</center></th>
                                                            <th style="width: 10%"><center>IVA</center></th>
                                                            <th style="width: 5%"><center>Acción</center></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="debitnoteLine in vm.TaxDocumentLine">
                                                            <td>
                                                                <input class="form-control" ng-model="debitnoteLine.reason">
                                                            </td>
                                                            <td class="center">
                                                                <input class="form-control centrarInput" type="text" ng-model="debitnoteLine.tax_base_amount" ng-change="vm.updateTaxDocumentLine(debitnoteLine)">
                                                            </td>
                                                            <td class="center">
                                                                <select class="form-control centrarInput" ng-model="debitnoteLine.tax"  ng-change="vm.taxSelectTaxDocumentLine(debitnoteLine)" ng-options="tax.taxpercentage.name for tax in vm.TaxList track by tax.id" disabled="true">
                                                                </select>
                                                            </td>
                                                            
                                                            <td>
                                                                <button type="button" class="btn btn-md btn-danger" ng-click="vm.deleteTaxDocumentLine(debitnoteLine)"> <i class="fa fa-trash"></i></button>  
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input class="form-control" ng-model="vm.TaxDocumentDetail.reason" type="text" value="1">
                                                            </td>
                                                            <td>
                                                                <input class="form-control centrarInput" ng-model="vm.TaxDocumentDetail.amount" type="text" value="1">
                                                            </td>
                                                            <td>
                                                                <select class="form-control centrarInput" ng-model="vm.TaxDocumentDetail.tax"  ng-change="vm.taxSelect()" ng-options="tax.taxpercentage.name for tax in vm.TaxList track by tax.id">
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-md btn-success" ng-click="vm.addTaxDocumentLine(vm.TaxDocumentDetail)" ng-disabled="!vm.InvoiceId>0"> <i class="fa fa-plus"></i>
                                                                </button>
                                                            </td>
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
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Formas de Pago</h5>
                                        <div class="ibox-tools">
                                            <strong>Total Nota de Débito: @{{vm.totalDebitNote}}</strong>
                                        </div>          
                                    </div>    
                                    <div class="ibox-content">
                                       <table class="table table-striped table-responsive">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50%"><center>Forma de Pago</center></th>
                                                    <th style="width: 35%"><center>Monto</center></th>
                                                    <th style="width: 5%"><center>Acción</center></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="debitNotePayment in vm.DebitNotePayment">
                                                    <td>@{{debitNotePayment.paymentType.name}}</td>
                                                    <td><input class="form-control centrarInput" type="text" ng-model="debitNotePayment.mount" ng-change="vm.ChancePaymentMount(debitNotePayment)"></td>
                                                    <td><button type="button" class="btn btn-md btn-danger" ng-click="vm.deleteDebitNotePayment(debitNotePayment)" > <i class="fa fa-trash"></i></button>  </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <select chosen
                                                              placeholder="Seleccione Forma de Pago"
                                                              no-results-text="'Forma de Pago no encontrada'"
                                                              ng-model="vm.paymentTypeSelected"
                                                              ng-options="payment.id as payment.name for payment in vm.PaymentTypeList"
                                                              ng-change="vm.selectPayment(vm.paymentTypeSelected)">
                                                              <option></option>
                                                        </select>
                                                    </td>
                                                    <td><input class="form-control centrarInput" ng-model="vm.DebitNotePaymentType.mount" enter-key="vm.updateDebitNotePaymentType(vm.DebitNotePaymentType)"></td>
                                                   
                                                    <td><button type="button" class="btn btn-md btn-success" ng-click="vm.addDebitNotePayment(vm.DebitNotePaymentType)" ng-disabled="!vm.TaxDocumentLine.length>0"> <i class="fa fa-plus"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>                                 
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Valores Nota de Débito</h5>              
                                    </div>    
                                    <div class="ibox-content">
                                                <div class="form-group">
                                                    <label class="col-lg-7 control-label">Subtotal sin impuestos:</label>
                                                    <div class="col-lg-5">
                                                        <input name="documento_subtotal_sin_impuestos" disabled="" placeholder="" class="form-control" ng-model="vm.totalDebitNoteNoTax" value="@{{vm.totalDebitNoteNoTax | number:2}}">
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
                                                    <label class="col-lg-7 control-label" id="etiqueta_iva">IVA 12%:</label>
                                                    <div class="col-lg-5">
                                                        <input name="documento_iva" disabled="" placeholder="" class="form-control" ng-model="vm.total_iva_12" value="@{{vm.total_iva_12 | number:2}}">
                                                    </div>
                                                </div>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="col-lg-7 control-label">Valor Total:</label>
                                                    <div class="col-lg-5">
                                                        <input name="documento_valor_total" disabled="" placeholder="" class="form-control" ng-model="vm.totalDebitNote" value="@{{vm.totalDebitNote | number:2}}">
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
