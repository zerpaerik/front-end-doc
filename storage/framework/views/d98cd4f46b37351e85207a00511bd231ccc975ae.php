<?php $__env->startSection('content'); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Facturación Electrónica</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('home')); ?>">Inicio</a>
                </li>                
                <li class="active">
                    <strong>Facturación Electrónica</strong>
                </li>
            </ol>
        </div>        
    </div>

    <div id="preinvoice" class="wrapper wrapper-content animated fadeInRight" ng-controller="InvoiceController as vm">
        <div class="row">            

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lista de Pre-Facturas</h5>
                        <div class="ibox-tools">                            
                            <a href="<?php echo e(url('invoice/create')); ?>" class="btn btn-xs btn-primary"><span class="fa fa-plus-circle"></span> Nueva Factura</a>                            
                        </div>
                    </div>                    

                    <div class="ibox-content" >
                        <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap" style="width: 98%">

                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="myTable" aria-describedby="DataTables_Table_0_info" role="grid" >
                    
                        <thead>
                        
                            <tr role="row">
                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>Fecha de Creación</center></th>       

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 14%;"><center>Cliente</center></th>

                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 10%;"><center>RUC/Cédula</center></th>
                                                            
                                <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>Total</center></th>

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

        <div class="modal inmodal" id="myModalSRI" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <i class="fa fa-laptop modal-icon"></i>
                        <h4 class="modal-title">Esperando respuesta del SRI</h4>
                        
                    </div>
                    <div class="modal-body">
                        <center>
                            <div style="width: 200px; height: 200px">
                                <div class="spiner-example">
                                    <div class="sk-spinner sk-spinner-three-bounce">
                                        <div class="sk-bounce1"></div>
                                        <div class="sk-bounce2"></div>
                                        <div class="sk-bounce3"></div>
                                    </div>
                                </div>
                            </div>
                        </center>
                    </div>                    
                </div>
            </div>
        </div>

    </div> 

       

    <script>                        
        $(document).ready( function () {
            let check = '<?php echo e($_COOKIE['company_id']); ?>';
            if(check.length == 0){
                check = sessionStorage.getItem('company_id');
            }

            let apiUrl =  '<?php echo e(env('API_HOST', NULL)); ?>/preinvoiceDt/' + check;  

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
                    failure : function(result){alert(result);}                                                        
                },
                'columns'    : [                                          
                    {data: 'invoice_date', 
                     className: "text-center",
                     render: function(data){
                                var fecha = data.substring(8) + '/' + data.substring(5,7) + '/' + data.substring(0,4); 
                                return fecha;
                     }
                    },                                      
                    {data: 'client.social_reason',          className: "text-center"},
                    {data: 'client.identification_number',  className: "text-center"},                                        
                    {data: 'total_invoice',                 className: "text-center"},                    
                    {
                        name:       'actions',
                        data:       null,
                        sortable:   false,
                        searchable: false,
                        render: function (data){
                            let actions = '';
                            actions += '<center>'
                                    + '<a href="<?php echo e(url('invoice/createPDF/')); ?>/'+ data.id +'" target="_blank" class="btn btn-xs btn-warning" title="Generar PDF" style="margin-right:3px"><i class="fa fa-file-pdf-o"></i></a>'
                                    + '<a href="" onclick="sendMail(' + data.id + ')" class="btn btn-xs btn-info" title="Enviar mail al cliente con PDF" style="margin-right:3px"><i class="fa fa-envelope"></i></a>'
                                    + '<a href="" onclick="validateSRI('+ data.id +')" class="btn btn-xs btn-primary" title="Enviar al SRI" style="margin-right:3px"><i class="fa fa-paper-plane"></i></a>'
                                    + '<a href="<?php echo e(url('invoice/prefactura/edit/')); ?>/'+ data.id +'" class="btn btn-xs btn-default" style="margin-right:3px"><i class="fa fa-pencil"></i></a>'
                                    + '<button style="margin-right:3px" onclick="deleteElement(' + data.id + ')" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i></button>';
                            return actions;
                        }
                    }
                ]
            });
        } );        

        function validateSRI(id){
            angular.element(document.getElementById('preinvoice')).scope().vm.validateSRI(id, null, 1);
        }
        
        /*
        Esta función se usa como helper para ejecutar la función delete del controlador de AngularJs
        */
        function deleteElement(id){            
            angular.element(document.getElementById('preinvoice')).scope().vm.delete(id);
        }      

        function sendMail(id){
            swal({
                title: "Enviar correo electrónico al cliente",
                text: "El PDF de la prefactura será enviado al cliente",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#5fb4f6",
                confirmButtonText: "Enviar",
                closeOnConfirm: false
            }, function (isConfirm) {
                if (!isConfirm) return;
                $.ajax({
                    url: "<?php echo e(env('APP_URL', NULL)); ?>/invoice/prefactura/mail/" + id,
                    type: "GET",                                        
                    success: function () {
                        swal("Se ha completado la acción", "El correo electrónico ha sido enviado éxitosamente", "success");
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal("No se ha completado la acción", "Por favor intente nuevamente o contacte al administrador", "error");
                    }
                });
            });
        }  
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>