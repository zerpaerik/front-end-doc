(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('TaxDocumentController', TaxDocumentController);

    TaxDocumentController.$inject = ['$scope', '$http', 'SupplierService', 'CountryTaxService', 'TaxDocumentService', 'EntityMasterDataService', 'ENTITY', 'DEFAULT_COUNTRY', 'DOCUMENT_TYPE', '$rootScope', 'toastr', 'HOST_ROUTE', 'SRI_SERVICE', 'SweetAlert'];

    function TaxDocumentController($scope, $http, SupplierService, CountryTaxService, TaxDocumentService, EntityMasterDataService, ENTITY, DEFAULT_COUNTRY, DOCUMENT_TYPE, $rootScope, toastr, HOST_ROUTE, SRI_SERVICE, SweetAlert) {
        
        var vm = this;

        vm.localLang = {           
            reset           : "Deshacer",
            search          : "Buscar Proveedor",
            nothingSelected : "Seleccione un Proveedor"
        }

        vm.formats    = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd/MM/yyyy', 'shortDate'];
        vm.formatDate = vm.formats[2];

        vm.altInputFormats = ['d!/M!/yyyy'];

        vm.options = {
            format: "DD/MM/YYYY"
        }

        vm.dateOptions = {
            dateDisabled: disabled,
            formatYear: 'yy',
            maxDate: new Date(2020, 5, 22),
            minDate: new Date(2018, 1, 1),
            startingDay: 1
        };

        // Disable weekend selection
        function disabled(data) {
            var date = data.date,
              mode = data.mode;
            return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
        }

        vm.formats    = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd/MM/yyyy', 'shortDate'];
        vm.formatDate = vm.formats[2];

        vm.altInputFormats = ['d!/M!/yyyy'];

        vm.options = {
            format: "DD/MM/YYYY"
        }

        vm.dateOptions = {
            dateDisabled: disabled,
            formatYear: 'yy',
            maxDate: new Date(2020, 5, 22),
            minDate: new Date(2018, 1, 1),
            startingDay: 1
        };

        vm.popup = {
            opened: false
        }

        vm.open = function() {
            vm.popup.opened = true;
        };

        vm.showRenta = '';
        vm.FechaHoy        = new Date();
        vm.referralDocumentTypeSelected = "";
        vm.ReferalCode     = '';
        vm.CompanyId       = 0; // Colocar valor desde la BD
        vm.BranchOfficeId  = 0; // Colocar valor desde la BD
        vm.SupplierId      = 0;
        vm.EmissionType    = 0; // Debe asocisarse a un valor en BD
        vm.EnvironmentType = 0;  // Debe asocisarse a un valor en BD
        vm.toggleSelected  = true;
        vm.supplier        = {};
        vm.IdentificationTypeSelected = true; 
        vm.IdentificationTypeList     = [];
        vm.MaxCharIdentification      = 13;
        vm.MinCharIdentification = 1;

        vm.EnableTaxButton     = false;
        vm.RetentionList       = [];
        vm.TaxPercentageList   = [];
        vm.SupplierList        = [];
        vm.SupplierListTemp    = [];
        vm.taxdocumentSupplier = {};
        vm.TaxDocument         = {
            id              : 0,
            principal_code  : "",
            referral_code   : "",
            emission_date   : "",
            amount          : 0,
            concept         : "",
            emission_type   : "",
            environment_type: "",
            invoice_id      : 0,
            total_discount  : "",
            document_type_id: "",
            company_id      : "",
            supplier_id     : "",
            is_processed    : 0,
            taxDocumentLine : []
        };
        vm.TaxDocumentLine     = [];
        vm.DocumentLine        = [];
        vm.TaxList             = [];
        // Variables para totales
        vm.subtotal = 0;   
        vm.totalTaxDocument = 0;

        vm.TaxCode = "";
        vm.TaxValue = "";

        vm.setBranch = function(branch){
            vm.BranchOfficeId = branch;
        }

        vm.setRetentionTaxObject = function(id, code, tax){
            vm.TaxCode  = code;
            vm.TaxValue = tax;
            angular.element('#myModalInfo').modal('hide');                             
            vm.DocumentLine.tax_percentage = vm.TaxValue; 
            vm.updateTaxDocumentLine(vm.DocumentLine, 0);
            var retentiontypecode = {};
            retentiontypecode.tax_percentage_id = id;
            vm.DocumentLine.retentiontypecode = retentiontypecode;
            $scope.$apply();   
        }

        vm.validateSRI = function(id, redirect = null){
            SweetAlert.swal({
                  title: 'Enviar Retención al SRI',
                  text: "¿Está seguro que desea enviar la Retención al SRI?",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonTexwt: 'Si',
                  cancelButtonText: 'No',
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false
            }, 
            function(isConfirm) {
                if(isConfirm === true){
                  vm.loading = true;
                  angular.element('#myModalSRI').modal('show');
                  var promise = TaxDocumentService.sendSRI(SRI_SERVICE.URL_RETENTION, id);
                  promise.then(function(pl){
                    var retorno = pl.data;                                        
                    angular.element('#myModalSRI').modal('hide');
                    
                    let htmlString = '';
                    let title = "";
                    var vecSplit = retorno.split(";");
                    if(retorno.length != 54){
                        title = "Se ha obtenido una respuesta del SRI";
                        for(var i = 0; i < vecSplit.length; i++){
                            var string = vecSplit[i];
                            string = string.replace('{', '');
                            string = string.replace('}', '');
                            string = string.replace("'", '');
                            var jsonObject = string.split(":");
                            if(jsonObject[1]===undefined) jsonObject[1]="Contraseña de Firma Digital erronea";
                            htmlString += "<strong>"+ jsonObject[1] +"</strong><br>";
                        }                       
                    }
                    else{
                        title = retorno;
                        htmlString = "";
                    }

                    SweetAlert.swal({
                        title   : title, 
                        html    : true,
                        text    : htmlString, 
                        type    : "success"
                    }, 
                    function(isConfirm){
                        if(redirect){
                           window.location = HOST_ROUTE.TAXDOCUMENT + "/create"; 
                        }
                    });
                  }, 
                  function(plError){
                    angular.element('#myModalSRI').modal('hide');
                    SweetAlert.swal("Hubo un error al enviar al SRI", "" + JSON.stringify(plError), "error");
                  }
                  );
                }
            });
        }

        vm.create = function(Id){
            var promise = TaxDocumentService.create(vm.taxdocument, Id);
            promise.then(function(pl){
                var retorno = pl.data;                
                toastr.success("La Retención fue creada satisfactoriamente"); 
                window.location = HOST_ROUTE.TAXDOCUMENT;               
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear la Retención" + errorPl);
                window.location = HOST_ROUTE.TAXDOCUMENT;
            };
        }

        vm.update = function(){
            var promise = TaxDocumentService.update(vm.TaxDocumentLine, vm.TaxDocumentLine.id);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("La Retención fue actualizada satisfactoriamente"); 
                window.location = HOST_ROUTE.TAXDOCUMENT;               
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al editar la Retención" + errorPl);
                window.location = HOST_ROUTE.TAXDOCUMENT;
            };
        }  

        vm.delete = function(id){
            var promise = TaxDocumentService.delete(id);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("La Retención fue eliminada satisfactoriamente");
                window.location = HOST_ROUTE.TAXDOCUMENT;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al eliminar la Retención" + errorPl);
                window.location = HOST_ROUTE.TAXDOCUMENT;
            };
        }      

        vm.edit = function(id){
            var promise = TaxDocumentService.readRetention(id);
            promise.then(function(pl){
                
                vm.SupplierId  = pl.data.supplier_id;
                vm.TaxDocument = pl.data;  
                vm.FechaHoy    = pl.data.invoice_date;

                vm.taxdocumentSupplier.identification = pl.data.supplier.identification_number;
                vm.taxdocumentSupplier.social_reason  = pl.data.supplier.social_reason;
                vm.taxdocumentSupplier.phone          = pl.data.supplier.phone;
                vm.taxdocumentSupplier.comercial_name = pl.data.supplier.comercial_name;
                vm.taxdocumentSupplier.email          = pl.data.supplier.email;
                vm.taxdocumentSupplier.address        = pl.data.supplier.address; 

                vm.TaxDocumentLine    = pl.data.tax_document_line;                
                vm.updateTaxDocument();
            });
        }

        vm.readAll = function(idCompany){
            var promise = TaxDocumentService.readAll(idCompany);
            promise.then(function(pl){
                vm.TaxDocumentList = pl.data;
            }); 
        }

        // Listas tipo Combos para Facturación
        vm.readSupplierList = function (IdCompany) {
            var promise = SupplierService.readFilter(IdCompany);
            promise.then(function (pl) {
                vm.SupplierList = pl.data;
            }),
            function (errorPl) {
                vm.error = errorPl;
            };
        }

        vm.readCountryTax = function(){
            var promise = CountryTaxService.readTaxRetention(DEFAULT_COUNTRY.EC, ENTITY.TAX_RETENTION);
            promise.then(function(pl){
                vm.TaxList = pl.data;
            });
        }

        vm.loadCombos = function(IdCompany, IdBranch){
           vm.CompanyId = IdCompany;
           vm.BranchOfficeId = IdBranch;
           vm.readRetentionList();
           vm.readSupplierList(IdCompany);
           vm.readTaxRetentionList();
        }

        vm.selectSupplier = function (data) {
             var datos = data.originalObject;
             vm.SupplierId = datos.id;
             vm.taxdocumentSupplier.social_reason   = datos.social_reason;
             vm.taxdocumentSupplier.comercial_name  = datos.comercial_name;
             vm.taxdocumentSupplier.email           = datos.email;
             vm.taxdocumentSupplier.address         = datos.address;
             vm.taxdocumentSupplier.phone           = datos.phone;
             vm.taxdocumentSupplier.identification  = datos.identification_number;
             vm.EnableInvoice = true;
        }; 

        vm.SelectReferralDocumentType = function(data){
            vm.DocumentLine.referral_document_type = data;
            angular.forEach(vm.RetentionList, function(retention, key){
                if(retention.id===data){
                    vm.DocumentLine.referralDocumentType = retention;
                }
            });
        };

        vm.SelectTaxTypeCode = function(data, param){
            
            if(data.taxtypecode.id === 109)
                vm.showRenta = '1';            
            else 
                vm.showRenta = '';            

            vm.DocumentLine.tax_type_code = data.taxtypecode.id;
            vm.readTaxPercentageList(data.taxtypecode.id);
            vm.readTaxPercentageLineList(data.taxtypecode.id, data);
            data.tax_percentage = 0;
            vm.updateTaxDocumentLine(data, param);
        }; 

        vm.SelectRetentionTypeCode = function(data, param){
            vm.DocumentLine.retention_type_code = data.retentiontypecode.id;
            data.tax_percentage = parseFloat(data.retentiontypecode.value);
            vm.updateTaxDocumentLine(data, param);
        }; 

        vm.updateTaxDocument = function(){
            vm.totalTaxDocument = 0;
            angular.forEach(vm.TaxDocumentLine, function(taxDocumentLine, key){
                
                if(taxDocumentLine.taxtypecode.id != 109)
                    taxDocumentLine.tax_total_amount = taxDocumentLine.tax_base_amount * taxDocumentLine.tax_percentage / 100;
                else
                    taxDocumentLine.tax_total_amount = taxDocumentLine.tax_base_amount * taxDocumentLine.TaxValue / 100;

                taxDocumentLine.tax_total_amount = parseFloat(taxDocumentLine.tax_total_amount.toFixed(2));

                vm.totalTaxDocument  +=  taxDocumentLine.tax_total_amount;
                vm.totalTaxDocument = parseFloat(vm.totalTaxDocument.toFixed(2));

            });
        }

        vm.addTaxDocumentLine = function(taxDocument){
            var taxDocumentLine = {};
            vm.TaxDocumentLine = vm.TaxDocumentLine || [];

            if(vm.referralDocumentTypeSelected===undefined||vm.referralDocumentTypeSelected===null||vm.referralDocumentTypeSelected===""){
                SweetAlert.swal("Tipo de Comprobante!", "Debe seleccionar Comprobante!", "warning"); 
                return;
            }

            if(taxDocument.referral_document==="" || taxDocument.referral_document===undefined){
                SweetAlert.swal("Linea de Retención!", "Debe ingresar Nro. de Comprobante!", "warning"); 
                return;
            }

            if(taxDocument.referral_document.length<13){
                SweetAlert.swal("Linea de Retención!", "Debe ingresar un Nro. de Comprobante válido!", "warning"); 
                return;
            }

            if(taxDocument.doc_emission_date==="" || taxDocument.doc_emission_date===undefined){
                SweetAlert.swal("Fecha de Emisión Incorrecta!", "La Fecha de Emisión debe ser seleccionada!", "warning"); 
                return;
            }

            if(taxDocument.doc_emission_date>vm.FechaHoy){
                SweetAlert.swal("Fecha de Emisión Incorrecta!", "La Fecha de Emisión debe ser menor a la Fecha Actual!", "warning");  
                return;
            }

            if(taxDocument.tax_base_amount<=0){
                SweetAlert.swal("Base Imponible incorrecta!", "La Base Imponible debe ser mayor!", "warning"); 
                return;
            }

            if(isNaN(parseFloat(taxDocument.tax_base_amount))){
                SweetAlert.swal("Base Imponible incorrecta!", "La Base Imponible acepta solo valores numericos!", "warning"); 
                return;
            }

            if(taxDocument.taxtypecode.id != 109){
                if(taxDocument.retentiontypecode==null||taxDocument.taxtypecode===undefined){
                    SweetAlert.swal("Impuesto Aplicado!", "Debe seleccionar Impuesto Aplicado!", "warning");  
                    return;
                }

                if(taxDocument.taxpercentage===null||taxDocument.retentiontypecode===undefined){
                    SweetAlert.swal("Porcentaje de Retención!", "Debe seleccionar el Porcentaje de Retención!", "warning");  
                    return;
                }

                if(taxDocument.tax_percentage==="" || taxDocument.retentiontypecode===undefined){
                    SweetAlert.swal("Porcentaje de Retención!", "Porcentaje de Retención debe ser mayor o igual a cero!", "warning"); 
                    return;
                }
            }

            taxDocumentLine.tax_document_id = 0;
            taxDocumentLine.referralDocumentType   = taxDocument.referralDocumentType;
            taxDocumentLine.referral_document_type = vm.referralDocumentTypeSelected;
            taxDocumentLine.referral_document      = taxDocument.referral_document;
            taxDocumentLine.doc_emission_date      = taxDocument.doc_emission_date;
            taxDocumentLine.tax_base_amount        = taxDocument.tax_base_amount;
            taxDocumentLine.tax_percentage         = taxDocument.tax_percentage;
            taxDocumentLine.tax_total_amount       = taxDocument.tax_total_amount;
            
            if(taxDocument.retentiontypecode !== undefined)
                taxDocumentLine.retentiontypecode = taxDocument.retentiontypecode;
            else{
                var retentiontypecode = {};
                retentiontypecode.tax_alt         = vm.TaxCode;
                taxDocument.retentiontypecode     = retentiontypecode;
                taxDocumentLine.retentiontypecode = taxDocument.retentiontypecode;
            }
            
            taxDocumentLine.taxtypecode       = taxDocument.taxtypecode;
            taxDocumentLine.TaxPercentageList = taxDocument.TaxPercentageList;
            if(taxDocument.taxtypecode.id == 109){
                taxDocumentLine.TaxCode        = vm.TaxCode;
                taxDocumentLine.tax_percentage = vm.TaxValue;
                taxDocumentLine.TaxValue       = vm.TaxValue;                
            }

            vm.TaxDocumentLine.push(taxDocumentLine);

            vm.resetTaxDocumentLine();

            vm.updateTaxDocument();

            vm.EnableTaxButton = true;            
        }

        vm.resetTaxDocumentLine = function(){
            vm.DocumentLine = [];
            vm.referralDocumentTypeSelected = "";
            vm.showRenta = '';
            vm.TaxCode = '';
            vm.TaxValue = ''; 
        }

        vm.deleteTaxDocumentLine = function(taxDocumentLine){
            var index = vm.TaxDocumentLine.indexOf(taxDocumentLine);
            vm.TaxDocumentLine.splice(index, 1);
            if(!vm.TaxDocumentLine.length > 0 ){
                vm.EnableTaxButton = false;
            }
            vm.updateTaxDocument();
        }

        vm.updateTaxDocumentLine = function(taxDocumentLine, param){            
            if(taxDocumentLine.tax_base_amount  === undefined) taxDocumentLine.tax_base_amount  = 0;
            if(taxDocumentLine.tax_percentage   === undefined) taxDocumentLine.tax_percentage   = 0;
            if(taxDocumentLine.tax_total_amount === undefined) taxDocumentLine.tax_total_amount = 0;

            if(taxDocumentLine.taxtypecode !== undefined){
                if(taxDocumentLine.taxtypecode.id != 109)
                    taxDocumentLine.tax_total_amount = taxDocumentLine.tax_base_amount * taxDocumentLine.tax_percentage / 100;
                else
                    taxDocumentLine.tax_total_amount = taxDocumentLine.tax_base_amount * vm.TaxValue / 100;

                
                //$scope.$apply(); 
            }
            
            taxDocumentLine.tax_total_amount = parseFloat(taxDocumentLine.tax_total_amount.toFixed(2));

            if(param==1) vm.updateTaxDocument();
        }

        // Métodos para generar Proforma y Emitir Factura
        vm.createRetention = function(){
            vm.TaxDocument.taxDocumentLine  = vm.TaxDocumentLine; 
            vm.TaxDocument.branch_office_id = vm.BranchOfficeId; 
            vm.TaxDocument.supplier_id      = vm.SupplierId;   
            vm.TaxDocument.amount           = vm.totalTaxDocument;               
            
            var promise = TaxDocumentService.create(vm.TaxDocument)
                promise.then(function(pl){
                    toastr.success("Retención generada", "Se ha creado la Retención satisfactoriamente");
                    vm.validateSRI(pl.data, true);
                },
                promise.catch(function(reason) {
                        console.log(reason);
                })
            );
        }

        vm.updateRetention = function(id, enviar = null){
            vm.fillTaxDocument();
            vm.TaxDocument.taxDocumentLine  = vm.TaxDocumentLine;                    
            
            var promise = TaxDocumentService.update(vm.TaxDocument, id)
                promise.then(function(pl){
                    toastr.success("Retención actualizada", "Se ha modificado la Retención satisfactoriamente");
                    if(enviar){
                        vm.validateSRI(id, 1);                         
                    }
                    else
                        window.location = HOST_ROUTE.TAXDOCUMENT;
                },
                promise.catch(function(reason) {
                        console.log(reason);
                })
            );
        }

        vm.fillTaxDocument = function(){
            vm.TaxDocument.principal_code   = "";
            vm.TaxDocument.emission_date    = vm.FechaHoy ;
            vm.TaxDocument.concept          = ""; // Por definir que dato colocar aquí
            vm.TaxDocument.referral_code    = ""; //Por Definir que dato colocar aquí
            vm.TaxDocument.amount           = vm.totalTaxDocument; 
            vm.TaxDocument.emission_type    = vm.EmissionType; // Debe asocisarse a un valor en BD
            vm.TaxDocument.environment_type = vm.EnvironmentType; // Debe asocisarse a un valor en BD
            vm.TaxDocument.branch_office_id = vm.BranchOfficeId; // Debe asocisarse a un valor en BD
            vm.TaxDocument.document_type_id = DOCUMENT_TYPE.RETENCION;
            vm.TaxDocument.branch_office_id = vm.BranchOfficeId;
            vm.TaxDocument.supplier_id      = vm.SupplierId;
            vm.TaxDocument.is_processed     = 1;
        }

        vm.createSupplier = function(){
            
            if(vm.toggleSelected==true)
                vm.supplier.is_active=1;
            else 
                vm.supplier.is_active=0;
            
            vm.supplier.company_id = vm.company.id;            

            var promise = SupplierService.create(vm.supplier);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El Proveedor fue creado satisfactoriamente");  
                vm.readSupplierList(vm.company.id);  
                angular.element('#myModal').modal('hide');           
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear Proveedor" + errorPl);
            };
        }

        vm.readIdentificationTypeList = function(){
            var promise = EntityMasterDataService.readFilterByEntity(ENTITY.IDENTIFICATION_TYPE);
            promise.then(function(pl){
                vm.IdentificationTypeList = pl.data;
            }); 
        }

        vm.readIdentificationType = function(id){
            var promise = EntityMasterDataService.read(id);
            promise.then(function(pl){
                vm.IdentificationTypeSelected = pl.data;
            }); 
        }

        vm.selectIdentification = function(identificationType){
            // Cédula o Pasaporte
            if(identificationType.id == 18 || identificationType.id == 19){
                vm.MaxCharIdentification = 20;
                vm.MinCharIdentification = 1;
            }
            else{
                vm.MaxCharIdentification = 13;
                vm.MinCharIdentification = 13;
            }

            vm.supplier.identification_type_id = identificationType.id;
        }

        vm.readRetentionList = function(){
            var promise = EntityMasterDataService.readFilterByEntity(ENTITY.RETENTION_DOCUMENT);
            promise.then(function(pl){
                vm.RetentionList = pl.data;
            }); 
        }

        vm.readTaxRetentionList = function(){
            var promise = EntityMasterDataService.readFilterByEntity(ENTITY.TAX_RETENTION);
            promise.then(function(pl){
                vm.TaxList = pl.data;
            }); 
        }

        vm.readTaxPercentageList = function(idTax){
            var promise = CountryTaxService.readPercentage(DEFAULT_COUNTRY.EC, idTax);
            promise.then(function(pl){
                vm.TaxPercentageList = pl.data;
            });
        }

        vm.readTaxPercentageLineList = function(idTax, TaxDocument){
            var promise = CountryTaxService.readPercentage(DEFAULT_COUNTRY.EC, idTax);
            promise.then(function(pl){
                //vm.TaxPercentageList = pl.data;
                TaxDocument.TaxPercentageList = pl.data;
            });
        }

        vm.resetTaxDocument = function(){
            window.location.reload();
         }

        vm.readIdentificationTypeList();
        
    }
})();