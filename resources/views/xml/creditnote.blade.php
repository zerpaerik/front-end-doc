<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<notaCredito id="comprobante" version="1.1.0">
	<infoTributaria>		
		<ambiente>{{$creditNoteObject->environment_type}}</ambiente>		
		<tipoEmision>{{$creditNoteObject->emission_type}}</tipoEmision>
		<razonSocial>{{$creditNoteObject->company->social_reason}}</razonSocial>
		@if($creditNoteObject->company->comercial_name == NULL)
		<nombreComercial>{{$creditNoteObject->branch->comercial_name}}</nombreComercial>
		@else
		<nombreComercial>{{$creditNoteObject->company->comercial_name}}</nombreComercial>
		@endif
		<ruc>{{$creditNoteObject->company->ruc}}</ruc>
		<claveAcceso>{{$creditNoteObject->auth_code}}</claveAcceso>
		<codDoc>04</codDoc>
		<estab>{{$creditNoteObject->company->emission_code}}</estab>
		<ptoEmi>{{$creditNoteObject->branch->emission_point}}</ptoEmi>
		<secuencial>{{$creditNoteObject->principal_code}}</secuencial>
		<dirMatriz>{{$creditNoteObject->company->address}}</dirMatriz>
	</infoTributaria>	
	
	<infoNotaCredito>
		<fechaEmision>{{$creditNoteObject->emission_date}}</fechaEmision>
		<dirEstablecimiento>{{$creditNoteObject->branch->address}}</dirEstablecimiento>
		<tipoIdentificacionComprador>{{$creditNoteObject->client->identificationType}}</tipoIdentificacionComprador>	
		<razonSocialComprador>{{$creditNoteObject->client->social_reason}}</razonSocialComprador>
		<identificacionComprador>{{$creditNoteObject->client->identification}}</identificacionComprador>
		@if($creditNoteObject->company->special_code != NULL)
		<contribuyenteEspecial>{{$creditNoteObject->company->special_code}}</contribuyenteEspecial>
		@endif
		@if($creditNoteObject->company->is_accounting == 1)
		<obligadoContabilidad>SI</obligadoContabilidad>
		@else
		<obligadoContabilidad>NO</obligadoContabilidad>
		@endif
		<rise>Contribuyente Régimen Simplificado RISE</rise>
		<codDocModificado>01</codDocModificado>
		<numDocModificado>{{$creditNoteObject->modifiedDocumentCode}}</numDocModificado>
		<fechaEmisionDocSustento>{{$creditNoteObject->modifiedDocumentEmissionDate}}</fechaEmisionDocSustento>
		<totalSinImpuestos>{{$creditNoteObject->subtotal}}</totalSinImpuestos>
		<valorModificacion>{{$creditNoteObject->total}}</valorModificacion>
		<moneda>DOLAR</moneda>
		<totalConImpuestos>
		@foreach($creditNoteObject->sumarizedTax as $tax)			
		<totalImpuesto>
			<codigo>{{$tax->code}}</codigo>
			<codigoPorcentaje>{{$tax->percentage_code}}</codigoPorcentaje>				
			<baseImponible>{{$tax->taxBase}}</baseImponible>
			<valor>{{$tax->totalTax}}</valor>
		</totalImpuesto>
		@endforeach	
		</totalConImpuestos>
		<motivo>{{$creditNoteObject->concept}}</motivo>
	</infoNotaCredito>
	
	<detalles>
		@foreach($creditNoteObject->document_line as $line)
	    <detalle>
	        <codigoInterno>{{$line->principal_code}}</codigoInterno>
	        <codigoAdicional>{{$line->auxiliary_code}}</codigoAdicional>
	        <descripcion>{{$line->description}}</descripcion>
	        <cantidad>{{$line->quantity}}</cantidad>
	        <precioUnitario>{{$line->unit_price}}</precioUnitario>
	        <descuento>{{$line->discount}}</descuento>
	        <precioTotalSinImpuesto>{{$line->line_sub_total}}</precioTotalSinImpuesto>	        	       	        
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
</notaCredito>
