(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('CreditNoteController', CreditNoteController);

    CreditNoteController.$inject = ['$scope', 'SERVER_CONFIG', '$http', 'CreditNoteService', 'InvoiceService', 'CompanyService', 'ClientService', 
    'ProductService', 'ProductTaxService', 'EntityMasterDataService', 'CountryTaxService', 'ENTITY', 'TAX', 'toastr', '$rootScope', 'HOST_ROUTE', 
    'SweetAlert', 'SRI_SERVICE', 'DOCUMENT_TYPE'];

    function CreditNoteController($scope, SERVER_CONFIG, $http, CreditNoteService, InvoiceService, CompanyService, ClientService, 
        ProductService, ProductTaxService, EntityMasterDataService, CountryTaxService, ENTITY, TAX, toastr, $rootScope, HOST_ROUTE, 
        SweetAlert, SRI_SERVICE, DOCUMENT_TYPE) {
        
        var vm = this;

        vm.localLang = {           
            reset           : "Deshacer",
            search          : "Buscar cliente",
            nothingSelected : "Seleccione un cliente"         //default-label is deprecated and replaced with this.
        }

        vm.FechaHoy = new Date();
        vm.InvoiceNumber = '';
        vm.BranchOfficeId = 0; // Colocar valor desde la BD
        vm.CompanyId = 0; // Colocar valor desde la BD
        vm.ClientId = 0;
        vm.EmissionType = 0; // Debe asocisarse a un valor en BD
        vm.EnvironmentType = 0;  // Debe asocisarse a un valor en BD
        vm.toggleSelected = true;
        vm.client = {};

        vm.APIHOST = SERVER_CONFIG.API_HOST;   
        
        vm.EnableInvoice = false;
        vm.EnableButtons = false;
        vm.ReasonCreditNote = false;
        vm.ClientList = [];
        vm.invoiceclient = {};
        vm.ProductList = [];
        vm.Invoice = {
            id: 0,
            principal_code : "",
            invoice_date : "",
            concept : "",
            referral_code: "",
            total_discount: "",
            total_ice: "",
            total_iva: "",
            total_invoice: "",
            emission_type: "",
            environment_type: "",
            status: "P",
            branch_office_id: "",
            company_id: "",
            client_id: "",
            invoiceline     : [],
            invoicepayment  : [],
            invoicetax      : [],                    
        };
        vm.InvoiceLine = [];
        vm.TaxList = [];
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
            creditNoteLine  : []
        };
        vm.CreditNoteLine     = [];
        // Variables para totales
        vm.subtotal = 0;   
        vm.totalCreditNote = 0;
        vm.totalDiscount = 0;
        vm.totalInvoiceNet = 0;
        vm.total_iva_12 = 0;
        vm.totalInvoiceNoTax      = 0;
        vm.subtotal_iva_12        = 0;
        vm.subtotal_iva_0         = 0;
        vm.subtotal_iva_exento    = 0;
        vm.subtotal_iva_no_objeto = 0;

        vm.counterTip = 0;

        vm.validateSRI = function(id, redirect = null){
            SweetAlert.swal({
                  title: 'Enviar Nota de Crédito al SRI',
                  text: "¿Está seguro que desea enviar la Nota de Crédito al SRI?",
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
                  var promise = CreditNoteService.sendSRI(SRI_SERVICE.URL_CREDITNOTE, id);
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
                           window.location = HOST_ROUTE.CREDITNOTE + "/create"; 
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

        vm.createCreditNote = function(Id){
            if(vm.validate() && !vm.validateQuantity()){
                vm.TaxDocument.invoice_id       = vm.Invoice.id;
                vm.TaxDocument.principal_code   = "";
                vm.TaxDocument.emission_date    = vm.FechaHoy ;
                vm.TaxDocument.creditNoteLine   = vm.CreditNoteLine; 
                vm.TaxDocument.branch_office_id = vm.BranchOfficeId; 
                vm.TaxDocument.amount           = vm.totalCreditNote;  
                vm.TaxDocument.concept          = vm.CreditNote.concept; // Por definir que dato colocar aquí
                vm.TaxDocument.referral_code    = ""; //Por Definir que dato colocar aquí
                vm.TaxDocument.emission_type    = vm.EmissionType; // Debe asocisarse a un valor en BD
                vm.TaxDocument.environment_type = vm.EnvironmentType; // Debe asocisarse a un valor en BD
                vm.TaxDocument.document_type_id = DOCUMENT_TYPE.NOTA_CREDITO;
                vm.TaxDocument.is_processed     = 1;     

                vm.TaxDocument.creditNoteLine = vm.CreditNoteLine;        
                
                var promise = CreditNoteService.create(vm.TaxDocument)
                    promise.then(function(pl){
                        toastr.success("Nota de Crédito generada", "Se ha creado la Nota de Crédito satisfactoriamente");
                        vm.validateSRI(pl.data, true);
                    },
                    promise.catch(function(reason) {
                            console.log(reason);
                    })
                );
            }
        }

        vm.validate = function(){
            var retorno = true;
            var itemseleccionado = false;
            if(vm.CreditNote.concept.length==0){
               SweetAlert.swal("Razón de Nota de Crédito", "Debe incluir una razón de la Nota de Crédito", "warning"); 
               retorno = false;
            }

            angular.forEach(vm.Invoice.invoiceline, function(data, key){
                if(data.check) itemseleccionado = true;
            });

            if(!itemseleccionado){
               SweetAlert.swal("Items Nota de Crédito", "Debe seleccionar por lo menos un Item para generar la Nota de Crédito", "warning"); 
               retorno = false;  
            } 

            return retorno;
        }

        vm.validateQuantity = function(){
            var retorno_q_mayor = true;
            var retorno_q_cero  = true;

            angular.forEach(vm.Invoice.invoiceline, function(data, key){
                if(data.check) {
                    angular.forEach(vm.InvoiceLine, function(line, key){
                        if(line.principal_code==data.principal_code){
                            var quantity = parseInt(data.quantity);
                            if(quantity>line.quantity){
                                retorno_q_mayor = false;
                            }
                            if(quantity<=0){
                                retorno_q_cero = false;
                            }
                        }
                    });
                }
            }); 

            if(!retorno_q_mayor) SweetAlert.swal("Items Nota de Crédito", "La cantidad del Item seleccionado es mayor a la factura", "warning"); 

            if(!retorno_q_cero) SweetAlert.swal("Items Nota de Crédito", "La cantidad del Item seleccionado no puede ser menor o igual a cero", "warning"); 

            return !(retorno_q_mayor || retorno_q_cero);
        }        

        vm.readAll = function(idCompany){
            var promise = InvoiceService.readAll(idCompany);
            promise.then(function(pl){
                vm.InvoiceList = pl.data;
            }); 
        }

        // Listas tipo Combos para Facturación

        vm.loadCombos = function(IdCompany, IdBranch){
           //IdCompany = 11; // Eliminar linea
           //IdBranch = 13; // Eliminar linea
           vm.CompanyId = IdCompany;
           vm.BranchOfficeId = IdBranch;
           vm.readCompanyInfo(IdCompany);
           vm.readClientList(IdCompany);
           vm.readCountryTax();
        }

        vm.readClientList = function (IdCompany) {
            var promise = ClientService.readFilter(IdCompany);
            promise.then(function (pl) {
                vm.ClientList = pl.data;
            }),
            function (errorPl) {
                vm.error = errorPl;
            };
        }

        vm.readInvoiceList = function (IdClient) {
            var promise = InvoiceService.readInvoiceByClient(vm.CompanyId, IdClient);
            promise.then(function (pl) {
                vm.InvoiceList = pl.data;
            }),
            function (errorPl) {
                vm.error = errorPl;
            };
        }

        vm.readCompanyInfo = function(IdCompany){
          var promise = CompanyService.read(IdCompany);
          promise.then(function(pl){
              vm.CompanyInfo = pl.data;
          }); 
        }

        vm.readCountryTax = function(){
            var promise = CountryTaxService.readFilter(28, ENTITY.TAX);
            promise.then(function(pl){
                vm.TaxList = pl.data;
            });
        }

        vm.EnableCreditNote = function(){
            if(vm.CreditNote.concept.length>0) {
                vm.EnableButtons = true;
            }else{
                vm.EnableButtons = false;
            }
        }

        vm.selectClient= function (data) {
            // var promise = ClientService.read(data.id);
            // promise.then(function(pl){
             var datos = data.originalObject;
             vm.ClientId = datos.id;
             vm.invoiceclient.social_reason   = datos.social_reason;
             vm.invoiceclient.comercial_name  = datos.comercial_name;
             vm.invoiceclient.email           = datos.email;
             vm.invoiceclient.address         = datos.address;
             vm.invoiceclient.phone           = datos.phone;
             vm.invoiceclient.identification  = datos.identification_number;

             vm.readInvoiceList(datos.id);

             vm.ReasonCreditNote = false;

             vm.EnableInvoice = true;
           // });           
        };  

        vm.selectInvoice = function (data) {
             var datos = data.originalObject;
             vm.InvoiceId = datos.id;
             var promise = InvoiceService.readInvoiceCreditNote(datos.id);
             promise.then(function(pl){
                 vm.Invoice = pl.data.invoice;
                 vm.Invoice.invoiceline = pl.data.invoice_line;
                 // Guarda los valores originales netos que vienen de la factura
                 vm.InvoiceLine = angular.copy(pl.data.invoice_line);
                 vm.ReasonCreditNote = true;
                 vm.updateCreditNote();
             }); 
        }; 

        vm.updateCreditNote = function(){
            vm.totalCreditNote        = 0;
            vm.totalInvoiceNoTax      = 0;
            vm.totalDiscount          = 0;
            vm.totalInvoiceNet        = 0;
            vm.total_iva_12           = 0; 
            vm.subtotal_iva_14        = 0;
            vm.subtotal_iva_12        = 0;
            vm.subtotal_iva_0         = 0;
            vm.subtotal_iva_exento    = 0;
            vm.subtotal_iva_no_objeto = 0;
            var total_tax = 0; 
            var creditNoteLine = {};
            vm.CreditNoteLine = vm.CreditNoteLine || [];

            angular.forEach(vm.Invoice.invoiceline, function(invoiceLine, key){
                // vErifica si el item está seleccionado.
                if(invoiceLine.check) 
                {
                    var discount = (invoiceLine.unit_price * invoiceLine.quantity * invoiceLine.discount / 100);
                    vm.totalDiscount += discount;
                    invoiceLine.subtotal = (invoiceLine.unit_price * invoiceLine.quantity) - discount;
                    invoiceLine.subtotal = parseFloat(invoiceLine.subtotal.toFixed(2));

                    vm.totalInvoiceNoTax  +=  invoiceLine.subtotal;

                    var taxValue = invoiceLine.subtotal * invoiceLine.taxes[0].tax_percentage_value / 100;

                    if(invoiceLine.taxes[0].tax_id==TAX.IVA_12){
                        vm.subtotal_iva_12 += invoiceLine.subtotal;
                        vm.total_iva_12 += parseFloat(taxValue.toFixed(2));
                    }else if(invoiceLine.taxes[0].tax_id==TAX.IVA_0){
                        vm.subtotal_iva_0 += invoiceLine.subtotal;
                    }else if(invoiceLine.taxes[0].tax_id==TAX.IVA_14){
                        vm.subtotal_iva_14 += invoiceLine.subtotal;
                    }else if(invoiceLine.taxes[0].tax_id==TAX.IVA_NO_OBJETO){
                        vm.subtotal_iva_no_objeto += invoiceLine.subtotal;
                    }else if(invoiceLine.taxes[0].tax_id==TAX.IVA_EXENTO){
                        vm.subtotal_iva_exento += invoiceLine.subtotal;
                    }
                    
                    vm.totalCreditNote += (invoiceLine.subtotal + taxValue);
                    vm.totalCreditNote = parseFloat(vm.totalCreditNote.toFixed(2));

                    let existe = false;

                    angular.forEach(vm.CreditNoteLine, function(line, key){
                        if(invoiceLine.product_id==line.product_id){
                            line.quantity = invoiceLine.quantity;
                            existe = true;
                        }
                    });

                    if(!existe){
                        // Incluye las lineas de la Nota de Crédito
                        creditNoteLine.product_id = invoiceLine.product_id;
                        creditNoteLine.taxdocumemt_id = 0;
                        creditNoteLine.country_tax_id  = invoiceLine.country_tax_id;
                        creditNoteLine.quantity = invoiceLine.quantity;
                        creditNoteLine.unit_price = invoiceLine.unit_price; 
                        vm.CreditNoteLine.push(creditNoteLine);
                    }
                }
            });

            console.log(vm.totalInvoiceNoTax);

        }

        // Métodos para Invoice Line
        vm.updateCreditNoteLine = function(invoiceLine){
            if(invoiceLine.discount===undefined) invoiceLine.discount = 0;
            if(invoiceLine.quantity===undefined) invoiceLine.quantity = 0;
            if(invoiceLine.unit_price===undefined) invoiceLine.unit_price = 0;

            if(!vm.validateQuantity()){

                invoiceLine.unit_price = parseFloat(invoiceLine.unit_price);
                invoiceLine.quantity = parseInt(invoiceLine.quantity);
                invoiceLine.discount = parseFloat(invoiceLine.discount);

                invoiceLine.subtotal = (invoiceLine.unit_price * invoiceLine.quantity) - (invoiceLine.unit_price * invoiceLine.quantity * invoiceLine.discount / 100);
                invoiceLine.line_sub_total = parseFloat(invoiceLine.subtotal.toFixed(2));

                var tax = 0;

                if(invoiceLine.taxes===undefined){
                    var promise = ProductTaxService.readDefault(invoiceLine.product_id);
                    promise.then(function(pl){
                        tax = invoiceLine.subtotal * pl.data.countrytax.value / 100;
                        invoiceLine.taxes = pl.data.countrytax;
                        invoiceLine.country_tax_id = pl.data.countrytax.id;
                        vm.updateCreditNote();
                    });    
                }else{
                    tax = invoiceLine.subtotal * invoiceLine.taxes.tax_percentage_value / 100;
                    tax = parseFloat(tax.toFixed(2));
                    vm.updateCreditNote();
                }
            }
        }

        vm.fillCreditNote = function(){
            vm.TaxDocument.principal_code   = "";
            vm.TaxDocument.emission_date    = vm.FechaHoy ;
            vm.TaxDocument.concept          = vm.CreditNote.concept; // Por definir que dato colocar aquí
            vm.TaxDocument.referral_code    = ""; //Por Definir que dato colocar aquí
            vm.TaxDocument.amount           = vm.totalCreditNote; 
            vm.TaxDocument.emission_type    = vm.EmissionType; // Debe asocisarse a un valor en BD
            vm.TaxDocument.environment_type = vm.EnvironmentType; // Debe asocisarse a un valor en BD
            vm.TaxDocument.branch_office_id = vm.BranchOfficeId; // Debe asocisarse a un valor en BD
            vm.TaxDocument.document_type_id = DOCUMENT_TYPE.NOTA_CREDITO;
            vm.TaxDocument.is_processed     = 1;
        }

        // vm.fillCreditNote = function(status){
        //     vm.Invoice.principal_code = vm.InvoiceNumber;
        //     vm.Invoice.invoicedate = vm.FechaHoy ;
        //     vm.Invoice.concept = ""; // Por definir que dato colocar aquí
        //     vm.Invoice.referral_code = ""; //Por Definir que dato colocar aquí
        //     vm.Invoice.total_discount = vm.totalDiscount; 
        //     vm.Invoice.total_ice = 0;
        //     vm.Invoice.total_iva = vm.total_iva_12;
        //     vm.Invoice.total_invoice = vm.totalInvoice;
        //     vm.Invoice.emission_type = vm.EmissionType; // Debe asocisarse a un valor en BD
        //     vm.Invoice.environment_type = vm.EnvironmentType; // Debe asocisarse a un valor en BD
        //     vm.Invoice.status = status;
        //     vm.Invoice.branch_office_id = vm.BranchOfficeId; // Debe asocisarse a un valor en BD
        //     vm.Invoice.company_id = vm.CompanyId; // Debe asociarse a un valor en BD
        //     vm.Invoice.client_id = vm.ClientId;
        // }

        vm.resetCreditNote = function(){
            window.location.reload();
        }

}
})();