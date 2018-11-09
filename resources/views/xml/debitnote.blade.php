<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<notaDebito id="comprobante" version="1.1.0">
	<infoTributaria>		
		<ambiente>{{$DebitNoteObject->environment_type}}</ambiente>		
		<tipoEmision>{{$DebitNoteObject->emission_type}}</tipoEmision>
		<razonSocial>{{$DebitNoteObject->company->social_reason}}</razonSocial>
		@if($DebitNoteObject->company->comercial_name == NULL)
		<nombreComercial>{{$DebitNoteObject->branch->comercial_name}}</nombreComercial>
		@else
		<nombreComercial>{{$DebitNoteObject->company->comercial_name}}</nombreComercial>
		@endif
		<ruc>{{$DebitNoteObject->company->ruc}}</ruc>
		<claveAcceso>{{$DebitNoteObject->auth_code}}</claveAcceso>
		<codDoc>04</codDoc>
		<estab>{{$DebitNoteObject->company->emission_code}}</estab>
		<ptoEmi>{{$DebitNoteObject->branch->emission_point}}</ptoEmi>
		<secuencial>{{$DebitNoteObject->principal_code}}</secuencial>
		<dirMatriz>{{$DebitNoteObject->company->address}}</dirMatriz>
	</infoTributaria>	
	
	<infoNotaDebito>
		<fechaEmision>{{$DebitNoteObject->emission_date}}</fechaEmision>
		<dirEstablecimiento>{{$DebitNoteObject->branch->address}}</dirEstablecimiento>
		<tipoIdentificacionComprador>{{$DebitNoteObject->client->identification_type}}</tipoIdentificacionComprador>	
		<razonSocialComprador>{{$DebitNoteObject->client->social_reason}}</razonSocialComprador>
		<identificacionComprador>{{$DebitNoteObject->client->identification_number}}</identificacionComprador>
		@if($DebitNoteObject->company->special_code != NULL)
			<contribuyenteEspecial>{{$DebitNoteObject->company->special_code}}</contribuyenteEspecial>
		@endif
		@if($DebitNoteObject->company->is_accounting == 1)
			<obligadoContabilidad>SI</obligadoContabilidad>
		@else
			<obligadoContabilidad>NO</obligadoContabilidad>
		@endif		
		<codDocModificado>01</codDocModificado>
		<numDocModificado>{{$DebitNoteObject->invoice->referral_code}}</numDocModificado>
		<fechaEmisionDocSustento>{{$DebitNoteObject->invoice->invoice_date}}</fechaEmisionDocSustento>
		<totalSinImpuestos>{{$DebitNoteObject->invoice->subtotal}}</totalSinImpuestos>				
		<impuestos>
			@foreach()
				<impuesto>
					<codigo>2</codigo>
					<codigoPorcentaje>2</codigoPorcentaje>
					<tarifa>12.00</tarifa>
					<baseImponible>50.0</baseImponible>
					<valor>6.00</valor>
				</impuesto>
			@endforeach
		</impuestos>		
		<valorTotal>56.00</valorTotal>		
		<pagos>
			@foreach($DebitNoteObject->payment as $payment)			
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
	</infoNotaDebito>
	
	<motivos>
		<motivo>
			<razon>Interés por mora</razon>
			<valor>50.00</valor>
		</motivo>
	</motivos>
</notaDebito>
