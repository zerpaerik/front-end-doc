@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Compañía</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/')}}">Inicio</a>
                </li>
                <li>
                    <a href="{{ url('/company')}}">Compañías</a>
                </li>
                <li class="active">
                    <strong>Nueva Compañía</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight" ng-controller="CompanyController as vm" ng-init="vm.loadNewCompany()">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Nueva Compañía</h5>
                        <div class="ibox-tools">
                        </div>
                    </div>    

                    <div class="row">
                        <form class="form-horizontal" name="FrmCompany" novalidate="novalidate" ng-submit="vm.create()">
                            <div class="col-sm-12">
                                <div class="tabs-container">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#tab-1"> Datos Básicos</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-2">Datos Fiscales</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-3">Correlativos Documentos</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-4">Logo</a></li>
                                    </ul>
                                     <div class="tab-content">
                                        <div id="tab-1" class="tab-pane active">
                                            <div class="panel-body">
                                                <div class="form-group col-xs-6">
                                                    <label>Nombre</label>
                                                    <input id="name" type="text" ng-model="vm.company.name" placeholder="Nombre de Compañia" class="form-control" required ng-maxlength="180">
                                                </div>
                                                <div class="col-xs-1"></div>
                                                <div class="form-group col-xs-5">
                                                    <label>Nombre Comercial</label>
                                                    <input id="comercial_name" ng-model="vm.company.comercial_name" type="text" placeholder="Nombre Comercial" class="form-control" required ng-maxlength="180"> 
                                                </div>

                                                <div class="form-group col-xs-6">
                                                    <label>RUC</label>
                                                    <input id="ruc" type="text" ng-model="vm.company.ruc" placeholder="RUC" class="form-control" required ng-minlength="13" ng-maxlength="13">
                                                </div>
                                                <div class="col-xs-1"></div>
                                                <div class="form-group col-xs-5">
                                                    <label>Periodo Fiscal</label>
                                                    <input id="tax_year" type="text" ng-model="vm.company.tax_year" placeholder="Periodo Fiscal" class="form-control" required ng-minlength="6" ng-maxlength="6">
                                                </div>

                                                <div class="form-group col-xs-6">
                                                    <label>Url Sitio</label>
                                                    <input id="url" type="text" ng-model="vm.company.url" placeholder="Url Sitio" class="form-control" ng-maxlength="255">
                                                </div>
                                                <div class="col-xs-1"></div>
                                                <div class="form-group col-xs-5">
                                                    <label>Teléfono</label>
                                                    <input id="phone" type="text" 
                                                        ng-model="vm.company.phone" placeholder="Teléfono" class="form-control" ng-maxlength="80">
                                                </div>
                                                
                                                <div class="form-group col-xs-6">
                                                    <label>Dirección</label>
                                                    <input id="address" ng-model="vm.company.address" type="text" placeholder="Dirección" class="form-control" required ng-maxlength="255">
                                                </div>
                                                <div class="col-xs-1"></div>
                                                <div class="form-group col-xs-5">
                                                    <label>Email</label>
                                                    <input id="email" ng-model="vm.company.email" type="email" placeholder="Email" class="form-control">
                                                </div>

                                                <div class="form-group col-xs-6">
                                                    <label class="col-xs-3 control-label">¿Es Artesano?</label>
                                                    <input type="hidden" ng-model="vm.company.is_artisan" value="1"/>
                                                    <div class="col-xs-1">
                                                        <toggle id="is_artisan" 
                                                                ng-model="vm.artisantoggleSelected" 
                                                                onstyle="btn-success" on="Si" 
                                                                offstyle="btn-danger" off="No">
                                                        </toggle>
                                                    </div>
                                                    <div class="col-xs-3"></div>
                                                </div>
                                                <div class="col-xs-1"></div>
                                                <div class="form-group col-xs-5">
                                                    <label>Nro.Registro</label>
                                                    <input id="artesano" ng-model="vm.company.register_number" type="text" placeholder="Nro. Registro Artesano" class="form-control" ng-maxlength="10">
                                                </div>
                                                <div class="col-xs-1"></div>
                                                <div class="row"></div>
                                                <div class="form-group">
                                                    <label class="col-xs-2 control-label">Lleva Contabilidad</label>
                                                    <input type="hidden" ng-model="vm.company.is_accounting" value="1"/>
                                                    <div class="col-xs-1">
                                                        <toggle id="is_accounting" 
                                                                ng-model="vm.accountingtoggleSelected" 
                                                                onstyle="btn-success" on="Si" 
                                                                offstyle="btn-danger" off="No">
                                                        </toggle>
                                                    </div>
                                                    <label class="col-xs-2 control-label">Activo</label>
                                                    <input type="hidden" ng-model="vm.company.is_active" value="1"/>
                                                    <div class="col-xs-1">
                                                        <toggle id="is_active" 
                                                                ng-model="vm.activetoggleSelected" 
                                                                onstyle="btn-success" on="Si" 
                                                                offstyle="btn-danger" off="No">
                                                        </toggle>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                        <div id="tab-2" class="tab-pane">
                                            <div class="panel-body">
                                                <div class="form-group col-xs-6">
                                                    <label>Código Emisión</label>
                                                    <input id="emission_code" type="text" ng-model="vm.company.emission_code" placeholder="Código Emisión" class="form-control" required ng-maxlength="3">
                                                </div>
                                                <div class="col-xs-1"></div>
                                                <div class="form-group col-xs-5">
                                                    <label>Código Especial</label>
                                                    <input id="special_code" type="text" ng-model="vm.company.special_code" placeholder="Código Contribuyente Especial" class="form-control"  ng-minlength="3" ng-maxlength="5">
                                                </div>
                                                <div class="form-group col-xs-6">
                                                    <label>Tipo de Ambiente</label>
                                                    {{-- <input id="environment_type" type="text" ng-model="vm.company.environment_type" placeholder="Tipo de Ambiente" class="form-control" required> --}}
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
                                                <div class="col-xs-1"></div>
                                                <div class="form-group col-xs-5">
                                                    <label>Tipo de Emisión</label>
                                                    {{-- <input id="emission_type" type="text" ng-model="vm.company.emission_type" placeholder="Tipo Emisión" class="form-control" required> --}}
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
                                                <div class="form-group col-xs-6">
                                                    <label>Certificado Digital</label>
                                                    {{-- <input id="digital_certificate" type="text" ng-model="vm.company.digital_certificate" placeholder="Certificado Digital" value="1" class="form-control"> --}}
                                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                        <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                        <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Seleccionar Archivo</span><span class="fileinput-exists">Cambiar</span><input type="file" name="..." accept=".p12"  
                                                        ngf-select="vm.seleccionarCertificado($file)"
                                                        ngf-pattern="'.p12'"></span>
                                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
                                                    </div>
                                                </div>
                                                <div class="col-xs-1"></div>
                                                <div class="form-group col-xs-5">
                                                    <label>Contraseña de Certificado</label>
                                                    <input id="digital_certificate_pass" type="password" ng-model="vm.company.digital_certificate_pass" placeholder="Contraseña de Certificado" class="form-control" required ng-maxlength="50">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab-3" class="tab-pane">
                                            <div class="panel-body">
                                                <table class="table table-bordered table-hover table-condensed table-responsive">
                                                    <thead>
                                                        <th>Tipo de Documento</th>
                                                        <th>Serie</th>
                                                        <th>Correlativo</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="document in vm.CorrelativeDocumentList">
                                                            <td>@{{document.documenttype.name}}</td>
                                                            <td><input type="text" ng-model="vm.CorrelativeDocumentList[$index].serie" value="@{{document.serie}}"></td>
                                                            <td><input type="number" ng-model="vm.CorrelativeDocumentList[$index].increment_number" value="@{{document.increment_number}}"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="tab-4" class="tab-pane">
                                            <div class="panel-body">
                                                <div class="col-xs-6">
                                                    <label>Logo de Compañía</label>
                                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                        <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                        <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Seleccionar Archivo</span><span class="fileinput-exists">Cambiar</span><input type="file" name="..." accept="image/*"  
                                                        ngf-select="vm.seleccionarLogo($file)"
                                                        ngf-pattern="'image/*'" 
                                                        ngf-resize="{width: 300, height: 100}"></span>
                                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
                                                    </div>
                                                </div> 
                                                <div class="col-xs-6">
                                                    <img ng-src="@{{vm.Logo}}" class="drop-box" alt=""/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-1 col-sm-6">
                                                <button class="btn btn-md btn-primary" type="submit" >Guardar</button>
                                                <a class="btn btn-md btn-warning" href="{{url('/company')}}">Volver</a>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>    
@endsection
