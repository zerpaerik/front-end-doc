(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('InvoiceController', InvoiceController);

    InvoiceController.$inject = ['$scope', 'SERVER_CONFIG', '$http', 'InvoiceService', 'CompanyService', 'ClientService', 
    'ProductService', 'ProductTaxService', 'EntityMasterDataService', 'CountryTaxService', 'ENTITY', 'TAX', 'toastr', '$rootScope', 'HOST_ROUTE', 'SweetAlert', 'SRI_SERVICE'];

    function InvoiceController($scope, SERVER_CONFIG, $http, InvoiceService, CompanyService, ClientService, 
        ProductService, ProductTaxService, EntityMasterDataService, CountryTaxService, ENTITY, TAX, toastr, $rootScope, HOST_ROUTE, SweetAlert, SRI_SERVICE) {
        
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
        vm.tiptoggleSelected = false;
        vm.solidaritySelected = false;
        vm.client = {};
        vm.IdentificationTypeSelected = true; 
        vm.IdentificationTypeList = [];
        vm.MaxCharIdentification = 13;
        vm.MinCharIdentification = 1;
        vm.SourceCountryList = [];                
        vm.DestinationCountryList =[];
        vm.SellerCountryList = [];
        vm.ExportInvoicetoggleSelected = false;

        vm.APIHOST = SERVER_CONFIG.API_HOST;   
        vm.Product = [{
            "product_id": "",
            "name": "",
            "invoice_id": "",
            "quantity": "1",
            "unit_price": "0",
            "discount": "0",
            "tax": []
        }];
        vm.Payment = {
            "id": "",
            "code": "",
            "name": "",
            "description": "",
            "field": "",
            "is_active": "",
            "entity_id": "",
            "is_deleted": ""
        }
        vm.Bank = {
            "id": "",
            "code": "",
            "name": "",
            "description": "",
            "field": "",
            "is_active": "",
            "entity_id": "",
            "is_deleted": ""
        }
        vm.TimeUnit = {
            "id": "",
            "code": "",
            "name": "",
            "description": "",
            "field": "",
            "is_active": "",
            "entity_id": "",
            "is_deleted": ""
        }
        vm.ProductTax = {
            "id": "",
            "product_id": "",
            "countrytax": {
                "id": "",
                "value": "0",
                "tax_id": "",
                "tax_percentage_id": ""
            }
        }
        
        vm.EnableInvoice = false;
        vm.EnablePayment = false;
        vm.EnableButtons = false;
        vm.EnablePreInvoice = false;
        vm.ClientList = [];
        vm.ClientListTemp = [];
        vm.invoiceclient = {};
        vm.ProductList = [];
        vm.PaymentTypeList = [];
        vm.BankList = [];
        vm.TimeUnitList = [];
        vm.Invoice = {
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
        vm.InvoicePaymentType = {
            "document_number": "0",
            "mount": "0",
            "invoice_id": "",
            "time_limit": "",
            "unit_time_id": "",
            "payment_type_id": "",
            "bank_id": ""
        };
        vm.InvoiceTax = [];
        vm.InvoicePayment = [];
        vm.TaxList = [];
        // Variables para totales
        vm.subtotal = 0;   
        vm.totalInvoice = 0;
        vm.totalDiscount = 0;
        vm.totalInvoiceNet = 0;
        vm.total_iva_12 = 0;
        vm.totalInvoiceNoTax      = 0;
        vm.subtotal_iva_14        = 0;
        vm.subtotal_iva_12        = 0;
        vm.subtotal_iva_0         = 0;
        vm.subtotal_iva_exento    = 0;
        vm.subtotal_iva_no_objeto = 0;

        vm.counterTip = 0;
        vm.counterSolidarityDiscount = 0;

        vm.validateSRI = function(id, redirect = null, preinvoice = null){
            SweetAlert.swal({
                  title: 'Enviar factura al SRI',
                  text: "¿Está seguro que desea enviar la factura al SRI?",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si',
                  cancelButtonText: 'No',
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false
            }, 
            function(isConfirm) {
                if(isConfirm === true){
                  vm.loading = true;
                  angular.element('#myModalSRI').modal('show');

                if(preinvoice != null && preinvoice == 1){
                  var addCorrelativePromise = InvoiceService.addCorrelative(id);
                  addCorrelativePromise.then(function(addPl){
                    if(addPl.data == 1){                        
                        var promise = InvoiceService.sendSRI(SRI_SERVICE.URL, id);
                        promise.then(function(pl){
                            var retorno = pl.data;                                        
                            angular.element('#myModalSRI').modal('hide');
                            
                            let htmlString = '';
                            let title = "";
                            var vecSplit = retorno.split(";");
                            var typeMessage = "success";
                            if(retorno.length != 54){
                                title = "Se ha obtenido una respuesta del SRI";
                                for(var i = 0; i < vecSplit.length; i++){
                                    var string = vecSplit[i];
                                    string = string.replace('{', '');
                                    string = string.replace('}', '');
                                    string = string.replace("'", '');
                                    string = string.replace(/(\r\n|\n|\r)/gm,"");
                                    var jsonObject = string.split(":");
                                    if(jsonObject[1]===undefined){
                                        jsonObject[1]="";
                                        typeMessage = "error";
                                    } 
                                    for(var j = 1; j < jsonObject.length; j++)
                                        htmlString += "<strong>"+ jsonObject[j] +"</strong><br>";
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
                                type    : typeMessage
                            }, 
                            function(isConfirm){
                                if(redirect){
                                   window.location = HOST_ROUTE.INVOICE + "/create"; 
                                }
                            });
                        }, 
                        function(plError){
                            angular.element('#myModalSRI').modal('hide');
                            SweetAlert.swal("Hubo un error al enviar al SRI", "" + JSON.stringify(plError), "error");
                            vm.EnableButtons = true;
                        }
                        );
                    }
                    else{
                        SweetAlert.swal("Hubo un error al enviar al SRI", "" + "No se pudo asociar un correlativo a la prefactura", "error");
                    }

                  });

                }

                else{
                    
                        var promise = InvoiceService.sendSRI(SRI_SERVICE.URL, id);
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
                                   window.location = HOST_ROUTE.INVOICE + "/create"; 
                                }
                            });
                        }, 
                        function(plError){
                            angular.element('#myModalSRI').modal('hide');
                            SweetAlert.swal("Hubo un error al enviar al SRI", "" + JSON.stringify(plError), "error");
                        }
                        );
                    
                }

                }
            });
        }

        vm.create = function(Id){
            var promise = InvoiceService.create(vm.invoice, Id);
            promise.then(function(pl){
                var retorno = pl.data;                
                toastr.success("La prefactura fue creada satisfactoriamente"); 
                window.location = HOST_ROUTE.PREINVOICE;               
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear la prefactura" + errorPl);
                window.location = HOST_ROUTE.PREINVOICE;
            };
        }

        vm.searchClient = function(clientData){
            var promise = ClientService.search(clientData);
            promise.then(function(pl){
                vm.client = pl.data;
            });
        }

        vm.update = function(){
            var promise = InvoiceService.update(vm.product, vm.product.id);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("La prefactura fue actualizada satisfactoriamente"); 
                window.location = HOST_ROUTE.PREINVOICE;               
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al editar la prefactura" + errorPl);
                window.location = HOST_ROUTE.PREINVOICE;
            };
        }  

        vm.delete = function(id){
            var promise = InvoiceService.delete(id);
            promise.then(function(pl){
                var retorno = pl.data;
                if(retorno == 1){
                    toastr.success("La prefactura fue eliminada satisfactoriamente");
                    window.location = HOST_ROUTE.PREINVOICE;
                }
                else{
                    toastr.error("La prefactura no pudo ser eliminada");
                }
                
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al eliminar la prefactura" + errorPl);
                window.location = HOST_ROUTE.PREINVOICE;
            };
        }      

        vm.edit = function(id){
            var promise = InvoiceService.readPreinvoice(id);
            promise.then(function(pl){
                
                vm.ClientId = pl.data.client_id;
                vm.Invoice  = pl.data;  
                vm.FechaHoy = pl.data.invoice_date;
                vm.invoiceclient.identification = pl.data.client.identification_number;
                vm.invoiceclient.social_reason  = pl.data.client.social_reason;
                vm.invoiceclient.phone          = pl.data.client.phone;
                vm.invoiceclient.comercial_name = pl.data.client.comercial_name;
                vm.invoiceclient.email          = pl.data.client.email;
                vm.invoiceclient.address        = pl.data.client.address; 

                if(pl.data.export_invoice === 1) 
                    vm.ExportInvoicetoggleSelected = true;
                else 
                    vm.ExportInvoicetoggleSelected = false;               

                // Lista de valores de campos de paises
                vm.sourceCountrySelected      = vm.Invoice.source_countries;
                vm.destinationCountrySelected = vm.Invoice.destination_countries;
                vm.sellerCountrySelected      = vm.Invoice.seller_countries;

                //vm.Invoice        = pl.data.Invoice;
                vm.InvoiceLine    = pl.data.invoice_line;                
                vm.InvoicePayment = pl.data.invoice_payment;
                vm.updateInvoice();
            });
        }

        vm.readAll = function(idCompany){
            var promise = InvoiceService.readAll(idCompany);
            promise.then(function(pl){
                vm.InvoiceList = pl.data;
            }); 
        }

        // Listas tipo Combos para Facturación

        vm.readClientList = function (IdCompany) {
            var promise = ClientService.readFilter(IdCompany);
            promise.then(function (pl) {
                vm.ClientList = pl.data;
            }),
            function (errorPl) {
                vm.error = errorPl;
            };
        }

        vm.readProductList = function(IdCompany){
          var promise = ProductService.readAllFilter(IdCompany);
          promise.then(function (pl) {
              vm.ProductList = pl.data;
          });
        }

        vm.readPaymentTypeList = function(IdEntity){
           var promise = EntityMasterDataService.readFilterByEntity(IdEntity);
           promise.then(function (pl) {
              vm.PaymentTypeList = pl.data;
           });
        }

        vm.readBankList = function(IdEntity){
           var promise = EntityMasterDataService.readFilterByEntity(IdEntity);
           promise.then(function (pl) {
              vm.BankList = pl.data;
           });
        }

        vm.readTimeUnitList = function(IdEntity){
           var promise = EntityMasterDataService.readFilterByEntity(IdEntity);
           promise.then(function (pl) {
              vm.TimeUnitList = pl.data;
           });
        }

        vm.readCountryTax = function(){
            var promise = CountryTaxService.readFilter(28, ENTITY.TAX);
            promise.then(function(pl){
                vm.TaxList = pl.data;
            });
        }

        vm.loadCombos = function(IdCompany, IdBranch){
           vm.CompanyId = IdCompany;
           vm.BranchOfficeId = IdBranch;
           vm.readCompanyInfo(IdCompany);
           vm.readClientList(IdCompany);
           vm.readProductList(IdCompany);
           vm.readCountryTax();
           vm.readPaymentTypeList(ENTITY.PAYMENT_TYPE);
           vm.readBankList(ENTITY.BANK);
           vm.readTimeUnitList(ENTITY.TIME_UNIT);
           vm.readCountryList();
        }

        vm.readCompanyInfo = function(IdCompany){
          var promise = CompanyService.read(IdCompany);
          promise.then(function(pl){
              vm.CompanyInfo = pl.data;
          }); 
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
             vm.EnableInvoice = true;
           // });           
        };  

        vm.selectSourceCountry = function(data){
            vm.Invoice.source_country = data;
        }

        vm.selectDestinationCountry = function(data){
            vm.Invoice.destination_country = data;
        }

        vm.selectSellerCountry = function(data){
            vm.Invoice.seller_country = data;
        }

        vm.calculateTip = function(){
            if(vm.tiptoggleSelected){
                vm.Invoice.tip = vm.totalInvoiceNoTax * 0.10;
                vm.totalInvoice += vm.Invoice.tip;
            }else{
                if(vm.Invoice.tip===undefined) vm.Invoice.tip = 0;
                vm.totalInvoice -= vm.Invoice.tip;
                vm.Invoice.tip = 0;
            }
            vm.updateInvoicePayment();
        }

        vm.calculateSolidarityDiscount = function(){
            if(vm.solidarityDiscounttoggleSelected){
                vm.Invoice.solidarity_discount = vm.totalInvoiceNoTax * 0.02;
                vm.totalInvoice -= vm.Invoice.solidarity_discount;
            }else{
                if(vm.Invoice.solidarity_discount===undefined) vm.Invoice.solidarity_discount=0;
                vm.totalInvoice += vm.Invoice.solidarity_discount;
                vm.Invoice.solidarity_discount = 0;  
            }
            vm.updateInvoicePayment();
        }

        vm.taxSelectProduct = function(product){
            vm.updateInvoiceProduct(product);
        }

        vm.taxSelectInvoiceLine = function(product){
            vm.updateInvoiceLine(product);
        }

        vm.updateInvoice = function(){
            vm.totalInvoice           = 0;
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
            //vm.Invoice.InvoiceTax = [];
            vm.InvoiceTax = [];
            //angular.forEach(vm.Invoice.InvoiceLine, function(invoiceLine, key){
            angular.forEach(vm.InvoiceLine, function(invoiceLine, key){
                //var product_tax_a = 0; 
                //var product_tax = 0;
                var discount = (invoiceLine.unit_price * invoiceLine.quantity * invoiceLine.discount / 100);
                vm.totalDiscount += discount;
                invoiceLine.subtotal = (invoiceLine.unit_price * invoiceLine.quantity) - discount;
                invoiceLine.subtotal = parseFloat(invoiceLine.subtotal.toFixed(2));

                vm.totalInvoiceNoTax  +=  invoiceLine.subtotal;

                var taxValue = invoiceLine.subtotal * invoiceLine.tax.value / 100;

                if(invoiceLine.tax.id==TAX.IVA_12){
                    vm.subtotal_iva_12 += invoiceLine.subtotal;
                    vm.total_iva_12 += parseFloat(taxValue.toFixed(2));
                }else if(invoiceLine.tax.id==TAX.IVA_0){
                    vm.subtotal_iva_0 += invoiceLine.subtotal;
                }else if(invoiceLine.tax.id==TAX.IVA_14){
                    vm.subtotal_iva_14 += invoiceLine.subtotal;
                }else if(invoiceLine.tax.id==TAX.IVA_NO_OBJETO){
                    vm.subtotal_iva_no_objeto += invoiceLine.subtotal;
                }else if(invoiceLine.tax.id==TAX.IVA_EXENTO){
                    vm.subtotal_iva_exento += invoiceLine.subtotal;
                }
                
                vm.totalInvoice += (invoiceLine.subtotal + taxValue);
                vm.totalInvoice = parseFloat(vm.totalInvoice.toFixed(2));

                //
                vm.AddOrModifyInvoiceTax(invoiceLine.country_tax_id, invoiceLine.subtotal, taxValue);

                // 
                //invoiceLine.subtotal += taxValue;

                // Permite leer los impuesto o retenciones por el Producto.
                // var promise = ProductTaxService.readFilter(invoiceLine.product_id);
                // promise.then(function(pl){
                //     vm.ProductTax = pl.data;
                //     if(vm.ProductTax.length>0){
                //         // Ciclo para calcular los Impuestos.
                //         angular.forEach(vm.ProductTax, function(producttax, key){
                //             product_tax = invoiceLine.subtotal * producttax.countrytax.value / 100;
                //             product_tax_a += product_tax;
                //             vm.AddOrModifyInvoiceTax(producttax.country_tax_id, invoiceLine.subtotal, product_tax);
                //         });
                //     }
                //     invoiceLine.subtotal += product_tax_a;
                //     total_tax += product_tax_a;
                //     vm.totalInvoice = vm.totalInvoiceNet + total_tax;
                //     vm.InvoicePaymentType.mount = vm.totalInvoice;   
                //     //total_tax += product_tax_a;
                // });
            });

		vm.totalDiscount = parseFloat(vm.totalDiscount.toFixed(2));

            if(vm.Invoice.export_invoice===1){
                if(isNaN(parseInt(vm.Invoice.international_cargo))){
                    SweetAlert.swal("Flete Internacional!", "Flete Internacional acepta valores numericos!", "warning"); 
                    return;
                }

                if(isNaN(parseInt(vm.Invoice.international_secure))){
                    SweetAlert.swal("Seguro Internacional!", "Seguro Internacional acepta valores numericos!", "warning"); 
                    return;
                }

                if(isNaN(parseInt(vm.Invoice.custom_expenditures))){
                    SweetAlert.swal("Gastoas Aduaneros!", "Gastos Aduaneros acepta valores numericos!", "warning"); 
                    return;
                }
                
                if(isNaN(parseInt(vm.Invoice.transport_expenditures))){
                    SweetAlert.swal("Gastos de Transporte!", "Gastos de Transporte acepta valores numericos!", "warning"); 
                    return;
                }

                // Calculos en caso que la factura sea de Exportacion

                if(vm.ExportInvoicetoggleSelected) {
                    vm.totalInvoice += parseFloat(vm.Invoice.international_cargo) + parseFloat(vm.Invoice.international_secure) + 
                                       parseFloat(vm.Invoice.custom_expenditures) + parseFloat(vm.Invoice.transport_expenditures);
                }
            }

            // Recalcula propinas y Descuento solidario
            vm.calculateTip();
            vm.calculateSolidarityDiscount();

            vm.updateInvoicePayment();
        }

        // Permite separar y acumular los impuestos de la factura.
        vm.AddOrModifyInvoiceTax = function(IdTax, baseImponible, valorImpuesto){
            var addtax = true;
            //if(vm.Invoice.InvoiceTax.length>0){
            if(vm.InvoiceTax.length>0){
                //angular.forEach(vm.Invoice.InvoiceTax, function(invoiceTax, key){
                angular.forEach(vm.InvoiceTax, function(invoiceTax, key){
                    if(invoiceTax.country_tax_id===IdTax){
                        invoiceTax.subtotal += baseImponible;
                        invoiceTax.subtotal_tax += valorImpuesto; 
                        addtax = false;
                    }
                });  
            }

            if(addtax ===true)
            {
                // vm.InvoiceTax = [];                
                // vm.InvoiceTax.country_tax_id = IdTax;
                // vm.InvoiceTax.subtotal = baseImponible;
                // vm.InvoiceTax.subtotal_tax = valorImpuesto;
                var invoiceTax = {};
                invoiceTax.country_tax_id = IdTax;
                invoiceTax.subtotal = baseImponible;
                invoiceTax.subtotal_tax = valorImpuesto;
                vm.InvoiceTax.push(invoiceTax);                
            }
        } 

        // Métodos para Invoice Line

        vm.selectProduct = function(idProduct){
            var promise = ProductService.read(idProduct);
            promise.then(function(pl){
                vm.Product.product_id  = idProduct;
                vm.Product.name        = pl.data.name;
                vm.Product.description = pl.data.description;
                vm.Product.unit_price  = pl.data.unit_price;
                if(pl.data.laboratory   !== null) vm.Product.laboratory   = pl.data.laboratory;
                if(pl.data.location     !== null) vm.Product.location     = pl.data.location;
                if(pl.data.expired_date !== null) vm.Product.expired_date = pl.data.expired_date;
                if(pl.data.generic      !== null) vm.Product.generic      = pl.data.generic;
                vm.updateInvoiceLine(vm.Product);
            });
        }

        vm.addInvoiceLine = function(product){
            var invoiceLine = {};
            //vm.Invoice.InvoiceLine = vm.Invoice.InvoiceLine || [];
            vm.InvoiceLine = vm.InvoiceLine || [];

            if(product.product_id==="" || product.product_id===undefined){
                SweetAlert.swal("Linea de Factura!", "Debe seleccionar un producto!", "warning"); 
                return;
            }

            if(product.quantity<=0){
                SweetAlert.swal("Cantidad incorrecta!", "La Cantidad debe ser mayor a cero!", "warning"); 
                return;
            }

            if(isNaN(parseInt(product.quantity))){
                SweetAlert.swal("Cantidad incorrecta!", "La Cantidad acepta solo valores numericos!", "warning"); 
                return;
            }

            if(isNaN(parseInt(product.discount))){
                SweetAlert.swal("Descuento incorrecto!", "El Descuento acepta solo valores numericos!", "warning"); 
                return;
            }

            invoiceLine.product_id = product.product_id;
            invoiceLine.unit_price = product.unit_price;
            invoiceLine.quantity = product.quantity;
            invoiceLine.discount = product.discount;
            invoiceLine.subtotal = (product.unit_price * product.quantity) - 
                                   (product.unit_price * product.quantity * product.discount / 100);
            invoiceLine.subtotal += invoiceLine.subtotal * product.tax.value / 100;
            invoiceLine.subtotal =  parseFloat(invoiceLine.subtotal.toFixed(2));
            var expired_date = "";
            if(product.expired_date !== "" && product.expired_date !== undefined)
                expired_date = product.expired_date.substring(8) 
                                + "/" + product.expired_date.substring(5,7) 
                                + "/" + product.expired_date.substring(0,4);

            invoiceLine.product = {
                 id           : product.product_id,
                 product_id   : product.product_id,
                 name         : product.name,
                 description  : product.description,
                 laboratory   : product.laboratory ? product.laboratory : "",
                 location     : product.location ? product.location : "",
                 expired_date : expired_date ? expired_date : "",
                 generic      : product.generic ? product.generic : ""
            };
            invoiceLine.tax = product.tax;
            invoiceLine.country_tax_id = product.tax.id;
            
            vm.InvoiceLine.push(invoiceLine);

            vm.resetInvoiceLine();

            vm.updateInvoice();

            vm.EnablePayment = true;
            vm.EnablePreInvoice = true;
        }

        vm.resetInvoiceLine = function(){
            vm.Product = [];
            vm.subtotal = 0;
            vm.productSelected = "";
        }

        vm.deleteInvoiceLine = function(invoiceLine){
            //var index = vm.Invoice.InvoiceLine.indexOf(invoiceLine);
            var index = vm.InvoiceLine.indexOf(invoiceLine);
            //vm.Invoice.InvoiceLine.splice(index, 1);
            vm.InvoiceLine.splice(index, 1);
            //if(!vm.Invoice.InvoiceLine.length > 0 ){
            if(!vm.InvoiceLine.length > 0 ){
                vm.EnablePayment = false;
                vm.EnablePreInvoice = false;
            }
            vm.updateInvoice();
        }

        vm.updateInvoiceLine = function(invoiceLine){
            if(invoiceLine.discount===undefined) invoiceLine.discount = 0;
            if(invoiceLine.quantity===undefined) invoiceLine.quantity = 0;
            if(invoiceLine.unit_price===undefined) invoiceLine.unit_price = 0;

            invoiceLine.subtotal = (invoiceLine.unit_price * invoiceLine.quantity) - (invoiceLine.unit_price * invoiceLine.quantity * invoiceLine.discount / 100);

            var tax = 0;
            //invoiceLine.subtotal += tax;
            if(invoiceLine.tax===undefined){
                var promise = ProductTaxService.readDefault(invoiceLine.product_id);
                promise.then(function(pl){
                    tax = invoiceLine.subtotal * pl.data.countrytax.value / 100;
                    invoiceLine.tax = pl.data.countrytax;
                    invoiceLine.country_tax_id = pl.data.countrytax.id;
                    vm.AddOrModifyInvoiceTax(invoiceLine.country_tax_id, invoiceLine.subtotal, tax);
                    vm.updateInvoice();
                });    
            }else{
                tax = invoiceLine.subtotal * invoiceLine.tax.value / 100;
                tax = parseFloat(tax.toFixed(2));
                vm.AddOrModifyInvoiceTax(invoiceLine.country_tax_id, invoiceLine.subtotal, tax);
                vm.updateInvoice();
            }
            // Permite leer los impuesto o retenciones por el Producto.
            

            //     vm.ProductTax = pl.data;
            //     var product_tax_a = 0; 
            //     var product_tax = 0;

                // if(vm.ProductTax.length>0){
                //     // Ciclo para calcular los Impuestos y Retenciones.
                //     angular.forEach(vm.ProductTax, function(producttax, key){
                //         product_tax = invoiceLine.subtotal * producttax.countrytax.value / 100;
                //         product_tax_a += product_tax;
                //         vm.AddOrModifyInvoiceTax(producttax.country_tax_id, invoiceLine.subtotal, product_tax);
                //     });
                // }
                //invoiceLine.subtotal += product_tax_a;
            
            //});
        }

        vm.updateInvoiceProduct = function(product){
            if(vm.Product.discount===undefined) vm.Product.discount = 0;
            if(vm.Product.quantity===undefined) vm.Product.quantity = 1;
            if(vm.Product.unit_price===undefined) vm.Product.unit_price = 0;
            vm.subtotal= (product.unit_price * product.quantity) - (product.unit_price * product.quantity * product.discount / 100);
            vm.subtotal= vm.subtotal.toFixed(2);
            // vm.tax = vm.subtotal * product.tax.value / 100;
            // vm.subtotal += vm.tax;

            // Permite leer los impuesto o retenciones por el Producto.
            // var promise = ProductTaxService.readFilter(vm.Product.product_id);
            // promise.then(function(pl){
            //     vm.ProductTax = pl.data;
            //     var product_tax_a = 0; 
            //     var product_tax = 0;
            //     if(vm.ProductTax.length>0){
            //         // Ciclo para calcular los Impuestos y Retenciones.
            //         angular.forEach(vm.ProductTax, function(producttax, key){
            //             product_tax = vm.subtotal * producttax.countrytax.value / 100;
            //             product_tax_a += product_tax;
            //             vm.AddOrModifyInvoiceTax(producttax.country_tax_id, vm.subtotal, product_tax);
            //         });
            //     }

            //     vm.subtotal += product_tax_a;
            // });
        }

        // Métodos para Invoice Payment.

        vm.selectPayment = function(idPayment){
            var promise = EntityMasterDataService.read(idPayment);
            promise.then(function(pl){
                vm.Payment.id = idPayment;
                vm.Payment.name = pl.data.name;
            });
        }

        vm.selectBank = function(idBank){
            var promise = EntityMasterDataService.read(idBank);
            promise.then(function(pl){
                vm.Bank.id = idBank;
                vm.Bank.name = pl.data.name;
            });
        }

        vm.selectTimeUnit = function(id){
            var promise = EntityMasterDataService.read(id);
            promise.then(function(pl){
                vm.TimeUnit.id = id;
                vm.TimeUnit.name = pl.data.name;
            });
        }

        vm.addInvoicePayment = function(payment){
            var invoicePayment = {};
            var mount_a = 0;

            //vm.Invoice.InvoicePayment = vm.Invoice.InvoicePayment || [];

            vm.InvoicePayment = vm.InvoicePayment || [];

            if(vm.paymentTypeSelected==="" || vm.paymentTypeSelected===undefined){
                SweetAlert.swal("Forma de Pago!", "Debe seleccionar una forma de pago válida!", "warning"); 
                return;
            }

            if(payment.mount<=0){
                SweetAlert.swal("Monto incorrecto!", "El monto de Pago no puede ser menor o igual a cero!", "warning"); 
                return;
            }

            if(isNaN(parseFloat(payment.mount))){
                SweetAlert.swal("Monto incorrecto!", "El Monto del pago acepta solo valores numéricos!", "warning"); 
                return;
            }


            // Verifica si monto acumulado de pago excede del monto total de la factura.

            mount_a = vm.mountInvoicePayment() + parseFloat(payment.mount);

            if(mount_a<=vm.totalInvoice)
            {
                invoicePayment.document_number = payment.document_number;
                invoicePayment.mount = payment.mount;
                invoicePayment.time_limit = payment.time_limit;
                invoicePayment.unit_time_id = payment.unit_time_id || null;
                // invoicePayment.payment_type_id = payment.payment_type_id;
                // invoicePayment.bank_id = payment.bank_id;
                invoicePayment.bank = {
                    "id": vm.Bank.id || null,
                    "name": vm.Bank.name || null
                };
                invoicePayment.paymentType = {
                    "id": vm.Payment.id,
                    "name": vm.Payment.name
                };
                invoicePayment.timeUnit = {
                    "id": vm.TimeUnit.id,
                    "name": vm.TimeUnit.name
                }
            
                //vm.Invoice.InvoicePayment.push(invoicePayment);

                vm.InvoicePayment.push(invoicePayment);

                vm.resetInvoicePayment();

                vm.updateInvoicePayment();

            }else{
               
               SweetAlert.swal("Monto Excedido!", "El monto de Pago excede el Total de Factura!", "warning");      
            }

        }

        vm.ChancePaymentMount = function(invoicePayment){
            var mount_a = vm.mountInvoicePayment();
            var difference = vm.totalInvoice - mount_a;
            if(difference>0){
              vm.InvoicePaymentType.mount = difference;  
            }
        }

        vm.mountInvoicePayment = function(){
            var mount_a = 0;
            //angular.forEach(vm.Invoice.InvoicePayment, function(invoicePayment, key){
            angular.forEach(vm.InvoicePayment, function(invoicePayment, key){
                mount_a += parseFloat(invoicePayment.mount);
            });
            return mount_a;
        } 

        vm.updateInvoicePayment = function(){
            var mount_a = 0;
            //angular.forEach(vm.Invoice.InvoicePayment, function(invoicePayment, key){
            angular.forEach(vm.InvoicePayment, function(invoicePayment, key){
                mount_a += parseFloat(invoicePayment.mount);
            });
            vm.InvoicePaymentType.mount = vm.totalInvoice - mount_a;
            if(vm.InvoicePaymentType.mount===0 && vm.InvoicePayment.length>0) 
                vm.EnableButtons = true;
            else
                vm.EnableButtons = false;
        }

        vm.deleteInvoicePayment = function(invoicePayment){
            //var index = vm.Invoice.InvoicePayment.indexOf(invoicePayment);
            var index = vm.InvoicePayment.indexOf(invoicePayment);
            //vm.Invoice.InvoicePayment.splice(index, 1);
            vm.InvoicePayment.splice(index, 1);
            //if(!vm.Invoice.InvoicePayment.length > 0 ){
            if(!vm.InvoicePayment.length > 0 ){
                vm.EnableButtons = false;
            }else{
                vm.EnableButtons = true;
            }
            vm.updateInvoicePayment();
        }

        vm.resetInvoicePayment = function(){
            vm.InvoicePaymentType = [];
            vm.TimeUnitSelected = "";
            vm.bankSelected = "";
            vm.paymentTypeSelected="";
            vm.InvoicePaymentType.unit_time_id = "";
            vm.InvoicePaymentType.bank_id = "";
            vm.InvoicePaymentType.payment_type_id = "";
        }

        // Métodos para generar Proforma y Emitir Factura
        vm.createPreInvoice = function(){
            var invoice = vm.Invoice;
            vm.fillInvoice('P');
            vm.Invoice.invoiceline      = vm.InvoiceLine;                    
            vm.Invoice.invoicetax       = vm.InvoiceTax;
            vm.Invoice.invoicepayment   = vm.InvoicePayment;

            if(vm.ExportInvoicetoggleSelected) 
                vm.Invoice.export_invoice = 1;
            else
                vm.Invoice.export_invoice = 0;

            vm.EnablePreInvoice = false;
            
            var promise = InvoiceService.create(vm.Invoice)
                promise.then(function(pl){
                    toastr.success("Factura generada", "Se ha creado la Factura Proforma satisfactoriamente");
                    window.location = HOST_ROUTE.INVOICE + "/create";
                },
                promise.catch(function(reason) {
                        console.log(reason);
                })
            );
        }

        vm.updatePreInvoice = function(id, enviar = null){
            var invoice = vm.Invoice;
            vm.fillInvoice('P');
            vm.Invoice.invoiceline      = vm.InvoiceLine;                    
            vm.Invoice.invoicetax       = vm.InvoiceTax;
            vm.Invoice.invoicepayment   = vm.InvoicePayment;

            if(vm.ExportInvoicetoggleSelected) 
                vm.Invoice.export_invoice = 1;
            else
                vm.Invoice.export_invoice = 0;
            
            var promise = InvoiceService.update(vm.Invoice, id)
                promise.then(function(pl){
                    toastr.success("Factura actualizada", "Se ha modificado la Factura Proforma satisfactoriamente");
                    if(enviar){
                        vm.validateSRI(id, 1, 1);                         
                    }
                    else
                        window.location = HOST_ROUTE.PREINVOICE;
                },
                promise.catch(function(reason) {
                        console.log(reason);
                })
            );
        }

        vm.createInvoice = function(){
            var invoice = vm.Invoice;
            vm.fillInvoice('P');
            vm.Invoice.invoiceline      = vm.InvoiceLine;                    
            vm.Invoice.invoicetax       = vm.InvoiceTax;
            vm.Invoice.invoicepayment   = vm.InvoicePayment;

            if(vm.ExportInvoicetoggleSelected) 
                vm.Invoice.export_invoice = 1;
            else
                vm.Invoice.export_invoice = 0;

            vm.EnableButtons = false;
            
            var promise = InvoiceService.create(vm.Invoice);
                promise.then(function(pl){
                    toastr.success("Factura generada", "Se ha creado la Factura Proforma satisfactoriamente");                    
                    vm.validateSRI(pl.data, 1, 1);                    
                },
                promise.catch(function(reason) {
                        console.log(reason);
                })
            );
        }

        vm.fillInvoice = function(status){
            vm.Invoice.principal_code = vm.InvoiceNumber;
            vm.Invoice.invoicedate = vm.FechaHoy ;
            vm.Invoice.concept = ""; // Por definir que dato colocar aquí
            vm.Invoice.referral_code = ""; //Por Definir que dato colocar aquí
            vm.Invoice.total_discount = vm.totalDiscount; 
            vm.Invoice.total_ice = 0;
            vm.Invoice.total_iva = vm.total_iva_12;
            vm.Invoice.total_invoice = vm.totalInvoice;
            vm.Invoice.emission_type = vm.EmissionType; // Debe asocisarse a un valor en BD
            vm.Invoice.environment_type = vm.EnvironmentType; // Debe asocisarse a un valor en BD
            vm.Invoice.status = status;
            vm.Invoice.branch_office_id = vm.BranchOfficeId; // Debe asocisarse a un valor en BD
            vm.Invoice.company_id = vm.CompanyId; // Debe asociarse a un valor en BD
            vm.Invoice.client_id = vm.ClientId;
        }

        vm.createClient = function(){
            
            if(vm.toggleSelected==true)
                vm.client.is_active=1;
            else 
                vm.client.is_active=0;
            
            vm.client.company_id = vm.company.id;            

            var promise = ClientService.create(vm.client);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El cliente fue creado satisfactoriamente");  
                vm.readClientList(vm.CompanyId);  
                angular.element('#myModal').modal('hide');           
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear Cliente" + errorPl);
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
            
            vm.client.identification_type_id = identificationType.id;
        }

         vm.readCountryList = function(){
            var promise = EntityMasterDataService.readFilterByEntity(ENTITY.COUNTRY);
            promise.then(function(pl){
                vm.SourceCountryList = pl.data;
                vm.DestinationCountryList = pl.data;
                vm.SellerCountryList = pl.data;            
            });
         }

         vm.resetInvoice = function(){
            window.location.reload();
         }



        vm.readIdentificationTypeList();
}
})();
