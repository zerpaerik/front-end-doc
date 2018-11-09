@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Permisología de Roles</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/')}}">Inicio</a>
                </li>
                <li>
                    <a href="{{ url('/permission')}}">Permisología de Roles</a>
                </li>       
                <li class="active">
                    <strong>Editar Permisología</strong>
                </li>         
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight" ng-controller="PermissionController as vm" ng-init="vm.readData(); vm.edit({{$id}})">
        <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Editar Permisología</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>                                                        
                        </div>
                    </div>                    

                    <div class="ibox-content">
                        <br>
                        <form class="form-horizontal" name="FrmPlan" novalidate="novalidate" ng-submit="vm.update({{$id}})">
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Nombre del Rol</label>
                                <div class="col-lg-6"><input id="name" type="text" ng-model="vm.permission.role_name" placeholder="Nombre del Rol" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Descripción</label>
                                <div class="col-lg-6"><input id="name" type="text" ng-model="vm.permission.description" placeholder="Descripción del Rol" class="form-control" required>
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

                            <div class="form-group col-lg-6">
                                <table class="table table-hover col-lg-offset-6">
                                    <thead>
                                        <tr>                                        
                                            <th><center>Módulo</center></th>
                                            <th style="width: 10%" ng-repeat="permission in vm.PermissionList"><center>@{{permission.name}}</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="module in vm.ModuleList" ng-init="moduleIndex = $index">                                        
                                            <td><strong>@{{module.name}}</strong></td>
                                            <td ng-repeat="permission in vm.PermissionList" ng-init="permissionIndex = $index">
                                                <center>
                                                    <toggle id="@{{permission.id}}" ng-model="vm.permissionMatriz[moduleIndex][permissionIndex]" 
                                                    onstyle="btn-success" on="Si" 
                                                    offstyle="btn-warning" off="No"  
                                                    ></toggle>
                                                </center>
                                            </td>                                            
                                        </tr>                                        
                                    </tbody>
                                </table>
                            </div>

                            

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-md btn-primary" type="submit" >Guardar</button>
                                    <a class="btn btn-md btn-warning" href="{{url('/permission')}}">Volver</a>
                                </div>
                            </div>

                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>    
@endsection
