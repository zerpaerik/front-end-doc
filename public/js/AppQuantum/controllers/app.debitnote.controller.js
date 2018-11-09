(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('DebitNoteController', DebitNoteController);

    DebitNoteController.$inject = ['$scope', '$http', 'CountryTaxService', 'DebitNoteService', 'InvoiceService', 
    'EntityMasterDataService', 'ENTITY', 'DEFAULT_COUNTRY', 'NOTA_DEBITO_DEFAULT_TAX_CODE', 'TAX', 'DOCUMENT_TYPE', '$rootScope', 'toastr', 
    'HOST_ROUTE', 'SRI_SERVICE', 'SweetAlert'];

    function DebitNoteController($scope, $http, CountryTaxService, DebitNoteService, InvoiceService, 
        EntityMasterDataService, ENTITY, DEFAULT_COUNTRY, NOTA_DEBITO_DEFAULT_TAX_CODE, TAX, DOCUMENT_TYPE, $rootScope, toastr, 
        HOST_ROUTE, SRI_SERVICE, SweetAlert) {
        
        var vm = this;

        vm.localLang = {           
            reset           : "Deshacer",
            search          : "Buscar Factura",
            nothingSelected : "Seleccione una Factura"
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

        vm.FechaHoy        = new Date();
        vm.CompanyId       = 0; // Colocar valor desde la BD
        vm.BranchOfficeId  = 0; // Colocar valor desde la BD
        vm.EmissionType    = 0; // Debe asocisarse a un valor en BD
        vm.EnvironmentType = 0;  // Debe asocisarse a un valor en BD
        vm.toggleSelected  = true;
        vm.PaymentTypeList = [];
        vm.paymentTypeSelected="";
        vm.TaxDocumentDetail = {
            reason: "",
            value: "",
            tax: {}
        };
        vm.Payment = {
            "id": "",
            "code": "",
            "name": "",
            "description": "",
            "field": "",
            "is_active": "",
            "entity_id": "",
            "is_deleted": ""
        };
        vm.EnableTaxButton     = false;
        vm.InvoiceList         = [];
        vm.InvoiceListTemp     = [];
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
            is_processed    : 0,
            taxDocumentLine : []
        };
        vm.TaxDocumentLine     = [];
        vm.TaxList             = [];
        // Variables para totales
        vm.subtotal = 0;   
        vm.totalTaxDocument = 0;
        vm.totalDebitNote         = 0;
        vm.total_iva_12           = 0;
        vm.totalDebitNoteNoTax    = 0;
        vm.subtotal_iva_14        = 0;
        vm.subtotal_iva_12        = 0;
        vm.subtotal_iva_0         = 0;
        vm.subtotal_iva_exento    = 0;
        vm.subtotal_iva_no_objeto = 0;

        vm.setBranch = function(branch){
            vm.BranchOfficeId = branch;
        }

        vm.validateSRI = function(id, redirect = null){
            SweetAlert.swal({
                  title: 'Enviar Nota de Debito al SRI',
                  text: "¿Está seguro que desea enviar la Nota de Débito al SRI?",
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
                  var promise = DebitNoteService.sendSRI(SRI_SERVICE.URL_DEBITNOTE, id);
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
                           window.location = HOST_ROUTE.DEBITNOTE + "/create"; 
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

        vm.readAll = function(idCompany){
            var promise = DebitNoteService.readAll(idCompany);
            promise.then(function(pl){
                vm.TaxDocumentList = pl.data;
            }); 
        }

        vm.readCountryTax = function(){
            var promise = CountryTaxService.readDebitNote(DEFAULT_COUNTRY.EC, ENTITY.TAX, ENTITY.TAX_PERCENTAGE);
            promise.then(function(pl){
                vm.TaxList = pl.data;
            });
        }

        vm.readInvoicesList = function(idCompany){
            var promise = InvoiceService.readInvoicesByCompany(idCompany);
            promise.then(function(pl){
                vm.InvoiceList = pl.data;
            }); 
        }

        vm.readPaymentTypeList = function(IdEntity){
           var promise = EntityMasterDataService.readFilterByEntity(IdEntity);
           promise.then(function (pl) {
              vm.PaymentTypeList = pl.data;
           });
        }

        vm.loadCombos = function(IdCompany, IdBranch){
           vm.CompanyId = IdCompany;
           vm.BranchOfficeId = IdBranch;
           vm.readCountryTax();
           vm.readPaymentTypeList(ENTITY.PAYMENT_TYPE);
           //vm.readRetentionList();
           vm.readInvoicesList(IdCompany);
           //vm.readTaxRetentionList();
        }

        vm.selectInvoice = function (data) {
             var datos = data.originalObject;
             vm.InvoiceId = datos.id;
             vm.Invoice = datos;
             vm.EnableTaxButton = true;

             vm.TaxDocument.taxDocumentLine = [];

             // angular.forEach(vm.Invoice.invoice_line, function(line, key){
             //    var taxdocumentline = {};

             //    taxdocumentline.tax_document_id = 0;
             //    taxdocumentline.referral_document_type = DOCUMENT_TYPE.FACTURA;
             //    taxdocumentline.referral_document = vm.Invoice.referral_code;
             //    taxdocumentline.doc_emission_date = vm.Invoice.invoice_date;
             //    taxdocumentline.tax_type_code = REMISSION_DEFAULT_TAX_CODE.TAX_CODE;
             //    taxdocumentline.tax_base_amount = 0;
             //    taxdocumentline.tax_percentage = 0;
             //    taxdocumentline.tax_total_amount = 0;
             //    taxdocumentline.product_id = line.product_id;
             //    taxdocumentline.quantity = line.quantity;

             //    vm.TaxDocument.taxDocumentLine.push(taxdocumentline);

             // });
        };

        vm.selectPayment = function(idPayment){
            var promise = EntityMasterDataService.read(idPayment);
            promise.then(function(pl){
                vm.Payment.id = idPayment;
                vm.Payment.name = pl.data.name;
            });
        }

        vm.updateTaxDocument = function(){
            vm.totalDebitNote         = 0;
            vm.total_iva_12           = 0;
            vm.totalDebitNoteNoTax    = 0;
            vm.subtotal_iva_14        = 0;
            vm.subtotal_iva_12        = 0;
            vm.subtotal_iva_0         = 0;
            vm.subtotal_iva_exento    = 0;
            vm.subtotal_iva_no_objeto = 0;

            angular.forEach(vm.TaxDocumentLine, function(taxDocumentLine, key){

                vm.totalDebitNoteNoTax  +=  parseFloat(taxDocumentLine.tax_base_amount);

                var taxValue = taxDocumentLine.tax_base_amount * taxDocumentLine.tax_percentage / 100;

                if(taxDocumentLine.tax.id==TAX.IVA_12){
                    vm.subtotal_iva_12 += parseFloat(taxDocumentLine.tax_base_amount);
                    vm.total_iva_12 += parseFloat(taxValue.toFixed(2));
                }else if(taxDocumentLine.tax.id==TAX.IVA_0){
                    vm.subtotal_iva_0 += parseFloat(taxDocumentLine.tax_base_amount);
                }else if(taxDocumentLine.tax.id==TAX.IVA_14){
                    vm.subtotal_iva_14 += parseFloat(taxDocumentLine.tax_base_amount);
                }else if(taxDocumentLine.tax.id==TAX.IVA_NO_OBJETO){
                    vm.subtotal_iva_no_objeto += parseFloat(taxDocumentLine.tax_base_amount);
                }else if(taxDocumentLine.tax.id==TAX.IVA_EXENTO){
                    vm.subtotal_iva_exento += parseFloat(taxDocumentLine.tax_base_amount);
                }
                
                taxDocumentLine.tax_total_amount = parseFloat(taxDocumentLine.tax_total_amount.toFixed(2));

                vm.totalDebitNote  +=  parseFloat(taxDocumentLine.tax_total_amount);
                vm.totalDebitNote  = parseFloat(vm.totalDebitNote.toFixed(2));
                //vm.DebitNotePaymentType.mount = vm.totalDebitNote;
            });
        }

        vm.addTaxDocumentLine = function(taxDocument){
            var taxDocumentLine = {};
            vm.TaxDocumentLine = vm.TaxDocumentLine || [];

            if(vm.TaxDocumentDetail.reason===""||vm.TaxDocumentDetail.reason===undefined){
                SweetAlert.swal("Nota de Débito!", "Debe ingresar Razón de la Modificación!", "warning"); 
                return;
            }

            if(isNaN(parseFloat(vm.TaxDocumentDetail.amount))){
                SweetAlert.swal("Nota de Débito!", "El monto debe ser numérico!", "warning"); 
                return;
            }

            if(vm.TaxDocumentDetail.amount<=0){
                SweetAlert.swal("Nota de Débito!", "El monto debe ser mayor a cero!", "warning"); 
                return;
            }

            if(vm.TaxDocumentDetail.tax===""||vm.TaxDocumentDetail.tax===undefined){
                SweetAlert.swal("Nota de Débito!", "Debe seleccionar un Impuesto!", "warning"); 
                return;
            }

            taxDocumentLine.tax_document_id = 0;
            taxDocumentLine.referral_document_type = DOCUMENT_TYPE.NOTA_DEBITO;
            taxDocumentLine.referral_document      = vm.Invoice.referral_code;
            taxDocumentLine.doc_emission_date      = vm.Invoice.invoice_date;
            taxDocumentLine.tax_type_code          = NOTA_DEBITO_DEFAULT_TAX_CODE.TAX_CODE;
            taxDocumentLine.tax                    = taxDocument.tax;
            taxDocumentLine.tax_base_amount        = taxDocument.amount;
            taxDocumentLine.tax_percentage         = taxDocument.tax.value;
            taxDocumentLine.tax_total_amount       = parseFloat(taxDocument.amount) * (1+(parseFloat(taxDocument.tax.value)/100));
            taxDocumentLine.reason                 = taxDocument.reason;

            vm.TaxDocumentLine.push(taxDocumentLine);

            vm.resetTaxDocumentLine();

            vm.updateTaxDocument();

            vm.EnableTaxButton = true;            
        }

        vm.resetTaxDocumentLine = function(){
            vm.TaxDocumentDetail.reason="";
            vm.TaxDocumentDetail.amount=0;
        }

        vm.deleteTaxDocumentLine = function(taxDocumentLine){
            var index = vm.TaxDocumentLine.indexOf(taxDocumentLine);
            vm.TaxDocumentLine.splice(index, 1);
            if(!vm.TaxDocumentLine.length > 0 ){
                vm.EnableTaxButton = false;
            }
            vm.updateTaxDocument();
        }

        vm.updateTaxDocumentLine = function(taxDocumentLine){  

            if(taxDocumentLine.tax_base_amount  === undefined) taxDocumentLine.tax_base_amount  = 0;
            if(taxDocumentLine.tax_percentage   === undefined) taxDocumentLine.tax_percentage   = 0;
            if(taxDocumentLine.tax_total_amount === undefined) taxDocumentLine.tax_total_amount = 0;

            taxDocumentLine.tax_total_amount = taxDocumentLine.tax_base_amount * (1+(parseFloat(taxDocumentLine.tax_percentage)/100));
            
            taxDocumentLine.tax_total_amount = parseFloat(taxDocumentLine.tax_total_amount.toFixed(2));

            vm.updateTaxDocument();
        }

        // Metodos de Forma de Pago
        vm.addDebitNotePayment = function(payment){
            var debitNotePayment = {};
            var mount_a = 0;

            vm.DebitNotePayment = vm.DebitNotePayment || [];

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

            mount_a = vm.mountDebitNotePayment() + parseFloat(payment.mount);

            if(mount_a<=vm.totalDebitNote)
            {
                debitNotePayment.mount = payment.mount;
                debitNotePayment.paymentType = {
                    "id": vm.Payment.id,
                    "name": vm.Payment.name
                };
            
                vm.DebitNotePayment.push(debitNotePayment);

                vm.resetDebitNotePayment();

                vm.updateDebitNotePayment();

            }else{
               
               SweetAlert.swal("Monto Excedido!", "El monto de Pago excede el Total de Nota de Débito!", "warning");      
            }

        }

        
        vm.ChancePaymentMount = function(invoicePayment){
            var mount_a = vm.mountDebitNotePayment();
            var difference = vm.totalDebitNote - mount_a;
            if(difference>0){
              vm.DebitNotePaymentType.mount = difference;  
            }
        }

        vm.mountDebitNotePayment = function(){
            var mount_a = 0;
            //angular.forEach(vm.Invoice.InvoicePayment, function(invoicePayment, key){
            angular.forEach(vm.DebitNotePayment, function(payment, key){
                mount_a += parseFloat(payment.mount);
            });
            return mount_a;
        } 

        vm.updateDebitNotePayment = function(){
            var mount_a = 0;
            //angular.forEach(vm.Invoice.InvoicePayment, function(invoicePayment, key){
            angular.forEach(vm.DebitNotePayment, function(payment, key){
                mount_a += parseFloat(payment.mount);
            });
            vm.DebitNotePaymentType.mount = vm.totalDebitNote - mount_a;
            if(vm.DebitNotePaymentType.mount===0 && vm.DebitNotePayment.length>0) 
                vm.EnableButtons = true;
            else
                vm.EnableButtons = false;
        }

        vm.deleteDebitNotePayment = function(payment){
            //var index = vm.Invoice.InvoicePayment.indexOf(invoicePayment);
            var index = vm.DebitNotePayment.indexOf(payment);
            //vm.Invoice.InvoicePayment.splice(index, 1);
            vm.DebitNotePayment.splice(index, 1);
            //if(!vm.Invoice.InvoicePayment.length > 0 ){
            if(!vm.DebitNotePayment.length > 0 ){
                vm.EnableButtons = false;
            }else{
                vm.EnableButtons = true;
            }
            vm.updateDebitNotePayment();
        }

        vm.resetDebitNotePayment = function(){
            vm.DebitNotePaymentType = [];
            vm.paymentTypeSelected="";
            vm.DebitNotePaymentType.payment_type_id = "";
        }

        // Métodos para generar Proforma y Emitir Factura
        vm.createDebitNote = function(){
            vm.TaxDocument.taxDocumentLine  = vm.TaxDocumentLine; 
            vm.TaxDocument.branch_office_id = vm.BranchOfficeId; 
            vm.TaxDocument.amount           = vm.totalDebitNote;
            vm.TaxDocument.debitNotePayment = vm.DebitNotePayment;
            vm.TaxDocument.invoice_id       = vm.InvoiceId;              
            
            var promise = DebitNoteService.create(vm.TaxDocument)
                promise.then(function(pl){
                    toastr.success("Nota de débito generada", "Se ha creado la Nota de Débito satisfactoriamente");
                    //vm.validateSRI(pl.data, true);
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
            vm.TaxDocument.is_processed     = 1;
        }

        vm.resetDebitNote = function(){
            window.location.reload();
        }

    }
})();