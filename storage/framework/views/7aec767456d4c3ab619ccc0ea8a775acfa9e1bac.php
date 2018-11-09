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

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">            

            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lista de Facturas</h5>
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
                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>Cód. Principal</center></th>   

                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 15%;"><center>Número de Autorización</center></th>
                                            
                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>RUC/Cédula</center></th>      

                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>F. Facturación</center></th>                                                            
                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>F. Autorización</center></th>

                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 10%;"><center>Razón Social</center></th>

                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1" style="width: 5%;"><center>Total</center></th>

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
            let check = '<?php echo e($_COOKIE['company_id']); ?>';
            if(check.length == 0){
                check = sessionStorage.getItem('company_id');
            }
             
            let apiUrl =  '<?php echo e(env('API_HOST', NULL)); ?>/invoiceDt/' + check;            

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
                    {data: 'principal_code'},     
                    {data: 'auth_code',                     className: "text-center"},
                    {data: 'client.identification_number',  className: "text-center"},                  
                    {data: 'invoice_date',                  className: "text-center"},
                    {data: 'auth_date',                     className: "text-center"},               
                    {data: 'client.social_reason'},                                                            
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
                                    + '<a href="" onclick="sendMail(' + data.id + ')" class="btn btn-xs btn-info" title="Enviar mail PDF y XML" style="margin-right:3px"><i class="fa fa-envelope"></i></a>'
                                    + '<a href="<?php echo e(url('invoice/downloadXML')); ?>/' + data.id +'"  class="btn btn-xs btn-primary" target="_blank" title="Descargar XML" style="margin-right:3px"><i class="fa fa-download"></i></a>';
                            return actions;
                        }
                    }
                ]
            });
        } );

        function sendMail(id){
            swal({
                title: "Enviar correo electrónico al cliente",
                text: "El PDF y XML de la factura serán enviados al cliente",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#5fb4f6",
                confirmButtonText: "Enviar",
                closeOnConfirm: false
            }, function (isConfirm) {
                if (!isConfirm) return;
                $.ajax({
                    url: "<?php echo e(env('APP_URL', NULL)); ?>/invoice/mail/" + id,
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