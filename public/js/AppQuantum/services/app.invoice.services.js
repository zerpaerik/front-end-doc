(function () {
    "use strict";

    angular
        .module("QuantumApp")
        .service("InvoiceService", InvoiceService);

    InvoiceService.$inject = ['$http', 'SERVER_CONFIG', 'API_ROUTE', 'API_ACTION'];

    function InvoiceService($http, SERVER_CONFIG, API_ROUTE, API_ACTION) {

        var API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.INVOICE;
        var API_HOST_PREINVOICE = SERVER_CONFIG.API_HOST + API_ROUTE.PREINVOICE;

        this.create = function (entity) 
        {            
            var param = {
                    "principal_code"    : entity.principal_code,
                    "invoicedate"       : entity.invoicedate ,
                    "concept"           : entity.concept, // Por definir que dato colocar aquí
                    "referral_code"     : entity.referral_code, //Por Definir que dato colocar aquí
                    "total_discount"    : entity.total_discount, 
                    "total_ice"         : entity.total_ice,
                    "total_iva"         : entity.total_iva,
                    "total_invoice"     : entity.total_invoice,
                    "emission_type"     : entity.emission_type, // Debe asocisarse a un valor en BD
                    "environment_type"  : entity.environment_type, // Debe asocisarse a un valor en BD
                    "status"            : entity.status,
                    "branch_office_id"  : entity.branch_office_id, // Debe asocisarse a un valor en BD
                    "company_id"        : entity.company_id, // Debe asociarse a un valor en BD
                    "client_id"         : entity.client_id,
                    // Datos de Exportación
                    "export_invoice"    : entity.export_invoice,
                    "inco_term"         : entity.inco_term,
                    "place_inco_term"   : entity.place_inco_term,
                    "source_country"    : entity.source_country,
                    "destination_country" : entity.destination_country,
                    "seller_country"    : entity.seller_country,
                    "source_harvour"    : entity.source_harvour,
                    "destination_harvour" : entity.destination_harvour,
                    "inco_term_total_no_tax": entity.inco_term_total_no_tax,
                    "international_cargo" : entity.international_cargo,
                    "international_secure": entity.international_secure,
                    "custom_expenditures" : entity.custom_expenditures,
                    "transport_expenditures": entity.transport_expenditures,
                    // 
                    "invoicePayment[]"  : entity.invoicepayment,
                    "invoiceTax[]"      : entity.invoicetax,
                    "invoiceLine[]"     : entity.invoiceline
                };
                                          
            var request = $http({
                method: "post",
                url: API_HOST,
                params: param,
                headers: {    
                    "Access-Control-Allow-Origin": true,                
                    "Content-Type": "application/x-www-form-urlencoded"
                }                
            });
            return request;
        };

        this.addCorrelative = function (id) 
        {            
            var request = $http({
                method: "get",
                url: SERVER_CONFIG.API_HOST + API_ROUTE.PREINVOICE + "/addCorrelative/" + id
            });
            return request;
        };

        this.sendSRI = function (urlSRI, id) 
        {            
            var request = $http({
                method: "get",
                url: urlSRI + id
            });
            return request;
        };

        this.createPreInvoice = function (entity) 
        {            
            var request = $http({
                method: "post",
                url: API_HOST,
                params: entity,
                headers: {    
                    "Access-Control-Allow-Origin": true,                
                    "Content-Type": "application/x-www-form-urlencoded"
                }
            });
            return request;
        };

        this.read = function (id) 
        {
            var request = $http({
                method: "get",
                url: API_HOST + "/" + id,
                headers: {    
                    "Access-Control-Allow-Origin": true,                
                    "Content-Type": "application/x-www-form-urlencoded"
                }           
            });
            return request;
        };

        this.readPreinvoice = function (id) 
        {
            var request = $http({
                method: "get",
                url: API_HOST_PREINVOICE + "/edit/" + id,
                headers: {    
                    "Access-Control-Allow-Origin": true,                
                    "Content-Type": "application/x-www-form-urlencoded"
                }           
            });
            return request;
        };

        

        this.readAll = function () 
        {
            var request = $http({
                method: "get",
                url: API_HOST + API_ACTION.READALL
            });
            return request;
        };

        this.readInvoiceCreditNote = function (id) 
        {
            var request = $http({
                method: "get",
                url: API_HOST + "/creditnote/" + id,
                headers: {    
                    "Access-Control-Allow-Origin": true,                
                    "Content-Type": "application/x-www-form-urlencoded"
                }           
            });
            return request;
        };

        this.readInvoiceByClient = function(IdCompany, IdClient) 
        {
            var request = $http({
                url: API_HOST + "/client/" + IdCompany + "/" + IdClient,
                headers: {    
                    "Access-Control-Allow-Origin": true,                
                    "Content-Type": "application/x-www-form-urlencoded"
                }        
            });
            return request;
        };

        this.readInvoicesByCompany = function(id)
        {
             var request = $http({
                method: "get",
                url: API_HOST + '/processed/' + id,
                headers: {    
                    "Access-Control-Allow-Origin": true,                
                    "Content-Type": "application/x-www-form-urlencoded"
                } 
            });
            return request; 
        };


        this.update = function (entity, id) 
        {
            var param = {
                    "principal_code"    : entity.principal_code,
                    "invoicedate"       : entity.invoicedate ,
                    "concept"           : entity.concept, // Por definir que dato colocar aquí
                    "referral_code"     : entity.referral_code, //Por Definir que dato colocar aquí
                    "total_discount"    : entity.total_discount, 
                    "total_ice"         : entity.total_ice,
                    "total_iva"         : entity.total_iva,
                    "total_invoice"     : entity.total_invoice,
                    "emission_type"     : entity.emission_type, // Debe asocisarse a un valor en BD
                    "environment_type"  : entity.environment_type, // Debe asocisarse a un valor en BD
                    "status"            : entity.status,
                    "branch_office_id"  : entity.branch_office_id, // Debe asocisarse a un valor en BD
                    "company_id"        : entity.company_id, // Debe asociarse a un valor en BD
                    "client_id"         : entity.client_id,
                    // Datos de Exportación
                    "export_invoice"    : entity.export_invoice,
                    "inco_term"         : entity.inco_term,
                    "place_inco_term"   : entity.place_inco_term,
                    "source_country"    : entity.source_country,
                    "destination_country" : entity.destination_country,
                    "seller_country"    : entity.seller_country,
                    "source_harvour"    : entity.source_harvour,
                    "destination_harvour" : entity.destination_harvour,
                    "inco_term_total_no_tax": entity.inco_term_total_no_tax,
                    "international_cargo" : entity.international_cargo,
                    "international_secure": entity.international_secure,
                    "custom_expenditures" : entity.custom_expenditures,
                    "transport_expenditures": entity.transport_expenditures,
                    //
                    "invoicePayment[]"  : entity.invoicepayment,
                    "invoiceTax[]"      : entity.invoicetax,
                    "invoiceLine[]"     : entity.invoiceline
                };
            var request = $http.put(API_HOST + "/" + id, param);
            return request;
        }

        this.delete = function (id) 
        {
            var request = $http({
                method: "delete",
                url: API_HOST_PREINVOICE + API_ACTION.DELETE + "/" + id,
                headers: {    
                    "Access-Control-Allow-Origin": true,                
                    "Content-Type": "application/x-www-form-urlencoded"
                }   
            });
            return request;
        }

        
    }
})();