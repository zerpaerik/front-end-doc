@extends('layouts.app')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Compañia</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/')}}">Inicio</a>
                </li>
                <li>
                    <a href="{{ url('/company')}}">Planes de Compañías</a>
                </li>
                <li class="active">
                    <strong>Listar Planes de Compañías</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lista de Planes de Compañias</h5>
                        <div class="ibox-tools">
                            <a href="{{url('/companyplan/create')}}" class="btn btn-sm btn-primary"><span class="fa fa-plus-circle"></span> Crear Plan Compañía</a>
                        </div>
                    </div>                    

                    <div class="ibox-content" >
                        <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="width: 98%">

                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="myTable" aria-describedby="DataTables_Table_0_info" role="grid" >
                    
                        <thead>
                        
                            <tr role="row">
                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 20%;"><center>Compañía</center></th>

                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 20%;"><center>Plan</center></th>

                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 10%;"><center>Nro.Doc. Plan</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 15%;"><center>Fecha Inicio</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 15%;"><center>Fecha Fin</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 10%;"><center>Estado</center></th>

                                <th class="sorting" rowspan="1" colspan="1" style="width: 10%;"><center>Acciones</center>   </th>
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
            
            var apiUrl =  '{{env('API_HOST', NULL)}}/companyplanDt';         
            
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
                        { data: 'company.name', 
                          name: 'company.name'
                        },
                        {
                            data: 'plan.name', 
                            name: 'plan.name'
                        },
                        {
                            data: 'current_counter',
                            className: "text-center"
                        },
                        {
                            data: 'start_date',
                            className: "text-center",
                            render: function(data){
                                var fecha = data.substring(8) + '/' + data.substring(5,7) + '/' + data.substring(0,4); 
                                return fecha;
                            }
                        },
                        {
                            data: 'end_date',
                            className: "text-center",
                            render: function(data){
                                var fecha = data.substring(8) + '/' + data.substring(5,7) + '/' + data.substring(0,4); 
                                return fecha;
                            }
                        },
                        {
                            data: 'is_active',
                            render: function(status){
                                let estado = '<center><span class="label label-primary">Activo</span></center>';

                                if(status=="0"){
                                    estado = '<center><span class="label label-danger">Inactivo</span></center>';
                                }

                                return estado;
                            }    
                        },
                        {
                            name:       'actions',
                            data:       null,
                            sortable:   false,
                            searchable: false,
                            render: function (data){
                                let actions = '';
                                actions += '<center>'
                                         + '<a href="{{url("companyplan/edit")}}/'+data.id+'" class="btn btn-xs btn-default" style="margin-right:3px"><i class="fa fa-pencil"></i></a>'
                                         + '<button ng-click="@{{vm.delete(' + data.id + ')}}" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i></button>';
                                return actions;
                            }

                        }
                    ]
                });
            } );

            /*
            Esta función se usa como helper para ejecutar la función delete del controlador de AngularJs
            */
            function deleteElement(id){            
                angular.element(document.getElementById('companyplan')).scope().vm.delete(id);
            }
        
        </script>
    </div>    

@endsection
