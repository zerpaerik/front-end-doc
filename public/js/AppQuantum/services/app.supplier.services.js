(function () {
    "use strict";

    angular
        .module("QuantumApp")
        .service("SupplierService", SupplierService);

    SupplierService.$inject = ['$http', 'SERVER_CONFIG', 'API_ROUTE', 'API_ACTION'];

    function SupplierService($http, SERVER_CONFIG, API_ROUTE, API_ACTION) {

        var API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.SUPPLIER;

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

        this.search = function(supplierData){
            let param = {data : supplierData};
            let AUX_ROUTE = API_HOST + '/search';
            var request = $http({
                method: 'post',
                url: AUX_ROUTE,
                params : param,
                headers: {    
                    "Access-Control-Allow-Origin": true,                
                    "Content-Type": "application/x-www-form-urlencoded"
                }
            });
        };

        this.read = function (Id) 
        {
            var request = $http({
                method: "get",
                url: API_HOST + '/' + Id + API_ACTION.READ
            });
            return request;
        };

        this.readFilter = function (IdCompany) 
        {            
            var request = $http({
                method: "get",
                url: API_HOST+'Filter/'+IdCompany
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
            var request = $http.put(API_HOST + '/' + Id, entity);
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