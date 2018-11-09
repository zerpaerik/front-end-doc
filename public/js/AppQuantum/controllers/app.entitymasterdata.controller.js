(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('EntityMasterDataController', EntityMasterDataController);

    EntityMasterDataController.$inject = ['$scope', '$http', '$location', 'EntityMasterDataService', 'EntityService', '$rootScope', 'toastr', 'HOST_ROUTE', 'ENTITY', 'SweetAlert'];

    function EntityMasterDataController($scope, $http, $location, EntityMasterDataService, EntityService, $rootScope, toastr, HOST_ROUTE, ENTITY, SweetAlert) {
        
        var vm = this;

        vm.entitymasterdataList = [];
        vm.entitymasterdata = [];
        vm.EntityList = []; 
        vm.checked = false;
        vm.activetoggleSelected = true;

        vm.create = function(){

            if(vm.activetoggleSelected==true)
                vm.entitymasterdata.is_active=1;
            else 
                vm.entitymasterdata.is_active=0;

            vm.entitymasterdata.entity_id = vm.entitymasterdata.entity.id;

            var promise = EntityMasterDataService.create(vm.entitymasterdata);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El registro fué creado satisfactoriamente");
                window.location = HOST_ROUTE.ENTITYMASTERDATA + "/create";
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear registro" + errorPl);
            };
        }

        vm.createTax = function(){
            vm.tax.country_id = vm.country.id;
            var promise = EntityMasterDataService.createTax(vm.tax);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El registro fue creado satisfactoriamente");
                //window.location = HOST_ROUTE.PLAN;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear registro" + errorPl);
            };
        }

        vm.createModule = function(){
            var promise = EntityMasterDataService.createMasterdata(vm.module, ENTITY.MODULE);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El registro fue creado satisfactoriamente");
                window.location = HOST_ROUTE.MODULE;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear registro" + errorPl);
            };
        }

        vm.createRole = function(){
            var promise = EntityMasterDataService.createMasterdata(vm.role, ENTITY.ROLE);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El registro fue creado satisfactoriamente");
                window.location = HOST_ROUTE.ROLE;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear registro" + errorPl);
            };
        }

        vm.update = function(){

            if(vm.activetoggleSelected==true)
                vm.entitymasterdata.is_active=1;
            else 
                vm.entitymasterdata.is_active=0;

            vm.entitymasterdata.entity_id = vm.entitymasterdata.entity.id;
            
            var promise = EntityMasterDataService.update(vm.entitymasterdata, vm.entitymasterdata.id);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El registro fué actualizada satisfactoriamente");
                window.location = HOST_ROUTE.ENTITYMASTERDATA;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al actualizar registro" + errorPl);
            };
        }    

        vm.updateTax = function(){
            vm.tax.code         = vm.tax.tax.code;
            vm.tax.name         = vm.tax.tax.name;
            vm.tax.description  = vm.tax.tax.description;
            vm.tax.is_active    = vm.tax.tax.is_active;
            var promise = EntityMasterDataService.updateTax(vm.tax, vm.tax.id);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El registro fue actualizado satisfactoriamente");
                
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al actualizar registro" + errorPl);
            };
        }     

        vm.updateModule = function(){
            var promise = EntityMasterDataService.updateMasterdata(vm.entity);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El registro fue actualizado satisfactoriamente");
                window.location = HOST_ROUTE.MODULE;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al actualizar registro" + errorPl);
            };
        }  

        vm.updateRole = function(){
            var promise = EntityMasterDataService.updateMasterdata(vm.entity);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El registro fue actualizado satisfactoriamente");
                window.location = HOST_ROUTE.ROLE;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al actualizar registro" + errorPl);
            };
        }      

        vm.delete = function(id){

            SweetAlert.swal({
                  title: 'Eliminar registro',
                  text: "¿Está seguro que desea eliminar el registro?",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si',
                  cancelButtonText: 'No',
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false
                }, function (dismiss) {
                  if (dismiss === true) {
                    var promise = EntityMasterDataService.delete(id);
                    promise.then(function(pl){
                        toastr.success("El registro fue eliminado satisfactoriamente");
                        window.location = HOST_ROUTE.ENTITYMASTERDATA;    
                    });
                  }
                });

        }      

        vm.edit = function(id){
            var promise = EntityMasterDataService.read(id);
            promise.then(function(pl){
                vm.entitymasterdata = pl.data;
                vm.readEntityList();
            });
        }

        vm.editTax = function(id){
            var promise = EntityMasterDataService.readTax(id);
            promise.then(function(pl){
                vm.tax = pl.data;                
            });
        }

        vm.editMasterdata = function(id){
            var promise = EntityMasterDataService.readMasterdataElement(id);
            promise.then(function(pl){
                vm.entity = pl.data;                
            });
        }

        vm.readAll = function(){
            var promise = EntityMasterDataService.readAll();
            promise.then(function(pl){
                vm.entitymasterdataList = pl.data;
            }); 
        }

        vm.readEntityList = function(){
            var promise = EntityService.readAll();
            promise.then(function(pl){
                vm.EntityList = pl.data;
            });    
        }
    }
})();