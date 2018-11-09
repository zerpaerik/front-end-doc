(function () {
    "use strict";

    angular
        .module("QuantumApp")
        .service("RemissionService", RemissionService);

    RemissionService.$inject = ['$http', 'SERVER_CONFIG', 'API_ROUTE', 'API_ACTION'];

    function RemissionService($http, SERVER_CONFIG, API_ROUTE, API_ACTION) {

        var API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.REMISSION;

        this.create = function (entity) 
        {            
            var param = {
                    "principal_code"    : entity.principal_code,
                    "referral_code"     : entity.referral_code, //Por Definir que dato colocar aquí
                    "emission_date"     : entity.invoicedate ,
                    "concept"           : entity.concept, // Por definir que dato colocar aquí
                    "amount"            : entity.amount,   
                    "emission_type"     : entity.emission_type, // Debe asocisarse a un valor en BD
                    "environment_type"  : entity.environment_type, // Debe asocisarse a un valor en BD
                    "document_type_id"  : entity.document_type_id,
                    "branch_office_id"  : entity.branch_office_id, // Debe asocisarse a un valor en BD
                    "dispatcher_id"     : entity.dispatcher_id,
                    "car_register"      : entity.car_register,
                    "starting_point"    : entity.starting_point,
                    "startdate_transport" : entity.startdate_transport,
                    "enddate_transport" : entity.enddate_transport,
                    "destination_transport" : entity.destination_transport,
                    "reason_transport"  : entity.reason_transport,
                    "custom_document"   : entity.custom_document,
                    "destination_branch_code" : entity.destination_branch_code,
                    "route"             : entity.route,
                    "invoice_id"        : entity.invoice_id,
                    "is_processed"      : entity.is_processed,
                    "taxDocumentLine[]" : entity.taxDocumentLine
                };
                                          
            var request = $http({
                method: "post",
                url: API_HOST + '/post',
                params: param,
                headers: {    
                    "Access-Control-Allow-Origin": true,                
                    "Content-Type": "application/x-www-form-urlencoded"
                }                
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

        this.read = function (Id) 
        {
            var request = $http({
                method: "get",
                url: API_HOST+'/'+Id
            });
            return request;
        };

        this.readAll = function () 
        {
            var request = $http({
                method: "get",
                url: API_HOST 
            });
            return request;
        };

        this.update = function (entity, id) 
        {
            var param = {
                    "principal_code"    : entity.principal_code,
                    "referral_code"     : entity.referral_code, //Por Definir que dato colocar aquí
                    "emission_date"     : entity.invoicedate ,
                    "concept"           : entity.concept, // Por definir que dato colocar aquí
                    "amount"            : entity.amount,   
                    "emission_type"     : entity.emission_type, // Debe asocisarse a un valor en BD
                    "environment_type"  : entity.environment_type, // Debe asocisarse a un valor en BD
                    "document_type_id"  : entity.document_type_id,
                    "branch_office_id"  : entity.branch_office_id, // Debe asocisarse a un valor en BD
                    "dispatcher_id"     : entity.dispatcher_id,
                    "car_register"      : entity.car_register,
                    "starting_point"    : entity.starting_point,
                    "startdate_transport" : entity.startdate_transport,
                    "enddate_transport" : entity.enddate_transport,
                    "destination_transport" : entity.destination_transport,
                    "reason_transport"  : entity.reason_transport,
                    "recipient_identification" : entity.recipient_identification,
                    "social_reason"     : entity.social_reason,
                    "custom_document"   : entity.custom_document,
                    "route"             : entity.route,
                    "is_processed"      : entity.is_processed,
                    "taxDocumentLine[]" : entity.taxDocumentLine
                };
            var request = $http.put(API_HOST + "/" + id, param);
            return request;
        }

        this.delete = function (Id) 
        {
            var request = $http({
                method: "delete",
                url: API_HOST + '/' + Id
            });
            return request;
        }

        
    }
})();