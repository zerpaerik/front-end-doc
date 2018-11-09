(function () {
    "use strict";

    angular
        .module("QuantumApp")
        .service("ProductTaxService", ProductTaxService);

    ProductTaxService.$inject = ['$http', 'SERVER_CONFIG', 'API_ROUTE', 'API_ACTION'];

    function ProductTaxService($http, SERVER_CONFIG, API_ROUTE, API_ACTION) {

        var API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.PRODUCT_TAX;

        this.create = function (entity) 
        {
            var param = { "producttax[]": entity };
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

        this.readFilter = function (IdProduct) 
        {
            var request = $http({
                method: "get",
                url: API_HOST + '/' + IdProduct
            });
            return request;
        };

        this.readDefault = function(IdProduct)
        {
           var request = $http({
                method: "get",
                url: API_HOST + 'Default/' + IdProduct
            });
            return request;  
        }

        this.update = function (entity, Id) 
        {
            var param = { "producttax[]": entity };
            var request = $http.put(API_HOST+'/'+ Id, param);
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