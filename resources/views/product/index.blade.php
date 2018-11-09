@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Productos</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('home') }}">Inicio</a>
                </li>                
                <li class="active">
                    <strong>Productos</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div id="product" class="wrapper wrapper-content animated fadeInRight" ng-controller="ProductController as vm">
        <div class="row">            

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lista de productos</h5>
                        <div class="ibox-tools">     
                            <a href="{{url('product/import')}}" class="btn btn-xs btn-primary"><span class="fa fa-file"></span> Importar Productos</a>                         
                            <a href="{{url('product/create')}}" class="btn btn-xs btn-primary"><span class="fa fa-plus-circle"></span> Nuevo producto</a>                            
                        </div>
                    </div>                    

                    <div class="ibox-content" >
                        <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="width: 98%">

                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="myTable" aria-describedby="DataTables_Table_0_info" role="grid" >
                    
                        <thead>
                        
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" style="width: 15%;"><center>Nombre producto</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>Cód. Principal</center></th>                                

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 15%;"><center>Descripción</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>Genérico</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>Precio Unitario</center></th>                                                                

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>Act. Compra</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>Act. Venta</center></th>

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
                         
        $(document).ready( function () {
            let check = '{{$_COOKIE['company_id']}}';
            if(check.length == 0){
                check = sessionStorage.getItem('company_id');
            } 
            let apiUrl =  '{{env('API_HOST', NULL)}}/productDt/' + check;            

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
                    {data: 'name'},
                    {data: 'principal_code'},                    
                    {data: 'description'},
                    {data: 'generic'},
                    {data: 'unit_price', className: "text-center"},
                    {data: 'is_purchase_active',     
                        render: function(status){
                            let estado = '<center><span class="label label-primary">Si</span></center>';

                            if(status=="0"){
                                estado = '<center><span class="label label-danger">No</span></center>';
                            }

                            return estado;
                        }
                    },
                    {data: 'is_sale_active',
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
                                    + '<a href="{{url("product/edit")}}/'+data.id+'" class="btn btn-xs btn-default" style="margin-right:3px"><i class="fa fa-pencil"></i></a>'
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
            angular.element(document.getElementById('product')).scope().vm.delete(id);
        }
    
    </script>

@endsection
