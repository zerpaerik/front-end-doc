@extends('layouts.app')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Auditoria</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/')}}">Inicio</a>
                </li>
                <li>
                    <a href="{{ url('/audit')}}">Auditoria</a>
                </li>
                <li class="active">
                    <strong>Listar Registros de Auditoria</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
    <div id="company" class="wrapper wrapper-content animated fadeInRight" ng-controller="CompanyController as vm">
        <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lista de Registros de Auditoria</h5>
                        <div class="ibox-tools"></div>
                    </div>                    

                    <div class="ibox-content" >
                        <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="width: 98%">

                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="myTable" aria-describedby="DataTables_Table_0_info" role="grid" >
                    
                        <thead>
                        
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 15%;"><center>Nombre Compañía</center></th>

                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 15%;"><center>Razón Social</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 10%;"><center>Nombre Usuario</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 10%;"><center>Apellido Usuario</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 40%;"><center>Acción</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 10%;"><center>Fecha</center>
                                </th>
                            </tr>
                        
                        </thead>

                        <tbody>
                        </tbody>    
                    </table>

                    
                </div>
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>

        <script>            


            @if($_COOKIE['userRole'] == env('ROLE_DEVADMIN', NULL))                        
                var apiUrl = "{{env('API_HOST', NULL)}}/auditDt";
                $(document).ready( function () {
                    $('#myTable').DataTable({
                        "processing" : false,
                        "serverSide" : true,
                        "language": {
                                      "url": "/js/spanish.json"
                                    },
                        'ajax'       : {
                            url: apiUrl,
                            dataType: 'json',
                            type: 'get',                    
                            contentType: 'application/json',                                                    
                        },
                        'columns'    : [
                            {
                                data: 'company.name',
                                name: 'company.name'
                            },
                            {
                                data: 'company.comercial_name',
                                name: 'company.comercial_name'
                            },
                            {
                                data: 'user.first_name',
                                name: 'user.first_name'
                            },
                            {
                                data: 'user.last_name',
                                name: 'user.last_name'
                            },                            
                            {
                                data: 'concept'                                
                            },
                            {
                                data: 'created_at',
                                className: "text-center"
                            }                            
                        ]
                    });
                } );

            @endif
        
        </script>
    </div>    

@endsection
