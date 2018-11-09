@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Clientes</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Inicio</a>
                </li>                
                <li class="active">
                    <strong>Importar Clientes</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div id="product" class="wrapper wrapper-content animated fadeInRight" ng-controller="ProductController as vm">
        <div class="row">            

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Importar Clientes</h5>
                        <div class="ibox-tools">                            
                            <button class="btn btn-xs btn-primary" ng-click="vm.saveImport()"><span class="fa fa-save"></span> Guardar</button> 
                        </div>
                    </div>                    

                    <div class="ibox-content" >
                        <div class="row">
                            <div class="col-lg-6 col-offset-6">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                    <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Seleccionar Archivo</span><span class="fileinput-exists">Cambiar</span><input type="file" name="..." accept=".xls,.xlsx,.ods" fileread="" opts="vm.gridOptions" multiple="false"></span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
                                </div>
                            </div>
                        </div> 
                        <div id="grid1" ui-grid="vm.gridOptions" class="grid">
                            <div class="grid-msg-overlay" ng-show="!vm.gridOptions.data.length">
                            </div>
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>    
    </div>    


@endsection
