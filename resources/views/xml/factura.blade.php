<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<factura id="comprobante" version="1.1.0">
	<infoTributaria>		
		<ambiente>{{$invoiceObject->invoice->environment_type}}</ambiente>		
		<tipoEmision>{{$invoiceObject->invoice->emission_type}}</tipoEmision>
		<razonSocial>{{$invoiceObject->company->social_reason}}</razonSocial>
	@if($invoiceObject->company->comercial_name == NULL)
	<nombreComercial>{{$invoiceObject->branch->comercial_name}}</nombreComercial>
	@else
	<nombreComercial>{{$invoiceObject->company->comercial_name}}</nombreComercial>
	@endif
	<ruc>{{$invoiceObject->company->ruc}}</ruc>
		<claveAcceso>{{$invoiceObject->invoice->auth_code}}</claveAcceso>
		<codDoc>01</codDoc>
		<estab>{{$invoiceObject->company->emission_code}}</estab>
		<ptoEmi>{{$invoiceObject->branch->emission_point}}</ptoEmi>
		<secuencial>{{$invoiceObject->invoice->principal_code}}</secuencial>
		<dirMatriz>{{$invoiceObject->company->address}}</dirMatriz>
	</infoTributaria>
	<infoFactura>
		<fechaEmision>{{$invoiceObject->invoice->invoice_date}}</fechaEmision>
		<dirEstablecimiento>{{$invoiceObject->branch->address}}</dirEstablecimiento>
		@if($invoiceObject->company->special_code != NULL)
		<contribuyenteEspecial>{{$invoiceObject->company->special_code}}</contribuyenteEspecial>
		@endif
	@if($invoiceObject->company->is_accounting == 1)
	<obligadoContabilidad>SI</obligadoContabilidad>
	@else
	<obligadoContabilidad>NO</obligadoContabilidad>
	@endif

	@if($invoiceObject->invoice->export_invoice)
		<comercioExterior>EXPORTADOR</comercioExterior>
		<incoTermFactura>{{$invoiceObject->invoice->inco_term}}</incoTermFactura>
		<lugarIncoTerm>{{$invoiceObject->invoice->place_inco_term}}</lugarIncoTerm>
		<paisOrigen>{{$invoiceObject->invoice->source_country}}</paisOrigen>
		<puertoEmbarque>{{$invoiceObject->invoice->source_harvour}}</puertoEmbarque>
		<puertoDestino>{{$invoiceObject->invoice->destination_harvour}}</puertoDestino>
		<paisDestino>{{$invoiceObject->invoice->destination_country}}</paisDestino>
		<paisAdquisicion>{{$invoiceObject->invoice->seller_country}}</paisAdquisicion>
	@endif

		<tipoIdentificacionComprador>{{$invoiceObject->client->identificationType}}</tipoIdentificacionComprador>	
		<razonSocialComprador>{{$invoiceObject->client->social_reason}}</razonSocialComprador>
		<identificacionComprador>{{$invoiceObject->client->identification}}</identificacionComprador>
		<direccionComprador>{{$invoiceObject->client->address}}</direccionComprador>		
		<totalSinImpuestos>{{$invoiceObject->invoice->total_without_tax}}</totalSinImpuestos>

	@if($invoiceObject->invoice->export_invoice)
		<incoTermTotalSinImpuestos>{{$invoiceObject->invoice->inco_term_total_no_tax}}</incoTermTotalSinImpuestos>
	@endif	

		<totalDescuento>{{round($invoiceObject->invoice->total_discount,2)}}</totalDescuento>		
		<totalConImpuestos>
			@foreach($invoiceObject->sumarizedTax as $tax)			
			<totalImpuesto>				
				<codigo>{{$tax->code}}</codigo>
				<codigoPorcentaje>{{$tax->percentage_code}}</codigoPorcentaje>				
				<baseImponible>{{$tax->taxBase}}</baseImponible>
				<valor>{{$tax->totalTax}}</valor>
			</totalImpuesto>
			@endforeach			
		</totalConImpuestos>		
		<propina>{{$invoiceObject->invoice->tip}}</propina>

		@if($invoiceObject->invoice->export_invoice)
			<fleteInternacional>{{$invoiceObject->invoice->international_cargo}}</fleteInternacional>
			<seguroInternacional>{{$invoiceObject->invoice->international_secure}}</seguroInternacional>
			<gastosAduaneros>{{$invoiceObject->invoice->custom_expenditures}}</gastosAduaneros>
			<gastosTransporteOtros>{{$invoiceObject->invoice->transport_expenditures}}</gastosTransporteOtros>
		@endif

		<importeTotal>{{$invoiceObject->invoice->total_invoice}}</importeTotal>
		<moneda>DOLAR</moneda>
		@if(count($invoiceObject->invoice_payment) > 0)
		<pagos>
			@foreach($invoiceObject->invoice_payment as $payment)
			<pago>
				<formaPago>{{$payment->paymentCode}}</formaPago>
				<total>{{$payment->paymentMount}}</total>
				@if($payment->timeLimit)
				<plazo>{{$payment->timeLimit}}</plazo>				
				@endif
				@if($payment->timeUnit)
				<unidadTiempo>{{$payment->timeUnit}}</unidadTiempo>
				@endif
			</pago>
			@endforeach
		</pagos>
		@endif
	</infoFactura>
	<detalles>
		@foreach($invoiceObject->invoice_line as $line)
		<detalle>
			<codigoPrincipal>{{$line->principal_code}}</codigoPrincipal>
			@if($line->auxiliary_code != NULL)
			<codigoAuxiliar>{{$line->auxiliary_code}}</codigoAuxiliar>
			@endif
			<descripcion>{{$line->name}}</descripcion>
			<cantidad>{{$line->quantity}}</cantidad>
			<precioUnitario>{{$line->unit_price}}</precioUnitario>
			<descuento>{{$line->discount}}</descuento>
			<precioTotalSinImpuesto>{{$line->totalCostNoTax}}</precioTotalSinImpuesto>			
			<impuestos>
				@foreach($line->taxes as $tax)
				<impuesto>
					<codigo>{{$tax->tax_code}}</codigo>
					<codigoPorcentaje>{{$tax->tax_percentage_code}}</codigoPorcentaje>
					<tarifa>{{$tax->tax_percentage_value}}</tarifa>
					<baseImponible>{{$line->totalCostNoTax}}</baseImponible>
					<valor>{{$tax->tax_sub_total}}</valor>
				</impuesto>
				@endforeach
			</impuestos>
		</detalle>
		@endforeach
	</detalles>
</factura>
