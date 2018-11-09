@extends('layouts.app')

@section('content')

    <style type="text/css">
        .ng-binding{
            width: 300px;            
        }
    </style>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Retenciones</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Inicio</a>
                </li>
                <li>
                    <a href="{{ url('/taxdocument')}}">Retenciones</a>
                </li>
                <li class="active">
                    <strong>Nueva Retención</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div id="retention" ng-controller="TaxDocumentController as vm" ng-init="vm.loadCombos({{$_COOKIE['company_id']}}, {{$_COOKIE['branch_office_id']}});vm.company.id={{$_COOKIE['company_id']}}; vm.setBranch({{$_COOKIE['branch_office_id']}})">
        <div class="wrapper wrapper-content animated fadeInRight" >
            <div class="row">
                <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Datos del Sujeto Retenido</h5>    
                                        <div class="ibox-tools">
                                            <button type="button" ng-click='vm.resetRetention()' class="btn btn-sm btn-danger btn-outline"><span class="fa fa-close"></span> Deshacer Retención</button>
                                            <button type="button" ng-click='vm.createRetention()' class="btn btn-sm btn-info btn-outline" ng-show="vm.EnableTaxButton"><span class="fa fa-list-alt"></span> Emitir Retención</button>
                                        </div>                
                                    </div>    
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div angucomplete-alt
                                                  id="proveedores"
                                                  placeholder="Buscar Proveedor"
                                                  pause="100"
                                                  selected-object="vm.selectSupplier"
                                                  local-data="vm.SupplierList"
                                                  search-fields="identification_number,comercial_name"
                                                  title-field="identification_number,comercial_name"
                                                  minlength="1"
                                                  input-class="form-control form-control-small"
                                                  match-class="highlight">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-primary btn-sm" alt="Nuevo Proveedor" data-toggle="modal" data-target="#myModal">
                                                    <i class="fa fa-plus"></i><span> Nuevo Proveedor</span>
                                                </button>
                                            </div>     
                                            <div class="col-lg-4 text-right">                                          
                                                <p>
                                                    <span><strong>Fecha de Emisión:</strong> @{{vm.FechaHoy | date: 'dd/MM/yyyy'}}</span><br/>
                                                </p>
                                            </div>                                      
                                        </div>
                                        <form name="FrmRetencion" ng-submit="vm.create()">
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-lg-4 control-label" id="identification">RUC/Cédula:</label>
                                                    <div class="col-lg-6">
                                                        <input name="identification" disabled="" type="text" value="@{{vm.taxdocumentSupplier.identification}}" placeholder="" class="form-control">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" id="social_reason">Razón Social:</label>
                                                    <div class="col-lg-9">
                                                        <input name="social_reason" disabled="" type="text" placeholder="" class="form-control" value="@{{vm.taxdocumentSupplier.social_reason}}">
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
                                                        <input name="phone" disabled="" type="text" value="@{{vm.taxdocumentSupplier.phone}}" placeholder="" class="form-control btn-sm">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" id="comercial_name">Nombre Comercial:</label>
                                                    <div class="col-lg-9">
                                                        <input name="comercial_name" disabled="" type="text" placeholder="" class="form-control" value="@{{vm.taxdocumentSupplier.comercial_name}}">
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
                                                        <input name="email" disabled="" type="text" value="@{{vm.taxdocumentSupplier.email}}" placeholder="" class="form-control btn-sm">
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" id="address">Dirección:</label>
                                                    <div class="col-lg-9">
                                                        <input name="address" disabled="" type="text" placeholder="" class="form-control" value="@{{vm.taxdocumentSupplier.address}}">
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
                                                            <th style="width: 25%"><center>Comprobante</center></th>
                                                            <th style="width: 15%"><center>Número</center></th>
                                                            <th style="width: 15%"><center>Fecha Emisión</center></th>
                                                            <th style="width: 10%"><center>Base Imponible</center></th>
                                                            <th style="width: 10%"><center>Impuesto Aplicado</center></th>
                                                            <th style="width: 10%"><center>Porcentaje Retención</center></th>
                                                            <th style="width: 10%"><center>Valor Retención</center></th>
                                                            <th style="width: 5%"><center>Acción</center></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="taxDocumentLine in vm.TaxDocumentLine">
                                                            <td>@{{taxDocumentLine.referralDocumentType.name}}</td>
                                                            <td>
                                                                <input class="form-control centrarInput" type="text" ng-model="taxDocumentLine.referral_document" ui-mask="999-999-999999999" ui-mask-placeholder>
                                                            </td>
                                                            <td class="center">
                                                                <input class="form-control centrarInput" type="text" ng-model="taxDocumentLine.doc_emission_date" ng-readonly="true" ng-value="taxDocumentLine.doc_emission_date | date: 'dd/MM/yyyy'">
                                                                {{-- <p class="input-group">
                                                                  <input type="text" class="form-control" uib-datepicker-popup="@{{vm.formatDate}}" ng-model="taxDocumentLine.doc_emission_date" is-open="vm.popup.opened" datepicker-options="vm.dateOptions" ng-required="true" close-text="Cerrar" alt-input-formats="altInputFormats" required readonly="true" />
                                                                  <span class="input-group-btn">
                                                                    <button type="button" class="btn btn-default" ng-click="vm.open()"><i class="glyphicon glyphicon-calendar"></i></button>
                                                                  </span>
                                                                </p> --}}
                                                            </td>
                                                            <td class="center">
                                                                <input class="form-control centrarInput" type="text" ng-model="taxDocumentLine.tax_base_amount" enter-key="vm.updateTaxDocumentLine(taxDocumentLine)">
                                                            </td>
                                                            <td class="center">
                                                                
                                                                <select class="form-control centrarInput" ng-model="taxDocumentLine.taxtypecode"  ng-change="vm.SelectTaxTypeCode(taxDocumentLine,0)" ng-options="tax.name for tax in vm.TaxList track by tax.id">
                                                                </select>
                                                            </td>
                                                            <td class="center">
                                                                <div ng-show="taxDocumentLine.taxtypecode.id == 109"> 
                                                                    
                                                                    <input type="text" placeholder="Impuesto" ng-model="taxDocumentLine.TaxValue" class="form-control centrarInput">

                                                                </div>

                                                                <div ng-show="taxDocumentLine.taxtypecode.id != 109">
                                                                    <select class="form-control centrarInput" ng-model="taxDocumentLine.retentiontypecode"  ng-change="vm.SelectRetentionTypeCode(taxDocumentLine)" ng-options="tax.taxpercentage.name for tax in taxDocumentLine.TaxPercentageList track by tax.id">
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td class="center">
                                                                <input class="form-control centrarInput" type="text" ng-model="taxDocumentLine.tax_total_amount" ng-readonly="true">
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-md btn-danger" ng-click="vm.deleteTaxDocumentLine(taxDocumentLine)"> <i class="fa fa-trash"></i></button>  
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <select chosen
                                                                      data-placeholder="Seleccione Comprobante"
                                                                      no-results-text="'Comprobante no encontrado'"
                                                                      ng-model="vm.referralDocumentTypeSelected"
                                                                      ng-options="retention.id as retention.name for retention in vm.RetentionList"
                                                                      ng-change="vm.SelectReferralDocumentType(vm.referralDocumentTypeSelected)">
                                                                      <option></option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control centrarInput" ng-model="vm.DocumentLine.referral_document" type="text" ui-mask="999-999-999999999" ui-mask-placeholder>
                                                            </td>
                                                            <td>
                                                                <p class="input-group">
                                                                  <input type="text" class="form-control" uib-datepicker-popup="@{{vm.formatDate}}" ng-model="vm.DocumentLine.doc_emission_date" is-open="vm.popup.opened" datepicker-options="vm.dateOptions" ng-required="true" close-text="Cerrar" alt-input-formats="altInputFormats" required readonly="true" />
                                                                  <span class="input-group-btn">
                                                                    <button type="button" class="btn btn-default" ng-click="vm.open()"><i class="glyphicon glyphicon-calendar"></i></button>
                                                                  </span>
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <input class="form-control centrarInput" type="text" ng-model="vm.DocumentLine.tax_base_amount"  value="0" ng-change="vm.updateTaxDocumentLine(vm.DocumentLine,0)" >
                                                            </td>
                                                            <td>                                                                
                                                                <select class="form-control centrarInput" ng-model="vm.DocumentLine.taxtypecode"  ng-change="vm.SelectTaxTypeCode(vm.DocumentLine,0)" ng-options="tax.name for tax in vm.TaxList track by tax.id">
                                                                </select>
                                                            </td>
                                                            <td class="center">
                                                                
                                                                <div ng-show="vm.showRenta !== ''" style="margin-bottom: -10px"> 
                                                                    <div class="input-group m-b">
                                                                        <span class="input-group-addon">
                                                                            <a href="#" data-toggle="modal" data-target="#myModalInfo">
                                                                                <i class="fa fa-question-circle"></i>
                                                                            </a>
                                                                        </span> 
                                                                        <input type="text" ng-model="vm.TaxCode" placeholder="Código" class="form-control">
                                                                    </div>

                                                                    <input style="margin-top: -10px" type="text" placeholder="Impuesto" ng-model="vm.TaxValue" class="form-control centrarInput" ng-change="vm.updateTaxDocumentLine(vm.DocumentLine, 0)">

                                                                </div>

                                                                <div ng-show="vm.showRenta == ''">
                                                                    <select class="form-control centrarInput" ng-model="vm.DocumentLine.retentiontypecode"  ng-change="vm.SelectRetentionTypeCode(vm.DocumentLine, 0)" ng-options="tax.taxpercentage.name for tax in vm.TaxPercentageList track by tax.id">
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input class="form-control centrarInput" type="text" ng-model="vm.DocumentLine.tax_total_amount" disabled="true">
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-md btn-success" ng-click="vm.addTaxDocumentLine(vm.DocumentLine)" ng-disabled="!vm.SupplierId>0"> <i class="fa fa-plus"></i>
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
                            </div>
                            <div class="col-xs-6">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Datos del Documento</h5>              
                                    </div>    
                                    <div class="ibox-content">
                                        <div class="form-group">
                                            <label class="col-lg-7 control-label">Total Retención:</label>
                                            <div class="col-lg-5">
                                                <input name="total_retenciones" disabled="" placeholder="" class="form-control" ng-model="vm.totalTaxDocument" value="@{{vm.totalTaxDocument}}">
                                            </div>
                                            </br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>                                   
            </div>
        </div>    
        {{--Modal para crear los proveedores --}}
        <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-md">
                    <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <div class="ibox-title">
                            <h5>Nuevo Proveedor</h5>         
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="" >
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <form class="horizontal" name="FrmClient" novalidate="novalidate" ng-submit="vm.createSupplier()">  
                                        <div class="form-group">
                                            <input class="form-control" type="hidden" ng-model="vm.company.id" ng-value="'{{Cookie::get('company_id')}}'">                                        
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
                                                ng-model="vm.supplier.identification_number" placeholder="Nro. Documento" class="form-control" required ng-minlength="@{{vm.MinCharIdentification}}" ng-maxlength="@{{vm.MaxCharIdentification}}">  
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Nombre / Razon Social</label>
                                            <input id="social_reason" type="text" 
                                                ng-model="vm.supplier.social_reason" placeholder="Nombre / Razon Social" class="form-control" required>  
                                        </div>

                                        <div class="form-group">
                                            <label>Nombre Comercial</label>
                                            <input id="comercial_name" type="text" 
                                                ng-model="vm.supplier.comercial_name" placeholder="Nombre Comercial" class="form-control">  
                                        </div>

                                        <div class="form-group">
                                            <label>Periodo Fiscal</label>                                            
                                            <input id="tax_period" type="text" ng-model="vm.supplier.tax_period" placeholder="Periodo Fiscal, Ejemplo: 012018" class="form-control" required ng-minlength="6" ng-maxlength="6">                                            
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Teléfono</label>
                                            <input id="phone" type="text" 
                                                ng-model="vm.supplier.phone" placeholder="Teléfono " class="form-control">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Dirección</label>
                                            <input id="address" ng-model="vm.supplier.address" type="text" placeholder="Dirección " class="form-control">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input id="email" ng-model="vm.supplier.email" type="email" placeholder="Email" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Activo</label>
                                            <input type="hidden" ng-model="vm.supplier.is_active" value="1"/>
                                            
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
        {{--Modal para visualizar mensaje de espera al usuario mientras proceso documento del SRI --}}
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

        <div class="modal inmodal" id="myModalInfo" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">

                {{-- <div class="modal-content animated bounceInRight" ng-controller="ClientController as vm" ng-init="vm.company.id={{Cookie::get('company_id')}}"> --}}
                    <div class="modal-content animated bounceInRight">
                    
                    <div class="modal-header">
                        <div class="ibox-title">
                            <h5>Listado de elementos de retención</h5>         
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="" >
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    
                                    <div class="table-responsive">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="width: 97%">

                                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="myTable" aria-describedby="DataTables_Table_0_info" role="grid">
                                            
                                                <thead>
                                                
                                                    <tr role="row">
                                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 65%%;"><center>Detalle de retención</center></th>   

                                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 18%;"><center>% vigente</center></th>                                 

                                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 18%;"><center>Cód. del anexo</center></th> 

                                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>Acciones</center></th> 

                                                    </tr>
                                                
                                                </thead>

                                                <tbody>
                                                </tbody>    
                                            </table>
                                        
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>                        
                    </div> 

                </div>

            </div>
        </div>

    </div>

    <script>
        $(document).ready( function () {                    
            let apiUrl =  '{{env('API_HOST', NULL)}}/entitymasterdataEntityDt/23';            

            $('#myTable').DataTable({
                "processing" : false,
                "serverSide" : true,
                "language": {
                  "url": "/js/spanish.json"
                },
                'ajax'       : {
                    url: apiUrl,
                    dataType: 'json',
                    type: 'get',                    
                    contentType: 'application/json',                                                        
                },
                'columns'    : [                    
                    {data: 'name'},     
                    {data: 'field', className: "text-center"},
                    {data: 'code',  className: "text-center"},                                      
                    {
                        name:       'actions',
                        data:       null,
                        sortable:   false,
                        searchable: false,
                        render: function (data){
                            let actions = '';
                            actions += '<center>'                      
                                    + '<button onclick="selectRetentionObject(\''+data.id+'\',\''+data.code+'\',\''+data.field+'\')" class="btn btn-xs btn-warning" title="Seleccionar elemento a retener" style="margin-right:3px"><i class="fa fa-paper-plane"></i></button></center>';
                            return actions;
                        }
                    }
                ]
            });
        } );

        function selectRetentionObject(id, code, tax){
            angular.element(document.getElementById('retention')).scope().vm.setRetentionTaxObject(id, code, tax);
        }
    </script>
@endsection
