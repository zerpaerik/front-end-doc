@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Sucursales</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Inicio</a>
                </li>
                <li>
                    <a href="{{ url('/branch/1') }}">Sucursales</a>
                </li>
                <li class="active">
                    <strong>Editar sucursal</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div class="wrapper wrapper-content animated fadeInRight" ng-controller='BranchController as vm' ng-init="vm.edit({{$id}}, {{$_COOKIE['userRole']}}, {{$_COOKIE['company_id']}})">
        <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Editar sucursal</h5>                        
                    </div>                    

                    <div class="ibox-content">
                        <br>
                        <form class="form-horizontal" name="FrmBranch" novalidate="novalidate" ng-submit="vm.update()">
                            <input type="hidden" ng-model="vm.branch.id">

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Compañía</label>
                                <div class="col-lg-6">                                                                    
                                    <select id="company" class="form-control" ng-options="company.name for company in vm.CompanyList track by company.id" ng-model="vm.company" required>
                                    </select>
                                </div>
                            </div>   

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Nombre</label>
                                <div class="col-lg-6"><input id="name" type="text" ng-model="vm.branch.name" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Teléfono</label>
                                <div class="col-lg-6"><input id="phone" type="text" ng-model="vm.branch.phone" class="form-control"></div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Dirección</label>
                                <div class="col-lg-6"><input id="address" type="text" ng-model="vm.branch.address" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Email</label>
                                <div class="col-lg-6"><input id="email" type="email" ng-model="vm.branch.email" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 col-lg-offset-1 control-label">Tipo de Emisión</label>
                                <div class="col-lg-6">
                                    <select chosen
                                          data-placeholder="Seleccione Emission Type"
                                          no-results-text="'Emission Type no encontrado'" 
                                          ng-model="vm.emissionTypeSelected"
                                          ng-options="emission.id as emission.name for emission in vm.EmissionTypeList"
                                          ng-change="vm.selectEmissionType(vm.emissionTypeSelected)"
                                          required>
                                          <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 col-lg-offset-1 control-label">Tipo de Ambiente</label>
                                <div class="col-lg-6">
                                    <select chosen
                                          data-placeholder="Seleccione Environment Type"
                                          no-results-text="'Environment Type no encontrado'"
                                          ng-model="vm.environmentTypeSelected"
                                          ng-options="environment.id as environment.name for environment in vm.EnvironmentTypeList"
                                          ng-change="vm.selectEnvironmentType(vm.environmentTypeSelected)"
                                          required>
                                          <option></option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Punto de emisión</label>
                                <div class="col-lg-6"><input id="emission_point" type="text" ng-model="vm.branch.emission_point" class="form-control"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 col-lg-offset-1 control-label">Activo</label>
                                <input type="hidden" ng-model="vm.vm.branch.is_active" value="1"/>
                                <div class="col-lg-6">
                                    <toggle id="is_branch" 
                                            ng-model="vm.toggleSelected" 
                                            onstyle="btn-success" on="Si" 
                                            offstyle="btn-danger" off="No">
                                    </toggle>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-10">
                                    <button class="btn btn-md btn-primary" type="submit">Guardar</button>
                                    <a class="btn btn-md btn-warning" href="{{url('/branch')}}">Volver</a>
                                </div>
                            </div>

                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

@endsection
