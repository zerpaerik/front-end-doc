<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<factura id="comprobante" version="1.1.0">
	<infoTributaria>		
		<ambiente><?php echo e($invoiceObject->invoice->environment_type); ?></ambiente>		
		<tipoEmision><?php echo e($invoiceObject->invoice->emission_type); ?></tipoEmision>
		<razonSocial><?php echo e($invoiceObject->company->social_reason); ?></razonSocial>
	<?php if($invoiceObject->company->comercial_name == NULL): ?>
	<nombreComercial><?php echo e($invoiceObject->branch->comercial_name); ?></nombreComercial>
	<?php else: ?>
	<nombreComercial><?php echo e($invoiceObject->company->comercial_name); ?></nombreComercial>
	<?php endif; ?>
	<ruc><?php echo e($invoiceObject->company->ruc); ?></ruc>
		<claveAcceso><?php echo e($invoiceObject->invoice->auth_code); ?></claveAcceso>
		<codDoc>01</codDoc>
		<estab><?php echo e($invoiceObject->company->emission_code); ?></estab>
		<ptoEmi><?php echo e($invoiceObject->branch->emission_point); ?></ptoEmi>
		<secuencial><?php echo e($invoiceObject->invoice->principal_code); ?></secuencial>
		<dirMatriz><?php echo e($invoiceObject->company->address); ?></dirMatriz>
	</infoTributaria>
	<infoFactura>
		<fechaEmision><?php echo e($invoiceObject->invoice->invoice_date); ?></fechaEmision>
		<dirEstablecimiento><?php echo e($invoiceObject->branch->address); ?></dirEstablecimiento>
		<?php if($invoiceObject->company->special_code != NULL): ?>
		<contribuyenteEspecial><?php echo e($invoiceObject->company->special_code); ?></contribuyenteEspecial>
		<?php endif; ?>
	<?php if($invoiceObject->company->is_accounting == 1): ?>
	<obligadoContabilidad>SI</obligadoContabilidad>
	<?php else: ?>
	<obligadoContabilidad>NO</obligadoContabilidad>
	<?php endif; ?>

	<?php if($invoiceObject->invoice->export_invoice): ?>
		<comercioExterior>EXPORTADOR</comercioExterior>
		<incoTermFactura><?php echo e($invoiceObject->invoice->inco_term); ?></incoTermFactura>
		<lugarIncoTerm><?php echo e($invoiceObject->invoice->place_inco_term); ?></lugarIncoTerm>
		<paisOrigen><?php echo e($invoiceObject->invoice->source_country); ?></paisOrigen>
		<puertoEmbarque><?php echo e($invoiceObject->invoice->source_harvour); ?></puertoEmbarque>
		<puertoDestino><?php echo e($invoiceObject->invoice->destination_harvour); ?></puertoDestino>
		<paisDestino><?php echo e($invoiceObject->invoice->destination_country); ?></paisDestino>
		<paisAdquisicion><?php echo e($invoiceObject->invoice->seller_country); ?></paisAdquisicion>
	<?php endif; ?>

		<tipoIdentificacionComprador><?php echo e($invoiceObject->client->identificationType); ?></tipoIdentificacionComprador>	
		<razonSocialComprador><?php echo e($invoiceObject->client->social_reason); ?></razonSocialComprador>
		<identificacionComprador><?php echo e($invoiceObject->client->identification); ?></identificacionComprador>
		<direccionComprador><?php echo e($invoiceObject->client->address); ?></direccionComprador>		
		<totalSinImpuestos><?php echo e($invoiceObject->invoice->total_without_tax); ?></totalSinImpuestos>

	<?php if($invoiceObject->invoice->export_invoice): ?>
		<incoTermTotalSinImpuestos><?php echo e($invoiceObject->invoice->inco_term_total_no_tax); ?></incoTermTotalSinImpuestos>
	<?php endif; ?>	

		<totalDescuento><?php echo e(round($invoiceObject->invoice->total_discount,2)); ?></totalDescuento>		
		<totalConImpuestos>
			<?php $__currentLoopData = $invoiceObject->sumarizedTax; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>			
			<totalImpuesto>				
				<codigo><?php echo e($tax->code); ?></codigo>
				<codigoPorcentaje><?php echo e($tax->percentage_code); ?></codigoPorcentaje>				
				<baseImponible><?php echo e($tax->taxBase); ?></baseImponible>
				<valor><?php echo e($tax->totalTax); ?></valor>
			</totalImpuesto>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>			
		</totalConImpuestos>		
		<propina><?php echo e($invoiceObject->invoice->tip); ?></propina>

		<?php if($invoiceObject->invoice->export_invoice): ?>
			<fleteInternacional><?php echo e($invoiceObject->invoice->international_cargo); ?></fleteInternacional>
			<seguroInternacional><?php echo e($invoiceObject->invoice->international_secure); ?></seguroInternacional>
			<gastosAduaneros><?php echo e($invoiceObject->invoice->custom_expenditures); ?></gastosAduaneros>
			<gastosTransporteOtros><?php echo e($invoiceObject->invoice->transport_expenditures); ?></gastosTransporteOtros>
		<?php endif; ?>

		<importeTotal><?php echo e($invoiceObject->invoice->total_invoice); ?></importeTotal>
		<moneda>DOLAR</moneda>
		<?php if(count($invoiceObject->invoice_payment) > 0): ?>
		<pagos>
			<?php $__currentLoopData = $invoiceObject->invoice_payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<pago>
				<formaPago><?php echo e($payment->paymentCode); ?></formaPago>
				<total><?php echo e($payment->paymentMount); ?></total>
				<?php if($payment->timeLimit): ?>
				<plazo><?php echo e($payment->timeLimit); ?></plazo>				
				<?php endif; ?>
				<?php if($payment->timeUnit): ?>
				<unidadTiempo><?php echo e($payment->timeUnit); ?></unidadTiempo>
				<?php endif; ?>
			</pago>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</pagos>
		<?php endif; ?>
	</infoFactura>
	<detalles>
		<?php $__currentLoopData = $invoiceObject->invoice_line; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<detalle>
			<codigoPrincipal><?php echo e($line->principal_code); ?></codigoPrincipal>
			<?php if($line->auxiliary_code != NULL): ?>
			<codigoAuxiliar><?php echo e($line->auxiliary_code); ?></codigoAuxiliar>
			<?php endif; ?>
			<descripcion><?php echo e($line->name); ?></descripcion>
			<cantidad><?php echo e($line->quantity); ?></cantidad>
			<precioUnitario><?php echo e($line->unit_price); ?></precioUnitario>
			<descuento><?php echo e($line->discount); ?></descuento>
			<precioTotalSinImpuesto><?php echo e($line->totalCostNoTax); ?></precioTotalSinImpuesto>			
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
</factura>
