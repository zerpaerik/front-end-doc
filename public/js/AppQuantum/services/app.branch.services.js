(function () {
    "use strict";

    angular
        .module("QuantumApp")
        .service("BranchService", BranchService);

    BranchService.$inject = ['$http', 'SERVER_CONFIG', 'API_ROUTE', 'API_ACTION'];

    function BranchService($http, SERVER_CONFIG, API_ROUTE, API_ACTION) {

        var API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.BRANCH;

        this.create = function (entity, Id) 
        {
            var request = $http({
                method: "post",
                url: API_HOST + "/" + Id,
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
                url: API_HOST + "/" + Id + "/edit"
            });            

            return request;
        };

        this.readAll = function (Id) 
        {
            var request = $http({
                method: "get",
                url: API_HOST + "/all/" + Id                
            });
            return request;
        };

        this.update = function (entity, Id) 
        {            
            //var request = $http.put(API_HOST + "/" + Id, params);
            var request = $http({
                method: "put",
                url: API_HOST + "/" + Id,  
                params: entity
            }); 
            return request;
        }

        this.delete = function (Id) 
        {
            var request = $http({
                method: "delete",
                url: API_HOST + "/" + Id
            });
            return request;
        }

        
    }
})();