@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Datos Maestros</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/')}}">Inicio</a>
                </li>
                <li>
                    <a href="{{ url('/entitymasterdata')}}">Datos Maestros</a>
                </li>
                <li class="active">
                    <strong>Nuevo Datos Maestros</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight" ng-controller="EntityMasterDataController as vm" ng-init="vm.readEntityList()">
        <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Nuevo Dato Maestro</h5>
                        <div class="ibox-tools">
                        </div>
                    </div>                    

                    <div class="ibox-content">
                        <br>
                        <form class="form-horizontal" name="FrmEntityMasterData" novalidate="novalidate" ng-submit="vm.create()">
                            <input type="hidden" ng-model="vm.entitymasterdata.entity_id"/>
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Entidad</label>
                                <div class="col-lg-6">                                                                    
                                    <select id="entity" class="form-control" ng-options="entity.name for entity in vm.EntityList track by entity.id" ng-model="vm.entitymasterdata.entity" required>
                                    </select>
                                </div>
                            </div>         
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Código</label>
                                <div class="col-lg-6"><input id="code" type="text" ng-model="vm.entitymasterdata.code" placeholder="Código de Dato Maestro" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Nombre</label>
                                <div class="col-lg-6"><input id="name" ng-model="vm.entitymasterdata.name" type="text" placeholder="Nombre Dato Maestro" class="form-control" required> </div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Descripción</label>
                                <div class="col-lg-6"><input id="description" type="text" ng-model="vm.entitymasterdata.description" placeholder="Descripción de Dato Maestro" class="form-control">
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Campo Adicional</label>
                                <div class="col-lg-6"><input id="description" type="text" ng-model="vm.entitymasterdata.field" placeholder="Campo adicional" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 col-lg-offset-1 control-label">Activo</label>
                                <input type="hidden" ng-model="vm.entitymasterdata.is_active" value="1"/>
                                <div class="col-lg-6">
                                    <toggle id="is_client" 
                                            ng-model="vm.activetoggleSelected" 
                                            onstyle="btn-success" on="Si" 
                                            offstyle="btn-danger" off="No">
                                    </toggle>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-md btn-primary" type="submit" >Guardar</button>
                                    <a class="btn btn-md btn-warning" href="{{url('/entitymasterdata')}}">Volver</a>
                                </div>
                            </div>

                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>    
@endsection
