(function () {
    "use strict";

    angular
        .module("QuantumApp")
        .service("UserService", UserService);

    UserService.$inject = ['$http', 'SERVER_CONFIG', 'API_ROUTE', 'API_ACTION'];

    function UserService($http, SERVER_CONFIG, API_ROUTE, API_ACTION) {

        var API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.USER;

        this.create = function (entity) 
        {            
            var request = $http({
                method: "post",
                url: API_HOST,
                params: entity                
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
                url: API_HOST + API_ACTION.READALL                
            });
            return request;
        };

        this.update = function (entity, id) 
        {            
            //var request = $http.put(API_HOST + "/" + id, entity);
            var request = $http({
                method: "put",
                url: API_HOST + "/" + id,
                params: entity
            });

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