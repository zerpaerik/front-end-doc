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
                    <a href="{{ url('/companyplan')}}">Planes de Compañías</a>
                </li>
                <li class="active">
                    <strong>Nuevo Plan de Compañía</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight" ng-controller='CompanyPlanController as vm' ng-init="vm.loadList()">
        <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Nuevo Plan de Compañía</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>                                                        
                        </div>
                    </div>                    

                    <div class="ibox-content">
                        <br>
                        <form class="form-horizontal" name="FrmCompany" novalidate="novalidate" ng-submit="vm.create()"> 
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Compañía</label>
                                <div class="col-lg-6">                                                                    
                                    <select id="company" class="form-control" ng-options="company.name for company in vm.CompanyList track by company.id" ng-model="vm.company" required>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Plan</label>
                                <div class="col-lg-6">                                                                    
                                    <select id="company" class="form-control" ng-options="plan.name for plan in vm.PlanList track by plan.id" ng-model="vm.plan" required ng-change="vm.selectPlan(vm.plan)">
                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Nro. Documentos</label>
                                <div class="col-lg-6"><input id="document_count" type="text" 
                                    ng-model="vm.plan.document_count" placeholder="Nro. Documentos" class="form-control" readonly="true">
                                </div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Contador Actual</label>
                                <div class="col-lg-6"><input id="current_counter" type="text" 
                                    ng-model="vm.companyplan.current_counter" placeholder="Contador Actual" class="form-control" required></div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Fecha desde</label>
                                <div class="col-lg-3">
                                    <p class="input-group">
                                      <input type="text" class="form-control" uib-datepicker-popup="@{{vm.formatDate}}" ng-model="vm.companyplan.start_date" is-open="vm.popup1.opened" datepicker-options="vm.dateOptions" ng-required="true" close-text="Cerrar" alt-input-formats="altInputFormats" required readonly="true" />
                                      <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="vm.open1()"><i class="glyphicon glyphicon-calendar"></i></button>
                                      </span>
                                    </p>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Fecha hasta</label>
                                <div class="col-lg-3">
                                    <p class="input-group">
                                      <input type="text" class="form-control" uib-datepicker-popup="@{{vm.formatDate}}" ng-model="vm.companyplan.end_date" is-open="vm.popup2.opened" datepicker-options="vm.dateOptions" ng-required="true" close-text="Cerrar" alt-input-formats="altInputFormats" required readonly="true" />
                                      <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="vm.open2()"><i class="glyphicon glyphicon-calendar"></i></button>
                                      </span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 col-lg-offset-1 control-label">Activo</label>
                                <input type="hidden" ng-model="vm.companyplan.is_active" value="1"/>
                                <div class="col-lg-6">
                                    <toggle id="is_active" 
                                            ng-model="vm.activetoggleSelected" 
                                            onstyle="btn-success" on="Si" 
                                            offstyle="btn-danger" off="No">
                                    </toggle>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-9">
                                    <button class="btn btn-md btn-primary" type="submit">Guardar</button>
                                    <a class="btn btn-md btn-warning" href="{{url('/companyplan')}}">Volver</a>
                                </div>
                            </div>

                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
        
    </script>
@endsection
