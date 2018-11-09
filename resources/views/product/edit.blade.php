@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Productos</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Inicio</a>
                </li>
                <li>
                    <a href="{{ url('/product') }}">Productos</a>
                </li>
                <li class="active">
                    <strong>Editar producto</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div class="wrapper wrapper-content animated fadeInRight" ng-controller='ProductController as vm' ng-init="vm.edit({{$id}}, 28)">
        <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Editar producto</h5>                        
                    </div>     

                    <div class="row">
                        <form class="form-horizontal" name="FrmProduct" novalidate="novalidate" ng-submit="vm.update({{Cookie::get('company_id')}})">    
                            <div class="col-sm-12">
                            <div class="tabs-container">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#tab-1"> Datos Básicos</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-2">Impuestos Asociados</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="tab-1" class="tab-pane active">
                                            <div class="panel-body">
                                                <div class="form-group"><input type="hidden" name="company_id" ng-model="vm.product.company_id">  </div>
                                                <div class="form-group col-xs-6">
                                                    <label >Nombre</label>
                                                    <input id="name" ng-model="vm.product.name" type="text" placeholder="Nombre del producto" class="form-control" required>
                                                </div>

                                                <div class="col-xs-1"></div>
                                                <div class="form-group col-xs-5">
                                                    <label>Código principal</label>
                                                    <input id="principal_code" ng-model="vm.product.principal_code" type="text" placeholder="Código principal del producto" class="form-control" required>
                                                </div>
                                                
                                                <div class="form-group col-xs-6">
                                                    <label>Descripción</label>
                                                    <input id="description" ng-model="vm.product.description" type="text" placeholder="Descripción del producto" class="form-control">
                                                </div>

                                                <div class="col-xs-1"></div>
                                                <div class="form-group col-xs-5">
                                                    <label>Genérico</label>
                                                    <input id="generic" ng-model="vm.product.generic" type="text" placeholder="Genérico" class="form-control">
                                                </div>
                                                
                                                
                                                <div class="form-group col-xs-6">
                                                    <label>Código auxiliar</label>
                                                    <input id="auxiliary_code" ng-model="vm.product.auxiliary_code" type="text" placeholder="Código auxiliar del producto" class="form-control">
                                                </div>

                                                <div class="col-xs-1"></div>
                                                <div class="form-group col-xs-5">
                                                    <label>Precio unitario</label>
                                                    <input id="unit_price" ng-model="vm.product.unit_price" type="text" step=".0001" placeholder="Precio unitario" class="form-control">
                                                </div>
                                                
                                                <div class="form-group col-xs-6">
                                                    <label>Costo unitario</label>
                                                    <input id="unit_cost" ng-model="vm.product.unit_cost" type="text" step=".0001" placeholder="Costo unitario" class="form-control">
                                                </div>

                                                <div class="col-xs-1"></div>
                                                <div class="form-group col-xs-5">
                                                    <label>Stock mínimo</label>
                                                    <input id="min_stock" ng-model="vm.product.min_stock" type="text" placeholder="Stock mínimo" class="form-control" required>
                                                </div>
                                                
                                                <div class="form-group col-xs-6">
                                                    <label>Stock máximo</label>
                                                    <input id="max_stock" ng-model="vm.product.max_stock" type="text" placeholder="Stock máximo" class="form-control">
                                                </div>

                                                <div class="col-xs-1"></div>
                                                <div class="form-group col-xs-5">
                                                    <label>Ubicación</label>
                                                    <input id="location" ng-model="vm.product.location" type="text" placeholder="Ubicación" class="form-control" ng-maxlength="100">
                                                </div>

                                                <div class="form-group col-xs-6">
                                                    <label>Laboratorio o Empresa</label>
                                                    <input id="laboratory" ng-model="vm.product.laboratory" type="text" placeholder="Laboratorio" class="form-control" ng-maxlength="50">
                                                </div>
                                                <div class="col-xs-1"></div>

                                                <div class="form-group col-xs-2">
                                                    <label>Fecha Caducidad</label>
                                                    {{-- <label>Fecha Caducidad</label>
                                                    <input id="expired_date" ng-model="vm.product.expired_date" type="text" placeholder="Fecha de Caducidad" class="form-control"> --}}
                                                    <p class="input-group">
                                                      <input type="text" class="form-control" uib-datepicker-popup="@{{vm.formatDate}}" ng-model="vm.product.expired_date" is-open="vm.popup.opened" datepicker-options="vm.dateOptions" close-text="Cerrar" alt-input-formats="altInputFormats" readonly="true" />
                                                      <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default" ng-click="vm.open()"><i class="glyphicon glyphicon-calendar"></i></button>
                                                      </span>
                                                    </p>
                                                </div>

                                                <div class="row"></div>

                                                <div class="form-group col-xs-3">
                                                    <label>Activo para la compra</label>
                                                    <input type="hidden" ng-model="vm.producto.is_purchase_active" value="1"/>
                                                    <toggle id="is_purchase_active" 
                                                            ng-model="vm.purchasetoggleSelected" 
                                                            onstyle="btn-success" on="Si" 
                                                            offstyle="btn-danger" off="No">
                                                    </toggle>
                                                </div>
                                                <div class="form-group col-xs-3">
                                                    <label >Activo para la venta</label>
                                                    <input type="hidden" ng-model="vm.producto.is_sale_active" value="1"/>
                                                    <toggle id="is_sales_active" 
                                                            ng-model="vm.salestoggleSelected" 
                                                            onstyle="btn-success" on="Si" 
                                                            offstyle="btn-danger" off="No">
                                                    </toggle>
                                                </div>
                                                <div class="form-group col-xs-3">
                                                    <label>Activo</label>
                                                    <input type="hidden" ng-model="vm.producto.is_active" value="1"/>
                                                    <toggle id="is_active" 
                                                            ng-model="vm.activetoggleSelected" 
                                                            onstyle="btn-success" on="Si" 
                                                            offstyle="btn-danger" off="No">
                                                    </toggle>   
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab-2" class="tab-pane">
                                            <div class="panel-body">
                                                <table class="table table-bordered table-hover table-condensed table-responsive">
                                                    <thead>
                                                        <th width="40%">Impuesto</th>
                                                        <th width="20%">Tipo Porcentaje</th>
                                                        <th width="20%">Tasa</th>
                                                        <th width="10%">Defecto</th>
                                                        <th width="10%">Acción</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="producttax in vm.ProductTaxList">
                                                            <td>@{{producttax.countrytax.tax.name}}</td>
                                                            <td>@{{producttax.countrytax.taxpercentage.name}}</td>
                                                            <td>@{{producttax.countrytax.value}}</td>
                                                            <td align="center">
                                                                <div ng-show="producttax.is_default===1">
                                                                    <center><span class="label label-primary">Si</span></center>
                                                                </div>
                                                                <div ng-show="producttax.is_default===0">
                                                                    <center><span class="label label-danger">No</span></center>
                                                                </div>
                                                            </td>

                                                            <td><button type="button" class="btn btn-md btn-danger" ng-click="vm.deleteProductTax(producttax)"><i class="fa fa-trash"></i> </button></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <select chosen
                                                                      data-placeholder="Seleccione Impuesto"
                                                                      no-results-text="'Impuesto no encontrado'"
                                                                      ng-model="vm.taxSelected"
                                                                      ng-options="tax.id as tax.taxpercentage.name for tax in vm.CountryTaxList"
                                                                      ng-change="vm.selectProductTax(vm.taxSelected)">
                                                                      <option></option>
                                                                </select></td>
                                                            <td>@{{vm.TipoPorcentaje}}</td>
                                                            <td>@{{vm.Tasa}}</td>
                                                            <td>
                                                                <toggle id="is_default" 
                                                                    ng-model="vm.defaultTaxtoggleSelected" 
                                                                    onstyle="btn-success" on="Si" 
                                                                    offstyle="btn-danger" off="No">
                                                                </toggle>
                                                            </td>
                                                            <td><button type="button" class="btn btn-md btn-success" ng-click="vm.addProductTax()" ng-disabled="!vm.enableButton"><i class="fa fa-plus"></i> </button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-1 col-lg-10">
                                    <button class="btn btn-md btn-primary" type="submit" >Guardar</button>
                                    <a class="btn btn-md btn-warning" href="{{url('/product')}}">Volver</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
