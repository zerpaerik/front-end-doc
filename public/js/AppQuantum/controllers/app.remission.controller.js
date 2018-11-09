(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('RemissionController', RemissionController);

    RemissionController.$inject = ['$scope', '$http', 'RemissionService', 'DispatcherService', 
    'InvoiceService','CountryTaxService', 'EntityMasterDataService', 'ProductService', 'ENTITY', 
    'DEFAULT_COUNTRY', 'DOCUMENT_TYPE', 'REMISSION_DEFAULT_TAX_CODE', 
    '$rootScope', 'toastr', 'HOST_ROUTE', 'SRI_SERVICE', 'SweetAlert'];

    function RemissionController($scope, $http, RemissionService, DispatcherService, 
        InvoiceService, CountryTaxService,  EntityMasterDataService, ProductService, ENTITY, 
        DEFAULT_COUNTRY, DOCUMENT_TYPE, REMISSION_DEFAULT_TAX_CODE, 
        $rootScope, toastr, HOST_ROUTE, SRI_SERVICE, SweetAlert) {
        
        var vm = this;

        vm.localLang = {           
            reset           : "Deshacer",
            search          : "Buscar Transportista",
            nothingSelected : "Seleccione un Transportista"
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

        vm.popup1 = {
            opened: false
        }

        vm.open1 = function() {
            vm.popup1.opened = true;
        };

        vm.popup2 = {
            opened: false
        }

        vm.open2 = function() {
            vm.popup2.opened = true;
        };

        vm.showRenta = '';
        vm.FechaHoy        = new Date();
        vm.referralDocumentTypeSelected = "";
        vm.ReferalCode     = '';
        vm.CompanyId       = 0; // Colocar valor desde la BD
        vm.BranchOfficeId  = 0; // Colocar valor desde la BD
        vm.DispatcherId      = 0;
        vm.EmissionType    = 0; // Debe asocisarse a un valor en BD
        vm.EnvironmentType = 0;  // Debe asocisarse a un valor en BD
        vm.toggleSelected  = true;
        vm.dispatcher        = {};
        vm.IdentificationTypeSelected = true; 
        vm.IdentificationTypeList     = [];
        vm.MaxCharIdentification      = 13;
        vm.MinCharIdentification = 1;

        vm.EnableTaxButton     = false;
        vm.InvoiceList         = [];
        vm.DispatcherList        = [];
        vm.DispatcherListTemp    = [];
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
            dispatcher_id   : "",
            car_register    : "",
            starting_point  : "",
            startdate_transport : "",
            enddate_transport : "",
            destination_transport: "",
            reason_transport : "",
            custom_document : "",
            route : "",
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

        vm.validateSRI = function(id, redirect = null){
            SweetAlert.swal({
                  title: 'Enviar Guía de Remisión al SRI',
                  text: "¿Está seguro que desea enviar la Guía de Remisión al SRI?",
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
                  var promise = RemissionService.sendSRI(SRI_SERVICE.URL_REMISSION, id);
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
                           window.location = HOST_ROUTE.REMISSION + "/create"; 
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
            var promise = TaxDocumentService.create(vm.TaxDocument, Id);
            promise.then(function(pl){
                var retorno = pl.data;                
                toastr.success("La Guía de Remisión fue creada satisfactoriamente"); 
                window.location = HOST_ROUTE.REMISSION;               
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear la Guía de Remisión" + errorPl);
                window.location = HOST_ROUTE.REMISSION;
            };
        }

        vm.update = function(){
            var promise = TaxDocumentService.update(vm.TaxDocumentLine, vm.TaxDocumentLine.id);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("La Guía de Remisión fue actualizada satisfactoriamente"); 
                window.location = HOST_ROUTE.REMISSION;               
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al editar la Guía de Remisión" + errorPl);
                window.location = HOST_ROUTE.REMISSION;
            };
        }  

        vm.readAll = function(idCompany){
            var promise = RemissionService.readAll(idCompany);
            promise.then(function(pl){
                vm.RemissionGuideList = pl.data;
            }); 
        }

        // Listas tipo Combos para Facturación
        vm.readDispatcherList = function (IdCompany) {
            var promise = DispatcherService.readFilter(IdCompany);
            promise.then(function (pl) {
                vm.DispatcherList = pl.data;
            }),
            function (errorPl) {
                vm.error = errorPl;
            };
        }

        vm.readInvoicesList = function(idCompany){
            var promise = InvoiceService.readInvoicesByCompany(idCompany);
            promise.then(function(pl){
                vm.InvoiceList = pl.data;
            }); 
        }

        vm.loadCombos = function(IdCompany, IdBranch){
           vm.CompanyId = IdCompany;
           vm.BranchOfficeId = IdBranch;
           //vm.readRetentionList();
           vm.readDispatcherList(IdCompany);
           vm.readInvoicesList(IdCompany);
           //vm.readTaxRetentionList();
        }

        // Pendiente por modificar
        vm.selectDispatcher = function (data) {
             var datos = data.originalObject;
             vm.DispatcherId = datos.id;
             vm.dispatcher.social_reason   = datos.social_reason;
             vm.dispatcher.comercial_name  = datos.comercial_name;
             vm.dispatcher.email           = datos.email;
             vm.dispatcher.address         = datos.address;
             vm.dispatcher.phone           = datos.phone;
             vm.dispatcher.identification  = datos.identification_number;
             vm.EnableInvoice = true;
        }; 

        vm.selectInvoice = function (data) {
             var datos = data.originalObject;
             vm.InvoiceId = datos.id;
             vm.Invoice = datos;
             vm.EnableTaxButton = true;

             // Permite traer los productos de la compañia
             var promise = ProductService.readAllFilter(vm.CompanyId);
             promise.then(function(pl){
                vm.Products = pl.data;

                vm.TaxDocument.taxDocumentLine = [];

                angular.forEach(vm.Invoice.invoice_line, function(line, key){
                    var taxdocumentline = {};

                    taxdocumentline.tax_document_id = 0;
                    taxdocumentline.referral_document_type = DOCUMENT_TYPE.FACTURA;
                    taxdocumentline.referral_document = vm.Invoice.referral_code;
                    taxdocumentline.doc_emission_date = vm.Invoice.invoice_date;
                    taxdocumentline.tax_type_code = REMISSION_DEFAULT_TAX_CODE.TAX_CODE;
                    taxdocumentline.tax_base_amount = 0;
                    taxdocumentline.tax_percentage = 0;
                    taxdocumentline.tax_total_amount = 0;
                    taxdocumentline.product_id = line.product_id;
                    taxdocumentline.quantity = line.quantity;

                    vm.TaxDocument.taxDocumentLine.push(taxdocumentline);

                });

                // Asigna la instancia de producto en la linea de la factura para poder
                // Visualizar los datos de Principal Code, Auxiliar Code
                angular.forEach(vm.TaxDocument.taxDocumentLine, function(line, key){
                    angular.forEach(vm.Products, function(product, keyproduct){
                        if(line.product_id==product.id){
                            line.product = product;
                        }
                    })
                });
              });

             

             //vm.TaxDocument.
             // var promise = InvoiceService.readInvoiceCreditNote(datos.id);
             // promise.then(function(pl){
             //     vm.Invoice = pl.data.invoice;
             //     vm.Invoice.invoiceline = pl.data.invoice_line;
             //     // Guarda los valores originales netos que vienen de la factura
             //     vm.InvoiceLine = angular.copy(pl.data.invoice_line);
             //     //vm.ReasonCreditNote = true;
             //     //vm.updateCreditNote();
             // }); 
        };

        vm.SelectReferralDocumentType = function(data){
            vm.DocumentLine.referral_document_type = data;
            angular.forEach(vm.RetentionList, function(retention, key){
                if(retention.id===data){
                    vm.DocumentLine.referralDocumentType = retention;
                }
            });
        };

        // vm.SelectTaxTypeCode = function(data, param){
            
        //     if(data.taxtypecode.id === 109)
        //         vm.showRenta = '1';            
        //     else 
        //         vm.showRenta = '';            

        //     vm.DocumentLine.tax_type_code = data.taxtypecode.id;
        //     vm.readTaxPercentageList(data.taxtypecode.id);
        //     vm.readTaxPercentageLineList(data.taxtypecode.id, data);
        //     data.tax_percentage = 0;
        //     vm.updateTaxDocumentLine(data, param);
        // }; 

        // vm.SelectRetentionTypeCode = function(data, param){
        //     vm.DocumentLine.retention_type_code = data.retentiontypecode.id;
        //     data.tax_percentage = parseFloat(data.retentiontypecode.value);
        //     vm.updateTaxDocumentLine(data, param);
        // }; 

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

        // Métodos para generar Proforma y Emitir Factura
        vm.createRemission = function(){

            if(vm.validate())
            {
                vm.TaxDocument.company_id       = vm.CompanyId;
                vm.TaxDocument.branch_office_id = vm.BranchOfficeId;
                vm.TaxDocument.invoice_id       = vm.InvoiceId;
                vm.TaxDocument.dispatcher_id    = vm.DispatcherId;   
                vm.TaxDocument.amount           = 0;

                var promise = RemissionService.create(vm.TaxDocument)
                    promise.then(function(pl){
                        toastr.success("Guía de Remisión generada", "Se ha creado la Guía de Remisión satisfactoriamente");
                        vm.validateSRI(pl.data, true);
                    },
                    promise.catch(function(reason) {
                            console.log(reason);
                    })
                ); 
            } 
        }

        vm.validate = function(){
            if(vm.DispatcherId==="" || vm.DispatcherId===undefined||vm.DispatcherId===0){
                SweetAlert.swal("Guía de Remisión!", "Debe seleccionar un Transportista!", "warning"); 
                return false;
            }
            if(vm.TaxDocument.car_register==="" || vm.TaxDocument.car_register===undefined){
                SweetAlert.swal("Guía de Remisión!", "Debe ingresar una Placa de Transporte!", "warning"); 
                return false;
            }
            if(vm.TaxDocument.reason_transport==="" || vm.TaxDocument.reason_transport===undefined){
                SweetAlert.swal("Guía de Remisión!", "Debe ingresar un Motivo de Traslado!", "warning"); 
                return false;
            }
            if(vm.TaxDocument.starting_point==="" || vm.TaxDocument.starting_point===undefined){
                SweetAlert.swal("Guía de Remisión!", "Debe ingresar un Origen (Punto de partida)!", "warning"); 
                return false;
            }
            if(vm.TaxDocument.destination_transport==="" || vm.TaxDocument.destination_transport===undefined){
                SweetAlert.swal("Guía de Remisión!", "Debe ingresar un Destino (Punto de llegada)!", "warning"); 
                return false;
            }
            if(vm.TaxDocument.route==="" || vm.TaxDocument.route===undefined){
                SweetAlert.swal("Guía de Remisión!", "Debe ingresar una Ruta!", "warning"); 
                return false;
            }
            if(vm.TaxDocument.destination_branch_code==="" || vm.TaxDocument.destination_branch_code===undefined){
                SweetAlert.swal("Guía de Remisión!", "Debe ingresar un Código de Establecimiento Destino!", "warning"); 
                return false;
            }
            if(vm.TaxDocument.startdate_transport==="" || vm.TaxDocument.startdate_transport===undefined){
                SweetAlert.swal("Guía de Remisión!", "La Fecha de Salida debe tener una fecha válida !", "warning"); 
                return false;
            }
            if(vm.TaxDocument.enddate_transport==="" || vm.TaxDocument.enddate_transport===undefined){
                SweetAlert.swal("Guía de Remisión!", "La Fecha de Llegada debe tener una fecha válida !", "warning"); 
                return false;
            }
            if(vm.TaxDocument.startdate_transport > vm.TaxDocument.enddate_transport){
                SweetAlert.swal("Guía de Remisión!", "La Fecha de Salida no puede ser mayor a la Fecha de Llegada !", "warning"); 
                return false;
            }
            return true;
        }

        // vm.updateRetention = function(id, enviar = null){
        //     vm.fillTaxDocument();
        //     vm.TaxDocument.taxDocumentLine  = vm.TaxDocumentLine;                    
            
        //     var promise = TaxDocumentService.update(vm.TaxDocument, id)
        //         promise.then(function(pl){
        //             toastr.success("Guía de Remisión actualizada", "Se ha modificado la Guía de Remisión satisfactoriamente");
        //             if(enviar){
        //                 vm.validateSRI(id, 1);                         
        //             }
        //             else
        //                 window.location = HOST_ROUTE.REMISSION;
        //         },
        //         promise.catch(function(reason) {
        //                 console.log(reason);
        //         })
        //     );
        // }

        // vm.fillTaxDocument = function(){
        //     vm.TaxDocument.principal_code   = "";
        //     vm.TaxDocument.emission_date    = vm.FechaHoy ;
        //     vm.TaxDocument.concept          = ""; // Por definir que dato colocar aquí
        //     vm.TaxDocument.referral_code    = ""; //Por Definir que dato colocar aquí
        //     vm.TaxDocument.amount           = vm.totalTaxDocument; 
        //     vm.TaxDocument.emission_type    = vm.EmissionType; // Debe asocisarse a un valor en BD
        //     vm.TaxDocument.environment_type = vm.EnvironmentType; // Debe asocisarse a un valor en BD
        //     vm.TaxDocument.branch_office_id = vm.BranchOfficeId; // Debe asocisarse a un valor en BD
        //     vm.TaxDocument.document_type_id = DOCUMENT_TYPE.RETENCION;
        //     vm.TaxDocument.branch_office_id = vm.BranchOfficeId;
        //     vm.TaxDocument.supplier_id      = vm.SupplierId;
        //     vm.TaxDocument.is_processed     = 1;
        // }

        vm.createDispatcher = function(){
            
            if(vm.toggleSelected==true)
                vm.dispatcher.is_active=1;
            else 
                vm.dispatcher.is_active=0;
            
            vm.dispatcher.company_id = vm.company.id;            

            var promise = DispatcherService.create(vm.dispatcher);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El Transportista fue creado satisfactoriamente");  
                vm.readDispatcherList(vm.company.id);  
                angular.element('#myModal').modal('hide');           
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear Transportista" + errorPl);
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

            vm.dispatcher.identification_type_id = identificationType.id;
        }

        // vm.readRetentionList = function(){
        //     var promise = EntityMasterDataService.readFilterByEntity(ENTITY.RETENTION_DOCUMENT);
        //     promise.then(function(pl){
        //         vm.RetentionList = pl.data;
        //     }); 
        // }

        // vm.readTaxRetentionList = function(){
        //     var promise = EntityMasterDataService.readFilterByEntity(ENTITY.TAX_RETENTION);
        //     promise.then(function(pl){
        //         vm.TaxList = pl.data;
        //     }); 
        // }

        // vm.readTaxPercentageList = function(idTax){
        //     var promise = CountryTaxService.readPercentage(DEFAULT_COUNTRY.EC, idTax);
        //     promise.then(function(pl){
        //         vm.TaxPercentageList = pl.data;
        //     });
        // }

        // vm.readTaxPercentageLineList = function(idTax, TaxDocument){
        //     var promise = CountryTaxService.readPercentage(DEFAULT_COUNTRY.EC, idTax);
        //     promise.then(function(pl){
        //         //vm.TaxPercentageList = pl.data;
        //         TaxDocument.TaxPercentageList = pl.data;
        //     });
        // }

        vm.resetRemission = function(){
            window.location.reload();
         }

        vm.readIdentificationTypeList();
        
    }
})();