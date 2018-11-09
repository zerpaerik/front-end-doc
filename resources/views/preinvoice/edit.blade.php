@extends('layouts.app')

@section('content')

    <style type="text/css">
        .ng-binding{
            width: 300px;            
        }
    </style>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Facturación Electrónica</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Inicio</a>
                </li>
                <li>
                    <a href="{{ url('invoice/prefactura')}}">Facturación Electrónica</a>
                </li>
                <li class="active">
                    <strong>Editar Proforma</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
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

<div ng-controller="InvoiceController as vm" ng-init="vm.loadCombos({{$_COOKIE['company_id']}}, {{$_COOKIE['branch_office_id']}});vm.edit({{$id}});vm.company.id={{$_COOKIE['company_id']}}">
        <div class="wrapper wrapper-content animated fadeInRight" >
            <div class="row">
                <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Datos del Comprador</h5>    
                                        <div class="ibox-tools">
                                            {{-- <button type="button" class="btn btn-sm btn-danger btn-outline"><span class="fa fa-close"></span> Deshacer Facturación</button> --}}
                                            <button type="button" ng-click="vm.updatePreInvoice({{$id}})" class="btn btn-sm btn-warning"><span class="fa fa-desktop"></span> Modificar Proforma</button>     
                                            <button type="button" ng-click="vm.updatePreInvoice({{$id}}, 1)" class="btn btn-sm btn-info" ng-show="vm.EnableButtons"><span class="fa fa-list-alt"></span> Emitir Factura</button>
                                        </div>                
                                    </div>    
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                {{-- <div angucomplete-alt
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
                                                </div> --}}
                                            </div>
                                            <div class="col-sm-2">
                                                {{-- <button type="button" class="btn btn-primary btn-sm" alt="Nuevo cliente" data-toggle="modal" data-target="#myModal"> --}}
                                                    {{-- <i class="fa fa-plus"></i><span> Nuevo Cliente</span> --}}
                                                </button>
                                            </div> 
                                            <div class="col-lg-4 text-right">                                          
                                                <p>
                                                    <span><strong>Fecha de Emisión:</strong> @{{vm.FechaHoy | date: 'dd/MM/yyyy'}}</span><br/>
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
                                        <br>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                                                <div class="row">
                            <div class="col-lg-3">
                                <label>¿Es factura de exportación?</label>
                            </div>
                            <div class="col-lg-1">
                                <toggle id="is_default" 
                                    ng-model="vm.ExportInvoicetoggleSelected" 

                                    onstyle="btn-success" on="Si" 
                                    offstyle="btn-danger" off="No">
                                </toggle>
                            </div>
                            <div class="col-lg-8"></div>
                        </div>
                        <div class="row" ng-show="vm.ExportInvoicetoggleSelected==true">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Datos de Exportación</h5>    
                                        <div class="ibox-tools">
                                        </div>                
                                    </div>
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="incoterm">IncoTerm:</label>
                                                    <div class="col-lg-8">
                                                        <input name="incoterm" type="text" placeholder="Incoterm" class="form-control btn-sm" ng-model="vm.Invoice.inco_term" ng-maxlength="10">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="lugar_incoterm">Lugar Incoterm:</label>
                                                    <div class="col-lg-8">
                                                        <input name="lugar_incoterm" type="text" placeholder="Lugar Incoterm" class="form-control"  ng-model="vm.Invoice.place_inco_term" ng-maxlength="300">
                                                    </div>
                                                 </div>
                                            </div>                                      
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="source_harvour">Puerto Embarque:</label>
                                                    <div class="col-lg-8">
                                                        <input name="source_harvour" type="text" placeholder="Puerto de Embarque" class="form-control btn-sm" ng-model="vm.Invoice.source_harvour" ng-maxlength="300">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="destination_harvour">Puerto Destino:</label>
                                                    <div class="col-lg-8">
                                                        <input name="destination_harvour" type="text" placeholder="Puerto Destino" class="form-control"  ng-model="vm.Invoice.destination_harvour" ng-maxlength="300">
                                                    </div>
                                                 </div>
                                            </div>                                      
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="source_country">Código Pais Origen:</label>
                                                    <div class="col-lg-8">
                                                        <select id="source_countries" class="form-control" ng-options="source.name for source in vm.SourceCountryList track by source.id" ng-model="vm.Invoice.source_countries" ng-change="vm.selectSourceCountry(vm.Invoice.source_countries.id)" required>
                                                        </select>
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="destination_country">Código Pais Destino:</label>
                                                    <div class="col-lg-8">
                                                        <select id="destination_countries" class="form-control" ng-options="destination.name for destination in vm.DestinationCountryList track by destination.id" ng-model="vm.Invoice.destination_countries" ng-change="vm.selectDestinationCountry(vm.Invoice.destination_countries.id)" required>
                                                        </select>
                                                    </div>
                                                 </div>
                                            </div>     
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="seller_harvour">Código Pais Adquisición:</label>
                                                    <div class="col-lg-8">
                                                        <select id="seller_countries" class="form-control" ng-options="seller.name for seller in vm.SellerCountryList track by seller.id" ng-model="vm.Invoice.seller_countries" ng-change="vm.selectSellerCountry(vm.Invoice.seller_countries.id)" required>
                                                        </select>
                                                    </div>
                                                 </div>
                                            </div>                                   
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="international_cargo">Flete Internacional:</label>
                                                    <div class="col-lg-8">
                                                        <input name="international_cargo"  type="text" class="form-control btn-sm" ng-model="vm.Invoice.international_cargo">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="international_secure">Seguro Internacional:</label>
                                                    <div class="col-lg-8">
                                                        <input name="international_secure" type="text" placeholder="" class="form-control"  ng-model="vm.Invoice.international_secure">
                                                    </div>
                                                 </div>
                                            </div>     
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="custom_expenditures">Gastos Aduaneros:</label>
                                                    <div class="col-lg-8">
                                                        <input name="custom_expenditures" type="text" placeholder="" class="form-control"  ng-model="vm.Invoice.custom_expenditures">
                                                    </div>
                                                 </div>
                                            </div>                                   
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="transport_expenditures">Gastos Transporte Otros:</label>
                                                    <div class="col-lg-8">
                                                        <input name="transport_expenditures" type="text" class="form-control btn-sm" ng-model="vm.Invoice.transport_expenditures">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="incoterm_total_no_tax">Incoterm Total sin Impuestos:</label>
                                                    <div class="col-lg-8">
                                                        <input name="incoterm_total_no_tax" type="text" placeholder="" class="form-control"  ng-model="vm.Invoice.inco_term_total_no_tax" ng-maxlength="10">
                                                    </div>
                                                 </div>
                                            </div>     
                                            <div class="col-lg-4">
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
                                                            <th style="width: 35%"><center>Producto</center></th>
                                                            <th style="width: 10%"><center>Cantidad</center></th>
                                                            <th style="width: 15%"><center>Precio Unitario</center></th>
                                                            <th style="width: 10%"><center>Descuento</center></th>
                                                            <th style="width: 10%"><center>IVA</center></th>
                                                            <th style="width: 10%"><center>Sub-total</center></th>
                                                            <th style="width: 5%"><center>Acción</center></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="invoiceLine in vm.InvoiceLine">
                                                            <td>@{{invoiceLine.product.name}} <br/> @{{invoiceLine.product.description}}</td>
                                                            <td><input class="form-control centrarInput" type="text" ng-model="invoiceLine.quantity" enter-key="vm.updateInvoiceLine(invoiceLine)"></td>
                                                            <td class="center"><input class="form-control centrarInput" type="text" ng-model="invoiceLine.unit_price" enter-key="vm.updateInvoiceLine(invoiceLine)"></td>
                                                            <td class="center"><input class="form-control centrarInput" type="text" ng-model="invoiceLine.discount" enter-key="vm.updateInvoiceLine(invoiceLine)"></td>
                                                            {{-- <td class="center"><input class="form-control centrarInput" type="text" ng-model="invoiceLine.country_tax_id" ng-readonly="true"</td> --}}
                                                            <td class="center">
                                                                <select class="form-control centrarInput" ng-model="invoiceLine.tax"  ng-change="vm.taxSelectInvoiceLine(invoiceLine)" ng-options="tax.taxpercentage.name for tax in vm.TaxList track by tax.id" readonly="true">
                                                                </select>
                                                            </td>
                                                            <td class="center"><input class="form-control centrarInput" type="text" ng-model="invoiceLine.subtotal" ng-readonly="true"></td>
                                                            <td><button type="button" class="btn btn-md btn-danger" ng-click="vm.deleteInvoiceLine(invoiceLine)"> <i class="fa fa-trash"></i></button>  </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <select chosen
                                                                      data-placeholder="Seleccione Producto"
                                                                      no-results-text="'Producto no encontrado'"
                                                                      ng-model="vm.productSelected"
                                                                      ng-options="product.id as product.name for product in vm.ProductList"
                                                                      ng-change="vm.selectProduct(vm.productSelected)">
                                                                      <option></option>
                                                                </select>
                                                            </td>
                                                            <td><input class="form-control centrarInput" ng-model="vm.Product.quantity" type="text" value="1" enter-key="vm.updateInvoiceProduct(vm.Product)"></td>
                                                            <td><input class="form-control centrarInput" type="text" ng-model="vm.Product.unit_price" readonly="true"></td>
                                                            <td><input class="form-control centrarInput" type="text" ng-model="vm.Product.discount"  value="0" enter-key="vm.updateInvoiceProduct(vm.Product)"></td>
                                                            {{-- <td><input class="form-control centrarInput" type="text" ng-model="vm.Product.tax"  value="0" enter-key="vm.updateInvoiceProduct(vm.Product)"></td> --}}
                                                            <td><select class="form-control centrarInput" ng-model="vm.Product.tax"  ng-change="vm.taxSelectProduct(vm.Product)" ng-options="tax.taxpercentage.name for tax in vm.TaxList track by tax.id" readonly="true">
                                                            </select>
                                                            </td>
                                                            <td><input class="form-control centrarInput" type="text" ng-model="vm.subtotal" readonly="true"></td>
                                                            <td><button type="button" class="btn btn-md btn-success" ng-click="vm.addInvoiceLine(vm.Product)" ng-disabled="!vm.ClientId>0"> <i class="fa fa-plus"></i></button></td>
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
                                            <strong>Total Factura: @{{vm.totalInvoice}}</strong>
                                        </div>          
                                    </div>    
                                    <div class="ibox-content">
                                       <table class="table table-striped table-responsive">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50%"><center>Forma de Pago</center></th>
                                                    <th style="width: 35%"><center>Monto</center></th>
                                                    <!--<th style="width: 15%"><center>Nro. Referencia</center></th>
                                                    <th style="width: 20%"><center>Banco</center></th>
                                                    <th style="width: 10%"><center>Plazo</center></th>
                                                    <th style="width: 15%"><center>Tiempo</center></th>-->
                                                    <th style="width: 5%"><center>Acción</center></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="invoicePayment in vm.InvoicePayment">
                                                    <td>@{{invoicePayment.paymentType.name}}</td>
                                                    <td><input class="form-control centrarInput" type="text" ng-model="invoicePayment.mount" ng-change="vm.ChancePaymentMount(invoicePayment)"></td>
                                                    <!--<td class="text-right">@{{invoicePayment.document_number}}</td>
                                                    <td class="text-right">@{{invoicePayment.bank.name}}</td>
                                                    <td class="text-right">@{{invoicePayment.time_limit}}</td>
                                                    <td class="text-right">@{{invoicePayment.timeUnit.name}}</td>-->
                                                    <td><button type="button" class="btn btn-md btn-danger" ng-click="vm.deleteInvoicePayment(invoicePayment)" > <i class="fa fa-trash"></i></button>  </td>
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
                                                    <td><input class="form-control centrarInput" ng-model="vm.InvoicePaymentType.mount" enter-key="vm.updateInvoicePaymentType(vm.InvoicePaymentType)"></td>
                                                   <!-- <td><input class="form-control text-right" type="text" ng-model="vm.InvoicePaymentType.document_number" ></td>
                                                    <td>
                                                        <select chosen
                                                              placeholder="Seleccione Banco"
                                                              no-results-text="'Banco no encontrada'"
                                                              ng-model="vm.bankSelected"
                                                              ng-options="bank.id as bank.name for bank in vm.BankList"
                                                              ng-change="vm.selectBank(vm.bankSelected)">
                                                              <option></option>
                                                        </select>
                                                    </td>
                                                    <td><input class="form-control center" ng-model="vm.InvoicePaymentType.time_limit" type="number" value="1"></td>
                                                    <td>
                                                        <select chosen
                                                              placeholder="Seleccione Tiempo"
                                                              no-results-text="'Tiempo no encontrado'"
                                                              ng-model="vm.TimeUnitSelected"
                                                              ng-options="timeUnit.id as timeUnit.name for timeUnit in vm.TimeUnitList"
                                                              ng-change="vm.selectTimeUnit(vm.TimeUnitSelected)">
                                                              <option></option>
                                                        </select>
                                                    </td>-->
                                                    <td><button type="button" class="btn btn-md btn-success" ng-click="vm.addInvoicePayment(vm.InvoicePaymentType)" ng-disabled="!vm.InvoiceLine.length>0"> <i class="fa fa-plus"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>                                 
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Valores de Factura</h5>              
                                    </div>    
                                    <div class="ibox-content">
                                        {{-- <div class="row"> --}}
                                            {{-- <div class="col-lg-12"> --}}
                                                <div class="form-group">
                                                    <label class="col-lg-7 control-label">Subtotal sin impuestos:</label>
                                                    <div class="col-lg-5">
                                                        <input name="documento_subtotal_sin_impuestos" disabled="" placeholder="" class="form-control" ng-model="vm.totalInvoiceNoTax" value="@{{vm.totalInvoiceNoTax | number:2}}">
                                                    </div>
                                                </div>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="col-lg-7 control-label" id="etiqueta_subtotal_iva">Subtotal 12 %:</label>

                                                    <div class="col-lg-5">
                                                        <input name="documento_subtotal_12" disabled="" placeholder="" class="form-control" ng-model="vm.subtotal_iva_12" value="@{{vm.subtotal_iva_12 | number:2"}}>
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
                                                {{-- <div class="form-group">
                                                    <label class="col-lg-6 control-label">Valor ICE:</label>
                                                    <div class="col-lg-6">
                                                        <input name="documento_ice" disabled="" type="text" placeholder="" class="form-control">
                                                    </div>
                                                </div> --}}
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="col-lg-7 control-label" id="etiqueta_iva">IVA 12%:</label>
                                                    <div class="col-lg-5">
                                                        <input name="documento_iva" disabled="" placeholder="" class="form-control" ng-model="vm.total_iva_12" value="@{{vm.total_iva_12 | number:2}}">
                                                    </div>
                                                </div>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="col-lg-7 control-label">Propina 10%: 
                                                        <toggle id="is_tip" 
                                                                ng-model="vm.tiptoggleSelected" 
                                                                onstyle="btn-success" on="Si" 
                                                                offstyle="btn-danger" off="No"
                                                                ng-change="vm.calculateTip()">
                                                        </toggle>   
                                                    </label>
                                                    <div class="col-lg-5">
                                                        <input name="tip" ng-model="vm.Invoice.tip" value="@{{vm.Invoice.tip | number:2}}" disabled="!vm.tiptoggleSelected" placeholder="" class="form-control" >
                                                    </div>
                                                </div>                                                
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="col-lg-7 control-label">Valor Total:</label>
                                                    <div class="col-lg-5">
                                                        <input name="documento_valor_total" disabled="" placeholder="" class="form-control" ng-model="vm.totalInvoice" value="@{{vm.totalInvoice | number:2}}">
                                                    </div>
                                                </div>
                                                <br>
                                            {{-- </div>                                  --}}
                                        {{-- </div>          --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>                                   
            </div>
        </div>    

</div>

@endsection
