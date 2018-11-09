(function () {
    "use strict";

    angular
        .module("QuantumApp")
        .service("CompanyService", CompanyService);

    CompanyService.$inject = ['$http', '$timeout', 'SERVER_CONFIG', 'API_ROUTE', 'API_ACTION'];

    function CompanyService($http, $timeout, SERVER_CONFIG, API_ROUTE, API_ACTION) {

        var API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.COMPANY;

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

        this.readCertificate = function (Id) 
        {
            var request = $http({
                method: "get",
                url: API_HOST+'Certificate/'+Id
            });
            return request;
        };

        this.readLogo = function (Id) 
        {
            var request = $http({
                method: "get",
                url: API_HOST+'Logo/'+Id
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

        this.update = function (entity, Id, token) 
        {
            $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            var params = { company: entity};
            var request = $http.put(API_HOST+'/'+Id, entity);
            return request;
        }

        this.UpdateCertificate = function (id, certificate) {
            var params = {certificate: certificate};
            var request = $http.put(API_HOST+'Certificate/'+id, params);
            return request;
        };

        this.UpdateLogo = function (id, logo) {
            var params = {logo: logo};
            var request = $http.put(API_HOST+'Logo/'+id, params);
            return request;
        };

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