(function () {
    "use strict";

    angular
        .module("QuantumApp")
        .service("CountryTaxService", CountryTaxService);

    CountryTaxService.$inject = ['$http', 'SERVER_CONFIG', 'API_ROUTE', 'API_ACTION'];

    function CountryTaxService($http, SERVER_CONFIG, API_ROUTE, API_ACTION) {

        var API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.COUNTRYTAX;

        this.create = function (entity) 
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

        this.read = function (Id) 
        {
            var request = $http({
                method: "get",
                url: API_HOST+'/'+Id
            });
            return request;
        };

        this.readFilter = function (Id, TaxId) 
        {
            var request = $http({
                method: "get",
                url: API_HOST+'Lista/'+Id+'/'+TaxId
            });
            return request;
        };

        this.readDebitNote = function (Id, TaxId, TaxPercentageId) 
        {
            var request = $http({
                method: "get",
                url: API_HOST+'DebitNote/'+Id+'/'+TaxId+'/'+TaxPercentageId
            });
            return request;
        };

        this.readRetention = function (Id, IdRetention) 
        {
            var request = $http({
                method: "get",
                url: API_HOST+'ListaRetention/'+Id+'/'+IdRetention
            });
            return request;
        };

        this.readPercentage = function (Id, IdTax) 
        {
            var request = $http({
                method: "get",
                url: API_HOST+'ListaPercentage/'+Id+'/'+IdTax
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

        this.update = function (entity, Id) 
        {
            var params = { company: entity};
            var request = $http.put(API_HOST+'/'+Id, entity);
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