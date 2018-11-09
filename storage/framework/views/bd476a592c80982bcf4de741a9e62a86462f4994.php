<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<notaCredito id="comprobante" version="1.1.0">
	<infoTributaria>		
		<ambiente><?php echo e($creditNoteObject->environment_type); ?></ambiente>		
		<tipoEmision><?php echo e($creditNoteObject->emission_type); ?></tipoEmision>
		<razonSocial><?php echo e($creditNoteObject->company->social_reason); ?></razonSocial>
		<?php if($creditNoteObject->company->comercial_name == NULL): ?>
		<nombreComercial><?php echo e($creditNoteObject->branch->comercial_name); ?></nombreComercial>
		<?php else: ?>
		<nombreComercial><?php echo e($creditNoteObject->company->comercial_name); ?></nombreComercial>
		<?php endif; ?>
		<ruc><?php echo e($creditNoteObject->company->ruc); ?></ruc>
		<claveAcceso><?php echo e($creditNoteObject->auth_code); ?></claveAcceso>
		<codDoc>04</codDoc>
		<estab><?php echo e($creditNoteObject->company->emission_code); ?></estab>
		<ptoEmi><?php echo e($creditNoteObject->branch->emission_point); ?></ptoEmi>
		<secuencial><?php echo e($creditNoteObject->principal_code); ?></secuencial>
		<dirMatriz><?php echo e($creditNoteObject->company->address); ?></dirMatriz>
	</infoTributaria>	
	
	<infoNotaCredito>
		<fechaEmision><?php echo e($creditNoteObject->emission_date); ?></fechaEmision>
		<dirEstablecimiento><?php echo e($creditNoteObject->branch->address); ?></dirEstablecimiento>
		<tipoIdentificacionComprador><?php echo e($creditNoteObject->client->identificationType); ?></tipoIdentificacionComprador>	
		<razonSocialComprador><?php echo e($creditNoteObject->client->social_reason); ?></razonSocialComprador>
		<identificacionComprador><?php echo e($creditNoteObject->client->identification); ?></identificacionComprador>
		<?php if($creditNoteObject->company->special_code != NULL): ?>
		<contribuyenteEspecial><?php echo e($creditNoteObject->company->special_code); ?></contribuyenteEspecial>
		<?php endif; ?>
		<?php if($creditNoteObject->company->is_accounting == 1): ?>
		<obligadoContabilidad>SI</obligadoContabilidad>
		<?php else: ?>
		<obligadoContabilidad>NO</obligadoContabilidad>
		<?php endif; ?>
		<rise>Contribuyente Régimen Simplificado RISE</rise>
		<codDocModificado>01</codDocModificado>
		<numDocModificado><?php echo e($creditNoteObject->modifiedDocumentCode); ?></numDocModificado>
		<fechaEmisionDocSustento><?php echo e($creditNoteObject->modifiedDocumentEmissionDate); ?></fechaEmisionDocSustento>
		<totalSinImpuestos><?php echo e($creditNoteObject->subtotal); ?></totalSinImpuestos>
		<valorModificacion><?php echo e($creditNoteObject->total); ?></valorModificacion>
		<moneda>DOLAR</moneda>
		<totalConImpuestos>
		<?php $__currentLoopData = $creditNoteObject->sumarizedTax; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>			
		<totalImpuesto>
			<codigo><?php echo e($tax->code); ?></codigo>
			<codigoPorcentaje><?php echo e($tax->percentage_code); ?></codigoPorcentaje>				
			<baseImponible><?php echo e($tax->taxBase); ?></baseImponible>
			<valor><?php echo e($tax->totalTax); ?></valor>
		</totalImpuesto>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
		</totalConImpuestos>
		<motivo><?php echo e($creditNoteObject->concept); ?></motivo>
	</infoNotaCredito>
	
	<detalles>
		<?php $__currentLoopData = $creditNoteObject->document_line; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	    <detalle>
	        <codigoInterno><?php echo e($line->principal_code); ?></codigoInterno>
	        <codigoAdicional><?php echo e($line->auxiliary_code); ?></codigoAdicional>
	        <descripcion><?php echo e($line->description); ?></descripcion>
	        <cantidad><?php echo e($line->quantity); ?></cantidad>
	        <precioUnitario><?php echo e($line->unit_price); ?></precioUnitario>
	        <descuento><?php echo e($line->discount); ?></descuento>
	        <precioTotalSinImpuesto><?php echo e($line->line_sub_total); ?></precioTotalSinImpuesto>	        	       	        
	        <impuestos>	            	            
	            <?php $__currentLoopData = $line->taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<impuesto>
					<codigo><?php echo e($tax->tax_code); ?></codigo>
					<codigoPorcentaje><?php echo e($tax->tax_percentage_code); ?></codigoPorcentaje>
					<tarifa><?php echo e($tax->tax_percentage_value); ?></tarifa>
					<baseImponible><?php echo e($line->totalCostNoTax); ?></baseImponible>
					<valor><?php echo e($tax->tax_sub_total); ?></valor>
				</impuesto>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	        </impuestos>
	    </detalle>
	    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</detalles>					
</notaCredito>
