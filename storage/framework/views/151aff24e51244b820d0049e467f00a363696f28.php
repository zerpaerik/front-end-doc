<?xml version="1.0" encoding="UTF-8" ?>
	<comprobanteRetencion id="comprobante" version="1.0.0">
		<infoTributaria>		
			<ambiente><?php echo e($retentionObject->environment_type); ?></ambiente>		
			<tipoEmision><?php echo e($retentionObject->emission_type); ?></tipoEmision>
			<razonSocial><?php echo e($retentionObject->company->social_reason); ?></razonSocial>
			<?php if($retentionObject->company->comercial_name == NULL): ?>
			<nombreComercial><?php echo e($retentionObject->branch->comercial_name); ?></nombreComercial>
			<?php else: ?>
			<nombreComercial><?php echo e($retentionObject->company->comercial_name); ?></nombreComercial>
			<?php endif; ?>
			<ruc><?php echo e($retentionObject->company->ruc); ?></ruc>
			<claveAcceso><?php echo e($retentionObject->auth_code); ?></claveAcceso>
			<codDoc>07</codDoc>
			<estab><?php echo e($retentionObject->company->emission_code); ?></estab>
			<ptoEmi><?php echo e($retentionObject->branch->emission_point); ?></ptoEmi>
			<secuencial><?php echo e($retentionObject->principal_code); ?></secuencial>
			<dirMatriz><?php echo e($retentionObject->company->address); ?></dirMatriz>
		</infoTributaria>
		
		<infoCompRetencion>
			<fechaEmision><?php echo e($retentionObject->emission_date); ?></fechaEmision>
			<dirEstablecimiento><?php echo e($retentionObject->branch->address); ?></dirEstablecimiento>
			<?php if($retentionObject->company->special_code != NULL): ?>
			<contribuyenteEspecial><?php echo e($retentionObject->company->special_code); ?></contribuyenteEspecial>
			<?php endif; ?>
			<?php if($retentionObject->company->is_accounting == 1): ?>
			<obligadoContabilidad>SI</obligadoContabilidad>
			<?php else: ?>
			<obligadoContabilidad>NO</obligadoContabilidad>
			<?php endif; ?>
			<tipoIdentificacionSujetoRetenido><?php echo e($retentionObject->supplier->identificationType); ?></tipoIdentificacionSujetoRetenido>
			<razonSocialSujetoRetenido><?php echo e($retentionObject->supplier->social_reason); ?></razonSocialSujetoRetenido>
			<identificacionSujetoRetenido><?php echo e($retentionObject->supplier->identification_number); ?></identificacionSujetoRetenido>
			<periodoFiscal><?php echo e($retentionObject->supplier->tax_period); ?></periodoFiscal>
		</infoCompRetencion>
		
		<impuestos>
			
			<?php $__currentLoopData = $retentionObject->document_line; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<impuesto>				
					<codigo><?php echo e($line->tax_type_code); ?></codigo>
					<codigoRetencion><?php echo e($line->retention_type_code); ?></codigoRetencion>
					<baseImponible><?php echo e($line->tax_base_amount); ?></baseImponible>
					<porcentajeRetener><?php echo e($line->tax_percentage); ?></porcentajeRetener>
					<valorRetenido><?php echo e($line->tax_total_amount); ?></valorRetenido>
					<codDocSustento><?php echo e($line->referral_document_type); ?></codDocSustento>
					<numDocSustento><?php echo e($line->referral_document); ?></numDocSustento>
					<fechaEmisionDocSustento><?php echo e($line->doc_emission_date); ?></fechaEmisionDocSustento>
				</impuesto>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>			
		</impuestos>
				
	</comprobanteRetencion>