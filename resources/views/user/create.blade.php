@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Gestión de Usuarios</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Inicio</a>
                </li>
                <li>
                    <a href="{{ url('/user') }}">Usuarios</a>
                </li>
                <li class="active">
                    <strong>Nuevo usuario</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div class="wrapper wrapper-content animated fadeInRight" ng-controller='UserController as vm' ng-init="vm.loadCompanies({{$_COOKIE['userRole']}}, {{$_COOKIE['company_id']}}); vm.loadRole({{$_COOKIE['userRole']}}, {{env('ROLE_SUPERADMIN', NULL)}});">
        <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Nuevo usuario</h5>                        
                    </div>                    

                    <div class="ibox-content">
                        <br>
                        <form class="form-horizontal" name="FrmUser" novalidate="novalidate" ng-submit="vm.create()">                            
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Compañía</label>
                                <div class="col-lg-6">                                                                    
                                    <select id="company_id" name="company_id" class="form-control" ng-options="company.name for company in vm.CompanyList track by company.id" ng-model="vm.company" required ng-change="vm.fillBranch(vm.company.id)">
                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Sucursal</label>
                                <div class="col-lg-6">
                                    <select id="branch_office_id" name="branch_office_id" class="form-control" ng-options="branch.name for branch in vm.BranchList track by branch.id" ng-model="vm.branch.id" required>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Nombre</label>
                                <div class="col-lg-6"><input id="first_name" ng-model="vm.user.first_name" type="text" placeholder="Nombre" class="form-control">
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Apellido</label>
                                <div class="col-lg-6"><input id="last_name" ng-model="vm.user.last_name" type="text" placeholder="Apellido" class="form-control">
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Nombre de usuario</label>
                                <div class="col-lg-6"><input id="username" ng-model="vm.user.username" type="text" placeholder="Nombre de usuario" class="form-control">
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Rol</label>
                                <div class="col-lg-6">
                                    <select id="role" class="form-control" ng-options="rol.name for rol in vm.RoleList track by rol.id" ng-model="vm.role.id" required>
                                    </select>
                                </div>
                            </div> 
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Correo electrónico</label>
                                <div class="col-lg-6"><input id="email" ng-model="vm.user.email" type="text" placeholder="Correo electrónico" class="form-control">
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Contraseña</label>
                                <div class="col-lg-6"><input id="password" ng-model="vm.user.password" type="password" placeholder="Contraseña" class="form-control"></div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Teléfono</label>
                                <div class="col-lg-6"><input id="phone_number" ng-model="vm.user.phone_number" type="text" placeholder="Teléfono" class="form-control">
                                </div>
                            </div>         

                            <div class="form-group">
                                <label class="col-lg-2 col-lg-offset-1 control-label">Activo</label>
                                <input type="hidden" ng-model="vm.permission.is_active" value="1"/>
                                <div class="col-lg-6">
                                    <toggle id="is_plan" 
                                            ng-model="vm.toggleSelected" 
                                            onstyle="btn-success" on="Si" 
                                            offstyle="btn-danger" off="No">
                                    </toggle>
                                </div>
                            </div>                                           

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-10">
                                    <button class="btn btn-md btn-primary" type="submit">Guardar</button>
                                    <a class="btn btn-md btn-warning" href="{{url('/user')}}">Volver</a>
                                </div>
                            </div>

                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

@endsection
