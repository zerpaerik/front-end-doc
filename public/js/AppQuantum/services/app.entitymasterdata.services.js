(function () {
    "use strict";

    angular
        .module("QuantumApp")
        .service("EntityMasterDataService", EntityMasterDataService);

    EntityMasterDataService.$inject = ['$http', 'SERVER_CONFIG', 'API_ROUTE', 'API_ACTION'];

    function EntityMasterDataService($http, SERVER_CONFIG, API_ROUTE, API_ACTION) {

        var API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.ENTITYMASTERDATA;

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

        this.createTax = function (entity) 
        {
            let AUX_ROUTE = SERVER_CONFIG.API_HOST + API_ROUTE.COUNTRYTAX;
            var request = $http({
                method: "post",
                url: AUX_ROUTE,
                params: entity,
                headers: {    
                    "Access-Control-Allow-Origin": true,                
                    "Content-Type": "application/x-www-form-urlencoded"
                }
            });
            return request;
        };

        this.createMasterdata = function (entity, Id) 
        {
            let AUX_ROUTE = API_HOST = SERVER_CONFIG.API_HOST + API_ROUTE.ENTITYMASTERDATA + API_ACTION.CREATE + "/" + Id;            
            
            var request = $http({
                method: "post",
                url: AUX_ROUTE,
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

        this.readFilterByEntity = function(IdEntity)
        {
            var request = $http({
                method: "get",
                url: API_HOST+'Entity/'+ IdEntity
            });
            return request;
        }

        this.readTax = function (Id) 
        {
            let AUX_ROUTE = SERVER_CONFIG.API_HOST + API_ROUTE.COUNTRYTAX + '/' + Id;
            
            var request = $http({
                method: "get",
                url: AUX_ROUTE 
            });
            return request;
        };

        this.readMasterdata = function (Id) 
        {
            let AUX_ROUTE = SERVER_CONFIG.API_HOST + API_ROUTE.ENTITYMASTERDATA + "/" + Id;
            
            var request = $http({
                method: "get",
                url: AUX_ROUTE
            });
            
            return request;
        };


        this.readMasterdataElement = function (Id) 
        {
            let AUX_ROUTE = SERVER_CONFIG.API_HOST + API_ROUTE.ENTITYMASTERDATA + "/edit/" + Id;
            
            var request = $http({
                method: "get",
                url: AUX_ROUTE
            });
            
            return request;
        };


        /*this.readFilter = function (entityId) 
        {
            var request = $http({
                method: "get",
                url: API_HOST+'/'+ entityId
            });
            return request;
        };*/

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
            var params = { plan: entity};
            var request = $http.put(API_HOST+'/'+Id, entity);
            return request;
        }

        this.updateTax = function (entity, Id) 
        {            
            let AUX_ROUTE = SERVER_CONFIG.API_HOST + API_ROUTE.COUNTRYTAX + API_ACTION.UPDATE + "/" + Id;
            var params = entity;
            var request = $http.put(AUX_ROUTE, entity);
            return request;
        }        

        this.updateMasterdata = function (entity) 
        {            
            let AUX_ROUTE = SERVER_CONFIG.API_HOST + API_ROUTE.ENTITYMASTERDATA + API_ACTION.UPDATE + "/" + entity.id;
            var params = entity;
            var request = $http.put(AUX_ROUTE, entity);
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