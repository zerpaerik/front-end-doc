<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<guiaRemision id="comprobante" version="1.0.0">
	<infoTributaria>		
		<ambiente><?php echo e($remissionObject->environment_type); ?></ambiente>		
		<tipoEmision><?php echo e($remissionObject->emission_type); ?></tipoEmision>
		<razonSocial><?php echo e($remissionObject->company->social_reason); ?></razonSocial>
		<?php if($remissionObject->company->comercial_name == NULL): ?>
		<nombreComercial><?php echo e($remissionObject->branch->comercial_name); ?></nombreComercial>
		<?php else: ?>
		<nombreComercial><?php echo e($remissionObject->company->comercial_name); ?></nombreComercial>
		<?php endif; ?>
		<ruc><?php echo e($remissionObject->company->ruc); ?></ruc>
		<claveAcceso><?php echo e($remissionObject->auth_code); ?></claveAcceso>
		<codDoc>06</codDoc>
		<estab><?php echo e($remissionObject->company->emission_code); ?></estab>
		<ptoEmi><?php echo e($remissionObject->branch->emission_point); ?></ptoEmi>
		<secuencial><?php echo e($remissionObject->principal_code); ?></secuencial>
		<dirMatriz><?php echo e($remissionObject->company->address); ?></dirMatriz>
	</infoTributaria>	
	
	<infoGuiaRemision>
		<dirEstablecimiento><?php echo e($remissionObject->branch->address); ?></dirEstablecimiento>
		<dirPartida><?php echo e($remissionObject->starting_point); ?></dirPartida>
		<razonSocialTransportista><?php echo e($remissionObject->dispatcher->social_reason); ?></razonSocialTransportista>
		<tipoIdentificacionTransportista><?php echo e($remissionObject->dispatcher->identificationType); ?></tipoIdentificacionTransportista>
		<rucTransportista><?php echo e($remissionObject->dispatcher->identification_number); ?></rucTransportista>
		<rise>Contribuyente Regimen Simplificado RISE</rise>
		<?php if($remissionObject->company->is_accounting == 1): ?>
			<obligadoContabilidad>SI</obligadoContabilidad>
		<?php else: ?>
			<obligadoContabilidad>NO</obligadoContabilidad>
		<?php endif; ?>		
		<?php if($remissionObject->company->special_code != NULL): ?>
			<contribuyenteEspecial><?php echo e($remissionObject->company->special_code); ?></contribuyenteEspecial>
		<?php endif; ?>		
		<fechaIniTransporte><?php echo e($remissionObject->startdate_transport); ?></fechaIniTransporte>
		<fechaFinTransporte><?php echo e($remissionObject->enddate_transport); ?></fechaFinTransporte>
		<placa><?php echo e($remissionObject->car_register); ?></placa>
	</infoGuiaRemision>

	<destinatarios>
		<destinatario>
			<identificacionDestinatario><?php echo e($remissionObject->client->identification); ?></identificacionDestinatario>
			<razonSocialDestinatario><?php echo e($remissionObject->client->social_reason); ?></razonSocialDestinatario>
			<dirDestinatario><?php echo e($remissionObject->client->address); ?></dirDestinatario>
			<motivoTraslado><?php echo e($remissionObject->reason_transport); ?></motivoTraslado>
			<docAduaneroUnico><?php echo e($remissionObject->custom_document); ?></docAduaneroUnico>
			<codEstabDestino><?php echo e($remissionObject->destination_branch_code); ?></codEstabDestino>
			<ruta><?php echo e($remissionObject->route); ?></ruta>
			<codDocSustento>01</codDocSustento>
			<numDocSustento><?php echo e(substr($remissionObject->invoice->referral_code, 0, 3) . "-" . substr($remissionObject->invoice->referral_code, 3, 3) . "-" . substr($remissionObject->invoice->referral_code, 6)); ?></numDocSustento>
			<numAutDocSustento><?php echo e($remissionObject->invoice->auth_code); ?></numAutDocSustento>
			<fechaEmisionDocSustento><?php echo e($remissionObject->modifiedDocumentEmissionDate); ?></fechaEmisionDocSustento>			
			<detalles>
				<?php $__currentLoopData = $remissionObject->invoiceLine; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<detalle>
						<codigoInterno><?php echo e($line->principal_code); ?></codigoInterno>
						<codigoAdicional><?php echo e($line->auxiliary_code); ?></codigoAdicional>
						<descripcion><?php echo e($line->description); ?></descripcion>
						<cantidad><?php echo e($line->quantity); ?></cantidad>										
					</detalle>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</detalles>
		</destinatario>
	</destinatarios>
</guiaRemision>