@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Sucursales</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Inicio</a>
                </li>                
                <li class="active">
                    <strong>Sucursales</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div id="branch" class="wrapper wrapper-content animated fadeInRight" ng-controller="BranchController as vm">
        <div class="row">            

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lista de sucursales</h5> 
                        <div class="ibox-tools">                            
                            <a href="{{url('branch/create')}}" class="btn btn-xs btn-primary"><span class="fa fa-plus-circle"></span> Nueva sucursal</a>                           
                        </div>                       
                    </div>                    

                    <div class="ibox-content" >
                        <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="width: 98%">

                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="myTable" aria-describedby="DataTables_Table_0_info" role="grid" >
                    
                        <thead>
                        
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 20%;"><center>Nombre sucursal</center></th>

                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 20%;"><center>Compañia</center></th>

                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 20%;"><center>Punto de Emisión</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 20%;"><center>Dirección</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 10%;"><center>Teléfono</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 15%;"><center>Correo electrónico</center></th>

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
    </div>    
    
    <script>        
              
        $(document).ready( function () {

            @if($_COOKIE['userRole'] == env('ROLE_SUPERADMIN', NULL))
                var apiUrl =  '{{env('API_HOST', NULL)}}/branchDtAll';
            @else
                var apiUrl =  '{{env('API_HOST', NULL)}}/branchDt/{{$_COOKIE['company_id']}}';
            @endif            

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
                    {data: 'name',              className: "text-center"},
                    {
                        data: 'company.name', 
                        name: 'company.name',
                        className: "text-center"
                    },
                    {data: 'emission_point',    className: "text-center"},
                    {data: 'address',           className: "text-center"},
                    {data: 'phone',             className: "text-center"},
                    {data: 'email',             className: "text-center"},
                    {
                        name:       'actions',
                        data:       null,
                        sortable:   false,
                        searchable: false,
                        render: function (data){
                            let button = '<button onclick="deleteElement('+ data.id +')" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i></button>';
                            let actions = '';
                            actions += '<center>'                                    
                                    + '<a href="{{url("branch/edit/")}}/'+data.id+'" class="btn btn-xs btn-default" style="margin-right:3px"><i class="fa fa-pencil"></i></a>'
                                    + button;
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
            //alert("test");
            angular.element(document.getElementById('branch')).scope().vm.delete(id);
        }
    </script>
@endsection
