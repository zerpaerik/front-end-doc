@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Impuestos</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Inicio</a>
                </li>
                <li>
                    <a href="{{ url('/countrytax') }}">Impuestos</a>
                </li>
                <li class="active">
                    <strong>Nuevo Impuesto</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div class="wrapper wrapper-content animated fadeInRight" ng-controller='CountryTaxController as vm' ng-init="vm.loadList()">
        <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Nuevo Impuesto</h5>                        
                    </div>                    

                    <div class="ibox-content">
                        <br>
                        <form class="form-horizontal" name="FrmCountryTax" novalidate="novalidate" ng-submit="vm.create()">   

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">País</label>
                                <div class="col-lg-6">                                                                    
                                    <select id="pais" class="form-control" ng-options="country.name for country in vm.CountryList track by country.id" ng-model="vm.country" ng-change="vm.selectCountry(vm.country)" required>
                                    </select>
                                </div>
                            </div>      

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Tipo Impuesto</label>
                                <div class="col-lg-6">                                                                    
                                    <select id="tipo_impuesto" class="form-control" ng-options="tax.name for tax in vm.TaxList track by tax.id" ng-model="vm.tax" ng-change="vm.selectTax(vm.tax)"required>
                                    </select>
                                </div>
                            </div>  

                            <div class="form-group"><label class="col-lg-2 col-lg-offset-1 control-label">Tipo Porcentaje</label>
                                <div class="col-lg-6">                                                                    
                                    <select id="taxpercentage" class="form-control" ng-options="taxpercentage.name for taxpercentage in vm.TaxPercentageList track by taxpercentage.id" ng-model="vm.taxpercentage" required ng-change="vm.selectTaxPercentage(vm.taxpercentage)">
                                    </select>
                                </div>
                            </div>                       
                            
                            <div class="form-group">
                                <label class="col-lg-2 col-lg-offset-1 control-label">Valor del Impuesto</label>
                                <div class="col-lg-6"><input id="valor_impuesto" type="text" ng-model="vm.countrytax.value" placeholder="Valor de Impuesto" class="form-control" required=""></div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-10">
                                    <button class="btn btn-md btn-primary" type="submit">Guardar</button>
                                    <a class="btn btn-md btn-warning" href="{{url('/countrytax')}}">Volver</a>
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
