<?xml version="1.0" encoding="UTF-8" ?>
	<comprobanteRetencion id="comprobante" version="1.0.0">
		<infoTributaria>		
			<ambiente>{{$retentionObject->environment_type}}</ambiente>		
			<tipoEmision>{{$retentionObject->emission_type}}</tipoEmision>
			<razonSocial>{{$retentionObject->company->social_reason}}</razonSocial>
			@if($retentionObject->company->comercial_name == NULL)
			<nombreComercial>{{$retentionObject->branch->comercial_name}}</nombreComercial>
			@else
			<nombreComercial>{{$retentionObject->company->comercial_name}}</nombreComercial>
			@endif
			<ruc>{{$retentionObject->company->ruc}}</ruc>
			<claveAcceso>{{$retentionObject->auth_code}}</claveAcceso>
			<codDoc>07</codDoc>
			<estab>{{$retentionObject->company->emission_code}}</estab>
			<ptoEmi>{{$retentionObject->branch->emission_point}}</ptoEmi>
			<secuencial>{{$retentionObject->principal_code}}</secuencial>
			<dirMatriz>{{$retentionObject->company->address}}</dirMatriz>
		</infoTributaria>
		
		<infoCompRetencion>
			<fechaEmision>{{$retentionObject->emission_date}}</fechaEmision>
			<dirEstablecimiento>{{$retentionObject->branch->address}}</dirEstablecimiento>
			@if($retentionObject->company->special_code != NULL)
			<contribuyenteEspecial>{{$retentionObject->company->special_code}}</contribuyenteEspecial>
			@endif
			@if($retentionObject->company->is_accounting == 1)
			<obligadoContabilidad>SI</obligadoContabilidad>
			@else
			<obligadoContabilidad>NO</obligadoContabilidad>
			@endif
			<tipoIdentificacionSujetoRetenido>{{$retentionObject->supplier->identificationType}}</tipoIdentificacionSujetoRetenido>
			<razonSocialSujetoRetenido>{{$retentionObject->supplier->social_reason}}</razonSocialSujetoRetenido>
			<identificacionSujetoRetenido>{{$retentionObject->supplier->identification_number}}</identificacionSujetoRetenido>
			<periodoFiscal>{{$retentionObject->supplier->tax_period}}</periodoFiscal>
		</infoCompRetencion>
		
		<impuestos>
			
			@foreach($retentionObject->document_line as $line)
				<impuesto>				
					<codigo>{{$line->tax_type_code}}</codigo>
					<codigoRetencion>{{$line->retention_type_code}}</codigoRetencion>
					<baseImponible>{{$line->tax_base_amount}}</baseImponible>
					<porcentajeRetener>{{$line->tax_percentage}}</porcentajeRetener>
					<valorRetenido>{{$line->tax_total_amount}}</valorRetenido>
					<codDocSustento>{{$line->referral_document_type}}</codDocSustento>
					<numDocSustento>{{$line->referral_document}}</numDocSustento>
					<fechaEmisionDocSustento>{{$line->doc_emission_date}}</fechaEmisionDocSustento>
				</impuesto>
			@endforeach			
		</impuestos>
				
	</comprobanteRetencion>