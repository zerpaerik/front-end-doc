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
                    <strong>Listar Datos Maestros</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>

    <div id="entitymasterdata" class="wrapper wrapper-content animated fadeInRight"  ng-controller="EntityMasterDataController as vm">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lista de Datos Maestros</h5>
                        <div class="ibox-tools">
                            <a href="{{url('/entitymasterdata/create')}}" class="btn btn-sm btn-primary"><span class="fa fa-plus-circle"></span> Crear Dato Maestro</a>                                                     
                        </div>
                    </div>                    

                    <div class="ibox-content" >
                        <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="width: 98%">

                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="myTable" aria-describedby="DataTables_Table_0_info" role="grid" >
                    
                        <thead>
                        
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 20%;"><center>Entidad</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 20%;"><center>Código</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 10%;"><center>Nombre</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 15%;"><center>Descripción</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 15%;"><center>Estado</center></th>

                                <th class="sorting" rowspan="1" colspan="1" style="width: 15%;"><center>Acciones</center>   </th>
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
            
            var apiUrl =  '{{env('API_HOST', NULL)}}/entitymasterdataDt';         
            
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
                            data: 'entity.name', 
                            name: 'entity.name'
                        },
                        {
                            data: 'code',
                            className: "text-center"
                        },
                        {
                            data: 'name',
                            className: "text-center"
                        },
                        {
                            data: 'description',
                            className: "text-center"
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
                                         + '<a href="{{url("entitymasterdata/edit")}}/'+data.id+'" class="btn btn-xs btn-default" style="margin-right:3px"><i class="fa fa-pencil"></i></a>'
                                         + '<button onclick="deleteElement('+ data.id +')" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i></button>';

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
                angular.element(document.getElementById('entitymasterdata')).scope().vm.delete(id);
            }
        </script>
    </div>    

@endsection
