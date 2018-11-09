@extends('layouts.app')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight" ng-controller="MailConfigurationController as vm" ng-init="vm.edit({{$id}})">
        <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Editar Configuración de Correo</h5>
                        <div class="ibox-tools">
                        </div>
                    </div>                    

                    <div class="ibox-content">
                        <br>
                        <form class="form-horizontal" name="FrmMailConfig" novalidate="novalidate" ng-submit="vm.update()" >
                            <input type="hidden" ng-model="vm.MailConfiguration.id">
                            <input type="hidden" id="company_id" ng-model="vm.MailConfiguration.company_id" value="1">
                            <div class="form-group">
                                <div class="col-sm-2"><label class="control-label">Asunto</label></div>
                                <div class="col-sm-10"><input type="text" class="form-control" ng-model="vm.MailConfiguration.subject" value=""></div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2"><label class="control-label">Cuerpo</label></div>
                                <div class="col-sm-10"><input type="text" class="form-control" ng-model="vm.MailConfiguration.body" value=""></div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2"><label class="control-label">Leyenda</label></div>
                                <div class="col-sm-10"><input type="text" class="form-control" ng-model="vm.MailConfiguration.legend" value=""></div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2"><label class="control-label">Nombre de Servidor</label></div>
                                <div class="col-sm-4"><input type="text" class="form-control" ng-model="vm.MailConfiguration.host_server" value="" required=""></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2"><label class="control-label">Tipo de Servidor</label></div>
                                <div class="col-sm-4"> 
                                    <input type="hidden" ng-model="vm.server_type_id">
                                    <select name="server_type_id" class="form-control" 
                                        ng-options="serverType.name for serverType in vm.MailServerTypeList track by serverType.id" 
                                        ng-model="vm.MailConfiguration.mailservertype" required>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2"><label class="control-label">Puerto</label></div>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" ng-model="vm.MailConfiguration.port" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2"><label class="control-label">Seguridad Conexión</label></div>
                                <div class="col-sm-4">
                                    <input type="hidden" ng-model="vm.security_type_id">
                                    <select name="server_security_type" class="form-control"
                                    ng-options="mailSecurityType.name for mailSecurityType in vm.MailSecurityTypeList track by mailSecurityType.id" 
                                        ng-model="vm.MailConfiguration.securitytype" required>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2"><label class="control-label">Mét. Identificación</label></div>
                                <div class="col-sm-4">
                                    <select name="server_identification" class="form-control"
                                        ng-options="mailServerIdentificationType.name for mailServerIdentificationType in vm.MailIdentificationTypeList track by mailServerIdentificationType.id" 
                                        ng-model="vm.MailConfiguration.identificationtype" required>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2"><label class="control-label">Nombre de Usuario</label></div>
                                <div class="col-sm-4"><input type="text" class="form-control" ng-model="vm.MailConfiguration.user" value="" required></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2"><label class="control-label">Contraseña</label></div>
                                <div class="col-sm-4"><input type="password" class="form-control" ng-model="vm.MailConfiguration.password" value="" required></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 col-sm-offset-1 control-label">Activo</label>
                                <input type="hidden" ng-model="vm.MailConfiguration.is_active" value="1"/>
                                <div class="col-sm-6">
                                    <toggle id="is_mailconfiguration" 
                                            ng-model="vm.toggleSelected" 
                                            onstyle="btn-success" on="Si" 
                                            offstyle="btn-danger" off="No">
                                    </toggle>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <button class="btn btn-md btn-primary" type="submit" >Guardar</button>
                                    <a class="btn btn-md btn-warning" href="{{url('/mailconfiguration')}}">Volver</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
