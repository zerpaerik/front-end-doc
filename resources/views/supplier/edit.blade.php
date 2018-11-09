@extends('layouts.app')

@section('content')
    <!--  -->
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Proveedor</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/')}}">Inicio</a>
                </li>
                <li>
                    <a href="{{ url('/supplier')}}">Proveedores</a>
                </li>
                <li class="active">
                    <strong>Editar Proveedor</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight" ng-controller='SupplierController as vm' ng-init="vm.edit({{$id}}, {{$_COOKIE['userRole']}}, {{$_COOKIE['company_id']}})">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Editar Proveedor</h5>
                        <div class="ibox-tools">
                                                                                
                        </div>
                    </div>                    

                    <div class="ibox-content">
                        <br>
                        <form class="form-horizontal" name="FrmClient" novalidate="novalidate" ng-submit="vm.update()">  
                            <input type="hidden" ng-model="vm.supplier.id">     
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Compañía</label>
                                <div class="col-lg-6">                                                                    
                                    <select id="company" class="form-control" ng-options="company.name for company in vm.CompanyList track by company.id" ng-model="vm.supplier.company" required>
                                    </select>
                                </div>
                            </div>   

                            <div class="form-group">
                                <label class="col-lg-2 col-lg-offset-1 control-label">Tipo de Documento</label>
                                <div class="col-lg-6">
                                    <select ng-model="vm.IdentificationTypeSelected" class="form-control" 
                                        ng-options="identification.name for identification in vm.IdentificationTypeList track by identification.id"
                                        ng-change="vm.selectIdentification(vm.IdentificationTypeSelected)"> 
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 col-lg-offset-1 control-label">Nro. Documento</label>
                                <div class="col-lg-6">
                                    <input id="nro_documento" type="text" 
                                        ng-model="vm.supplier.identification_number" placeholder="Nro. Documento" class="form-control" required ng-minlength="@{{vm.MinCharIdentification}}" ng-maxlength="@{{vm.MaxCharIdentification}}">  
                                </div>
                            </div>                         
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Nombre / Razon Social</label>
                                <div class="col-lg-6"><input id="social_reason" type="text" 
                                    ng-model="vm.supplier.social_reason" placeholder="Nombre / Razon Social" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Nombre Comercial</label>
                                <div class="col-lg-6"><input id="comercial_name" type="text" 
                                    ng-model="vm.supplier.comercial_name" placeholder="Nombre Comercial" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 col-lg-offset-1 control-label">Periodo Fiscal</label>
                                <div class="col-lg-6">
                                    <input id="tax_period" type="text" ng-model="vm.supplier.tax_period" placeholder="Periodo Fiscal, Ejemplo: 012018" class="form-control" required ng-minlength="6" ng-maxlength="6">
                                </div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Teléfono</label>
                                <div class="col-lg-6"><input id="phone" type="text" 
                                    ng-model="vm.supplier.phone" placeholder="Teléfono " class="form-control"></div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Dirección</label>
                                <div class="col-lg-6"><input id="address" ng-model="vm.supplier.address" type="text" placeholder="Dirección " class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Email</label>
                                <div class="col-lg-6"><input id="email" ng-model="vm.supplier.email" type="email" placeholder="Email" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 col-lg-offset-1 control-label">Activo</label>
                                <div class="col-lg-6">
                                    <toggle id="is_supplier" 
                                            ng-model="vm.toggleSelected" 
                                            onstyle="btn-success" on="Si" 
                                            offstyle="btn-danger" off="No">
                                    </toggle>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-md btn-primary" type="submit">Guardar</button>
                                    <a class="btn btn-md btn-warning" href="{{url('/supplier')}}">Volver</a>
                                </div>
                            </div>

                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
