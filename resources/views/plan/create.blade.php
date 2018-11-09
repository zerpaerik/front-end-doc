@extends('layouts.app')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight" ng-controller="PlanController as vm">
        <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Nuevo Plan</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>                                                        
                        </div>
                    </div>                    

                    <div class="ibox-content">
                        <br>
                        <form class="form-horizontal" name="FrmPlan" novalidate="novalidate" ng-submit="vm.create()">
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Nombre de Plan</label>
                                <div class="col-lg-6"><input id="name" type="text" ng-model="vm.plan.name" placeholder="Nombre de Plan" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Nro. Documentos</label>
                                <div class="col-lg-6"><input id="document_count" ng-model="vm.plan.document_count" type="text" placeholder="Nro. Documentos" class="form-control" required> </div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Duración</label>
                                <div class="col-lg-6"><input id="duration" type="text" ng-model="vm.plan.duration" placeholder="Duración del Plan" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Precio</label>
                                <div class="col-lg-6"><input id="price" type="text" ng-model="vm.plan.price" placeholder="Precio" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 col-lg-offset-1 control-label">Activo</label>
                                <input type="hidden" ng-model="vm.plan.is_active" value="1"/>
                                <div class="col-lg-6">
                                    <toggle id="is_plan" 
                                            ng-model="vm.toggleSelected" 
                                            onstyle="btn-success" on="Si" 
                                            offstyle="btn-danger" off="No">
                                    </toggle>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-md btn-primary" type="submit" >Guardar</button>
                                    <a class="btn btn-md btn-warning" href="{{url('/plan')}}">Volver</a>
                                </div>
                            </div>

                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>    
@endsection
