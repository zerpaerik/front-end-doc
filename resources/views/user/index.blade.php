@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Gestión de Usuarios</h2>            
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Inicio</a>
                </li>                
                <li class="active">
                    <strong>Usuarios</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div id="user" class="wrapper wrapper-content animated fadeInRight" ng-controller="UserController as vm">
        <div class="row">

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lista de usuarios</h5>
                        <div class="ibox-tools">
                            <a href="{{url('user/create')}}" class="btn btn-xs btn-primary"><span class="fa fa-plus-circle"></span> Nuevo usuario</a>                                 
                        </div>
                    </div>                    

                    <div class="ibox-content" >
                        <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="width: 98%">

                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="myTable" aria-describedby="DataTables_Table_0_info" role="grid" >
                    
                        <thead>
                        
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 10%;"><center>Nombre</center></th>

                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 10%;"><center>Apellido</center></th>

                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 10%;"><center>Compañía</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 15%;"><center>Email</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>Teléfono</center></th> 

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>Activo</center></th>

                                <th class="sorting" rowspan="1" colspan="1" style="width: 5%;"><center>Acciones</center>   </th>
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
    </div>



    <script>        
            
        @if($_COOKIE['userRole'] == env('ROLE_SUPERADMIN', NULL))
            var apiUrl =  '{{env('API_HOST', NULL)}}/userDtAll';
        @else
            var apiUrl =  '{{env('API_HOST', NULL)}}/userDt/{{$_COOKIE['company_id']}}';
        @endif
        
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
                    // headers: {
                    //     'Authorization': 'Bearer '
                    // },
                    // beforeSend: function (xhr) {
                    //     xhr.setRequestHeader('Authorization', 'Bearer ');
                    // }                                                       
                },
                'columns'    : [
                    {data: 'first_name'},
                    {data: 'last_name'},
                    {
                        data: 'company.name', 
                        name: 'company.name'
                    },
                    {data: 'email'},
                    {data: 'phone_number'},
                    {data: 'is_active',
                        render: function(status){
                            let estado = '<center><span class="label label-primary">Si</span></center>';

                            if(status=="0"){
                                estado = '<center><span class="label label-danger">No</span></center>';
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
                                    + '<a href="{{url("user/edit")}}/'+data.id+'" class="btn btn-xs btn-default" style="margin-right:3px"><i class="fa fa-pencil"></i></a>'
                                    + '<button onclick="deleteElement(' + data.id + ')" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i></button>';
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
            angular.element(document.getElementById('user')).scope().vm.delete(id);
        }
    
    </script>
@endsection
