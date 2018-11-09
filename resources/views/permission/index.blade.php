@extends('layouts.app')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Permisología de Roles</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/')}}">Inicio</a>
                </li>
                <li class="active">
                    <strong>Permisología de Roles</strong>
                </li>                
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
    <div id="permission" class="wrapper wrapper-content animated fadeInRight" ng-controller="PermissionController as vm">
        <div class="row">

            <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lista de Permisologías</h5>
                        <div class="ibox-tools">
                            <a href="{{url('/permission/create')}}" class="btn btn-xs btn-primary"><span class="fa fa-plus-circle"></span> Nueva Permisología</a>
                        </div>
                    </div>                    

                    <div class="ibox-content">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="width: 98%">

                                <center>
                                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="myTable" aria-describedby="DataTables_Table_0_info" role="grid">
                                    
                                        <thead>
                                        
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 50%;"><center>Rol</center></th>
                                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 20%;"><center>Activo</center></th>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 20%;"><center>Acciones</center>   </th>
                                            </tr>
                                        
                                        </thead>

                                        <tbody>
                                        </tbody>    
                                    </table>
                                </center>
                            
                            </div>
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>

        <script>
            
            var apiUrl =  '{{env('API_HOST', NULL)}}/permissionDt';                                         
            
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
                            data: 'role.name',
                            name: 'role.name',
                            className: "text-center"
                        },
                        {
                            data: 'role.is_active',
                            name: 'role.is_active',
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
                                         + '<a href="{{url("permission")}}/'+data.role_id+'/edit" class="btn btn-xs btn-default" style="margin-right:3px"><i class="fa fa-pencil"></i></a>'
                                         + '<button onclick="deleteElement(' + data.role_id + ')" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i></button>';

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
                angular.element(document.getElementById('permission')).scope().vm.delete(id);
            }
        
        </script>
    </div>    

@endsection
