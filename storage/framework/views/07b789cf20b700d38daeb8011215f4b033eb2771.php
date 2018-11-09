<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quantum</title>
        
    <script src="<?php echo e(URL::asset('js/jquery-3.1.1.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/sweetalert.min.js')); ?>"></script>
    <link rel="shortcut icon" href="logo.ico"/>
    <link rel="stylesheet" href="<?php echo asset('css/vendor.css'); ?>" />
    <link rel="stylesheet" href="<?php echo asset('css/sweetalert.css'); ?>" />
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" />

</head>
<body class="Portada">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <!-- Main view  -->
        <?php echo $__env->yieldContent('content'); ?>

        </div>
    <!-- End middle-->
    <script src="<?php echo asset('js/app.js'); ?>" type="text/javascript"></script>

<?php $__env->startSection('scripts'); ?>
<?php echo $__env->yieldSection(); ?>

</body>
</html>
