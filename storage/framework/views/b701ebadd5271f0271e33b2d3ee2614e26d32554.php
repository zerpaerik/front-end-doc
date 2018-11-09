<?php $__env->startSection('content'); ?>	
<div class="wrapper wrapper-content">
	   <div class="row">
	   		<div class="col-lg-12">
                <div class="ibox float-e-margins">
                	<div class="ibox-title">  
                        <h5>SISTEMA DE DOCUMENTOS ELECTRÓNICOS</h5>
                    </div>               
	                <div class="ibox-content">
	                 	<div class="row">
	                 		<div class="col-lg-2">
		                        <div class="ibox float-e-margins">		                           
		                            <div class="ibox-content">
		                              	
										    <div class="widget style1">
										        <div class="row">
										            <div class="col-xs-8 text-right">
										            	 <i class="fa fa-file-text-o fa-3x"></i>
										                <span class=""></span> DOCUMENTOS ELECTRÓNICOS
										            </div>
										        </div>
										    </div>
										
		                            </div>
		                        </div>
	                    	</div>
		                    <div class="col-lg-2">
		                        <div class="ibox float-e-margins">
		                            <div class="ibox-title">  
		                                <h5>FACTURACION </h5>
		                            </div>
		                            <div class="ibox-content">
		                              	<a href="<?php echo e(url('/invoice/create')); ?>"> 
										    <div class="widget style1">
										        <div class="row">
									        	 	<div class="col-xs-4">
										                <i class="fa fa-file-text-o fa-3x"></i>
										            </div><br>
										            <div class="col-xs-8 text-right">
										                <span class="fa fa-plus-circle"></span> Crear Factura 
										            </div>
										        </div>
										    </div>
										</a>
		                            </div>
		                        </div>
	                    	</div>
		                    <div class="col-lg-2">
		                        <div class="ibox float-e-margins">
		                            <div class="ibox-title">
		                                <h5>RETENCIONES</h5>
		                            </div>
		                            <div class="ibox-content">
		                               	<a id="hola" href="<?php echo e(url('/taxdocument/create')); ?>"> 
										    <div class="widget style1">
										        <div class="row">
										            <div class="col-xs-4">
										                <i class="fa fa-legal fa-3x"></i>
										            </div><br>
										            <div class="col-xs-8 text-right">
										                <span class="fa fa-plus-circle"></span> Crear Retención
										            </div>
										        </div>
										    </div>
										</a>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-lg-2">
		                        <div class="ibox float-e-margins">
		                            <div class="ibox-title">
		                                <h5>NOTAS CRÉDITO</h5>
		                            </div>
		                            <div class="ibox-content">
		                                <a href="<?php echo e(url('/creditnote/create')); ?>"> 
										    <div class="widget style1">
										        <div class="row">
										            <div class="col-xs-4">
										                <i class="fa fa-money fa-3x"></i>
										            </div><br>
										            <div class="col-xs-8 text-right">
										                <span class="fa fa-plus-circle"></span> Crear Nota Crédito
										            </div>
										        </div>
										    </div>
										</a>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-lg-2">
		                        <div class="ibox float-e-margins">
		                            <div class="ibox-title">		                              
		                                <h5>NOTAS DÉBITO</h5>
		                            </div>
		                            <div class="ibox-content">
		                                <a href="<?php echo e(url('/debitnote/create')); ?>"> 
										    <div class="widget style1">
										        <div class="row">
										            <div class="col-xs-4">
										                <i class="fa fa-money fa-3x"></i>
										            </div><br>
										            <div class="col-xs-8 text-right">
										                <span class="fa fa-plus-circle"></span> Crear Nota Debito
										            </div>
										        </div>
										    </div>
										</a>
		                            </div>
		                        </div>
		            		</div>
		            		<div class="col-lg-2">
		                        <div class="ibox float-e-margins">
		                            <div class="ibox-title">
		                                <h5>GUIAS DE REMISIÓN</h5>
		                            </div>
		                            <div class="ibox-content">
		                               <a href="<?php echo e(url('/remission/create')); ?>"> 
										    <div class="widget style1">
										        <div class="row">
										            <div class="col-xs-4">
										                <i class="fa fa-truck fa-3x"></i>
										            </div><br>
										            <div class="col-xs-8 text-right">
										                <span class="fa fa-plus-circle"></span> Crear Guía de Remisión 
										            </div>
										        </div>
										    </div>
										</a>
		                            </div>
		                        </div>
		            		</div>
        				</div>
               		 </div>
            	</div>
	   		</div>
	   	</div>
       <div class="row">
	   		<div class="col-lg-12">
                <div class="ibox float-e-margins">
                	           
	                <div class="ibox-content">
	                 	<div class="row">
		                    <div class="col-lg-2">
		                        <div class="ibox float-e-margins">
		                            <div class="ibox-title">  
		                                <h5>PRODUCTOS </h5>
		                            </div>
		                            <div class="ibox-content">
		                              	<a href="<?php echo e(url('/product/create')); ?>"> 
										    <div class="widget style1">
										        <div class="row">
										            <div class="col-xs-4">
										                <i class="fa fa-cog fa-3x"></i>
										            </div><br>
										            <div class="col-xs-8 text-right">
										                <span class="fa fa-plus-circle"></span> Crear Producto
										            </div>
										        </div>
										    </div>
										</a>
		                            </div>
		                        </div>
	                    	</div>
		                    <div class="col-lg-2">
		                        <div class="ibox float-e-margins">
		                            <div class="ibox-title">
		                                <h5>CLIENTES</h5>
		                            </div>
		                            <div class="ibox-content">
		                               	<a href="<?php echo e(url('/client/create')); ?>"> 
										    <div class="widget style1">
										        <div class="row">
										            <div class="col-xs-4">
										                <i class="fa fa-user-o fa-3x"></i>
										            </div><br>
										            <div class="col-xs-8 text-right">
										                <span class="fa fa-plus-circle"></span> Crear Cliente
										            </div>
										        </div>
										    </div>
										</a>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-lg-2">
		                        <div class="ibox float-e-margins">
		                            <div class="ibox-title">
		                                <h5>PLANES</h5>
		                            </div>
		                            <div class="ibox-content">
		                                <a href="<?php echo e(url('/plan/create')); ?>"> 
										    <div class="widget style1">
										        <div class="row">
										            <div class="col-xs-4">
										                <i class="fa fa-cube fa-3x"></i>
										            </div><br>
										            <div class="col-xs-8 text-right">
										                <span class="fa fa-plus-circle"></span> Crear Plan
										            </div>
										        </div>
										    </div>
										</a>
		                            </div>
		                        </div>
		                    </div>
		                   
        				</div>
               		 </div>
            	</div>
	   		</div>
	   	</div>
       
	
	</div>	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>