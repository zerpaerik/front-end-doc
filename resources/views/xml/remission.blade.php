<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<guiaRemision id="comprobante" version="1.0.0">
	<infoTributaria>		
		<ambiente>{{$remissionObject->environment_type}}</ambiente>		
		<tipoEmision>{{$remissionObject->emission_type}}</tipoEmision>
		<razonSocial>{{$remissionObject->company->social_reason}}</razonSocial>
		@if($remissionObject->company->comercial_name == NULL)
		<nombreComercial>{{$remissionObject->branch->comercial_name}}</nombreComercial>
		@else
		<nombreComercial>{{$remissionObject->company->comercial_name}}</nombreComercial>
		@endif
		<ruc>{{$remissionObject->company->ruc}}</ruc>
		<claveAcceso>{{$remissionObject->auth_code}}</claveAcceso>
		<codDoc>06</codDoc>
		<estab>{{$remissionObject->company->emission_code}}</estab>
		<ptoEmi>{{$remissionObject->branch->emission_point}}</ptoEmi>
		<secuencial>{{$remissionObject->principal_code}}</secuencial>
		<dirMatriz>{{$remissionObject->company->address}}</dirMatriz>
	</infoTributaria>	
	
	<infoGuiaRemision>
		<dirEstablecimiento>{{$remissionObject->branch->address}}</dirEstablecimiento>
		<dirPartida>{{$remissionObject->starting_point}}</dirPartida>
		<razonSocialTransportista>{{$remissionObject->dispatcher->social_reason}}</razonSocialTransportista>
		<tipoIdentificacionTransportista>{{$remissionObject->dispatcher->identificationType}}</tipoIdentificacionTransportista>
		<rucTransportista>{{$remissionObject->dispatcher->identification_number}}</rucTransportista>
		<rise>Contribuyente Regimen Simplificado RISE</rise>
		@if($remissionObject->company->is_accounting == 1)
			<obligadoContabilidad>SI</obligadoContabilidad>
		@else
			<obligadoContabilidad>NO</obligadoContabilidad>
		@endif		
		@if($remissionObject->company->special_code != NULL)
			<contribuyenteEspecial>{{$remissionObject->company->special_code}}</contribuyenteEspecial>
		@endif		
		<fechaIniTransporte>{{$remissionObject->startdate_transport}}</fechaIniTransporte>
		<fechaFinTransporte>{{$remissionObject->enddate_transport}}</fechaFinTransporte>
		<placa>{{$remissionObject->car_register}}</placa>
	</infoGuiaRemision>

	<destinatarios>
		<destinatario>
			<identificacionDestinatario>{{$remissionObject->client->identification}}</identificacionDestinatario>
			<razonSocialDestinatario>{{$remissionObject->client->social_reason}}</razonSocialDestinatario>
			<dirDestinatario>{{$remissionObject->client->address}}</dirDestinatario>
			<motivoTraslado>{{$remissionObject->reason_transport}}</motivoTraslado>
			@if(isset($remissionObject->custom_document))
				<docAduaneroUnico>{{$remissionObject->custom_document}}</docAduaneroUnico>
			@endif
			<codEstabDestino>{{$remissionObject->destination_branch_code}}</codEstabDestino>
			<ruta>{{$remissionObject->route}}</ruta>
			<codDocSustento>01</codDocSustento>
			<numDocSustento>{{substr($remissionObject->invoice->referral_code, 0, 3) . "-" . substr($remissionObject->invoice->referral_code, 3, 3) . "-" . substr($remissionObject->invoice->referral_code, 6)}}</numDocSustento>
			<numAutDocSustento>{{$remissionObject->invoice->auth_code}}</numAutDocSustento>
			<fechaEmisionDocSustento>{{$remissionObject->modifiedDocumentEmissionDate}}</fechaEmisionDocSustento>			
			<detalles>
				@foreach($remissionObject->invoiceLine as $line)
					<detalle>
						<codigoInterno>{{$line->principal_code}}</codigoInterno>
						<codigoAdicional>{{$line->auxiliary_code}}</codigoAdicional>
						<descripcion>{{$line->description}}</descripcion>
						<cantidad>{{$line->quantity}}</cantidad>										
					</detalle>
				@endforeach
			</detalles>
		</destinatario>
	</destinatarios>
</guiaRemision>