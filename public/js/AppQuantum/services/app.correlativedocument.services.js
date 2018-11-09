(function () {
    "use strict";

    angular
        .module("QuantumApp")
        .service("CorrelativeDocumentService", CorrelativeDocumentService);

    CorrelativeDocumentService.$inject = ['$http', 'SERVER_CONFIG', 'API_ROUTE', 'API_ACTION'];

    function CorrelativeDocumentService($http, SERVER_CONFIG, API_ROUTE, API_ACTION) {

        var API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.CORRELATIVE_DOCUMENT;

        this.create = function (entity) 
        {
            var param = {"correlativo[]": entity};
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

        this.readFilter = function(IdCompany)
        {
            var request = $http({
                method: "get",
                url: API_HOST + 'bycompany/' + IdCompany
            });
            return request;
        }

        this.update = function (entity, Id) 
        {
            var param = {"correlativo[]": entity};
            var request = $http.put(API_HOST+'/'+Id, param);
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