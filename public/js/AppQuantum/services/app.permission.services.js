(function () {
    "use strict";

    angular
        .module("QuantumApp")
        .service("PermissionService", PermissionService);

    PermissionService.$inject = ['$http', 'SERVER_CONFIG', 'API_ROUTE', 'API_ACTION'];

    function PermissionService($http, SERVER_CONFIG, API_ROUTE, API_ACTION) {

        var API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.PERMISSION;

        this.create = function (entity) 
        {

            var param = {
                    "is_active"   : entity.is_active,
                    'description' : entity.description,
                    "role_name"   : entity.role_name ,                    
                    "selected[]"  : entity.selected                  
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

        this.read = function (Id) 
        {
            var request = $http({
                method: "get",
                url: API_HOST + '/' + Id + API_ACTION.READ
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
            var param = {
                    "is_active"   : entity.is_active,
                    'description' : entity.description,
                    "role_name"   : entity.role_name ,                    
                    "selected[]"  : entity.selected                  
                };

            var request = $http.put(API_HOST + '/' + Id, param);
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