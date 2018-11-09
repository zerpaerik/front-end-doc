(function () {
    "use strict";

    angular
        .module("QuantumApp")
        .service("ProductService", ProductService);

    ProductService.$inject = ['$http', 'SERVER_CONFIG', 'API_ROUTE', 'API_ACTION'];

    function ProductService($http, SERVER_CONFIG, API_ROUTE, API_ACTION) {

        var API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.PRODUCT;

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

        this.createMultiple = function (entity) 
        {      
            var param = {"products[]": entity};      
            var request = $http({
                method: "post",
                url: API_HOST + 'import',
                params: param,
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
                url: API_HOST + "/" + id
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

        this.readAllDt = function (IdCompany) 
        {
            var request = $http({
                method: "get",
                url: API_HOST + 'Dt' + '/' + IdCompany
            });
            return request;
        };

        this.readAllFilter = function (IdCompany) 
        {
            var request = $http({
                method: "get",
                url: API_HOST + 'Filter' + '/' + IdCompany
            });
            return request;
        };

        this.update = function (entity, id) 
        {
            var request = $http.put(API_HOST + "/" + id, entity);
            return request;
        }

        this.delete = function (id) 
        {
            var request = $http({
                method: "delete",
                url: API_HOST + "/" + id
            });
            return request;
        }

        
    }
})();