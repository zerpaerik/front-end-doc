(function () {
    "use strict";

    angular
        .module("QuantumApp")
        .service("ClientService", ClientService);

    ClientService.$inject = ['$http', 'SERVER_CONFIG', 'API_ROUTE', 'API_ACTION'];

    function ClientService($http, SERVER_CONFIG, API_ROUTE, API_ACTION) {

        var API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.CLIENT;

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
            var param = {"clients[]": entity};      
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

        this.search = function(clientData){
            let param = {data : clientData};
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
                url: API_HOST + '/' + Id +API_ACTION.READ
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

        this.readFilter = function (IdCompany) 
        {            
            var request = $http({
                method: "get",
                url: API_HOST + 'Company/' + IdCompany 
            });
            return request;
        };        

        this.update = function (entity, Id) 
        {
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