<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturacion Electronica</title>

    
    <script src="<?php echo e(URL::asset('js/jquery-3.1.1.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/chosen.jquery.js')); ?>"></script>

    
    <script src="<?php echo e(URL::asset('js/angular.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular-animate.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular-sanitize.min.js')); ?>"></script>
    
    
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-toastr/angular-toastr.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-toastr/angular-toastr.tpls.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-autovalidate/jcs-auto-validate.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-angular-toggle-switch/angular-toggle-switch.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-datepicker/angular-eonasdan-datetimepicker.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-angular-chosen/angular-chosen.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-multiselect/isteven-multi-select.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-uigrid/ui-grid.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-autocomplete/angucomplete-alt.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-fileupload/ng-file-upload-shim.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-fileupload/ng-file-upload.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-ui-mask/mask.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-checkbox/checkbox_directive.js')); ?>"></script>

    
    
    <script src="<?php echo e(URL::asset('js/jquery.metisMenu.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/jquery.slimscroll.min.js')); ?>"></script>    
    <script src="<?php echo e(URL::asset('js/inspinia.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/pace.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/sweetalert.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/angular_plugins/ng-sweetalert/SweetAlert.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/iCheck/icheck.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/initializeIcheck.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/jasny-bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/xlsx.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/ods.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/ui-bootstrap-tpls-2.5.0.min.js')); ?>"></script>

    <!script src="<?php echo e(URL::asset('js/app.js')); ?>"><!/script>


    
    <script src="<?php echo e(URL::asset('js/AppQuantum/QuantumApp.js')); ?>"></script>

    
    

    
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.client.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.branch.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.product.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.plan.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.user.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.company.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.companyplan.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.entity.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.entitymasterdata.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.mailconfiguration.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.invoice.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.producttax.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.correlativedocument.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.countrytax.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.permission.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.supplier.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.taxdocument.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.creditnote.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.debitnote.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.remission.services.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/services/app.dispatcher.services.js')); ?>"></script>

    
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.client.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.branch.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.product.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.plan.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.user.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.company.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.companyplan.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.entitymasterdata.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.mailconfiguration.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.invoice.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.countrytax.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.permission.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.supplier.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.taxdocument.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.creditnote.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.debitnote.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.remission.controller.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/AppQuantum/controllers/app.dispatcher.controller.js')); ?>"></script>

    
    <link rel="shortcut icon" href="<?php echo e(URL::asset('logo.ico')); ?>"/>
    <link rel="stylesheet" href="<?php echo asset('css/vendor.css'); ?>" />
    <link rel="stylesheet" href="<?php echo asset('css/datatables.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo asset('css/sweetalert.css'); ?>" />
    <link rel="stylesheet" href="<?php echo asset('css/angular-toastr.css'); ?>" />
    <link rel="stylesheet" href="<?php echo asset('css/iCheck/custom.css'); ?>" />
    <link rel="stylesheet" href="<?php echo asset('css/angular-toggle-switch.css'); ?>" />    
    <link rel="stylesheet" href="<?php echo asset('css/isteven-multi-select.css'); ?>" />
    <link rel="stylesheet" href="<?php echo asset('css/chosen.css'); ?>" />
    <link rel="stylesheet" href="<?php echo asset('css/ui-grid.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo asset('css/jasny-bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo asset('css/angucomplete-alt.css'); ?>" />
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</head>
<body ng-app='QuantumApp'>

  <!-- Wrapper-->
    <div id="wrapper">

        <!-- Navigation -->
        <?php echo $__env->make('layouts.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- Page wraper -->
        <div id="page-wrapper" class="gray-bg">

            <!-- Page wrapper -->
            <?php echo $__env->make('layouts.topnavbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- Main view  -->
            <?php echo $__env->yieldContent('content'); ?>

            <!-- Footer -->
            <?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        </div>
        <!-- End page wrapper-->

    </div>
    <!-- End wrapper-->

<!script src="<?php echo asset('js/app.js'); ?>" type="text/javascript"></script>



<?php $__env->startSection('scripts'); ?>
<?php echo $__env->yieldSection(); ?>

</body>
</html>
