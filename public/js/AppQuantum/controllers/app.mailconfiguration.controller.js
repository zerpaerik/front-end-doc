(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('MailConfigurationController', MailConfigurationController);

    MailConfigurationController.$inject = ['$scope', '$http', '$location','MailConfigurationService', 'EntityMasterDataService', 'ENTITY', '$rootScope', 'toastr', 'HOST_ROUTE', 'SweetAlert'];

    function MailConfigurationController($scope, $http, $location, MailConfigurationService, EntityMasterDataService, ENTITY, $rootScope, toastr, HOST_ROUTE, SweetAlert) {
        
        var vm = this;

        vm.MailConfigurationList = [];
        vm.MailConfiguration = [];
        vm.MailServerTypeList = [];
        vm.MailSecurityTypeList = [];
        vm.MailIdentificationTypeList = [];
        vm.toggleSelected = true;

        vm.init = function(idCompany){
            vm.MailConfiguration.company_id = idCompany;    
            vm.readLists();
        }

        vm.create = function(){
            vm.MailConfiguration.server_type_id         = vm.MailConfiguration.mailservertype.id;
            vm.MailConfiguration.security_type_id       = vm.MailConfiguration.securitytype.id;
            vm.MailConfiguration.identification_type_id = vm.MailConfiguration.identificationtype.id;

            if(vm.toggleSelected==true)
                vm.MailConfiguration.is_active=1;
            else 
                vm.MailConfiguration.is_active=0;

            var promise = MailConfigurationService.create(vm.MailConfiguration);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("La Configuración fué creada satisfactoriamente");
                window.location = HOST_ROUTE.MAILCONFIGURATION;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear configuración" + errorPl);
            };
        }

        vm.update = function(){
            var promise = MailConfigurationService.update(vm.MailConfiguration, vm.MailConfiguration.id);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("La Configuración fué actualizada satisfactoriamente");
                window.location = HOST_ROUTE.MAILCONFIGURATION;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al actualizar configuración" + errorPl);
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
                var promise = MailConfigurationService.delete(id);
                promise.then(function(pl){
                    toastr.success("El registro fue eliminado satisfactoriamente");
                    window.location = HOST_ROUTE.MAILCONFIGURATION;    
                });
              }
            }); 
        }      

        vm.edit = function(id){
            var promise = MailConfigurationService.read(id);
            promise.then(function(pl){
                vm.MailConfiguration = pl.data;
                if(vm.MailConfiguration.is_active===1) 
                    vm.toggleSelected = true;
                else
                    vm.toggleSelected = false;
                vm.readLists();
            });
        }

        vm.readLists = function(){
            //
            vm.readMailServerTypeList(ENTITY.MAIL_SERVER_TYPE);
            vm.readMailSecurityTypeList(ENTITY.MAIL_SECURITY_TYPE);
            vm.readMailIdentificationTypeList(ENTITY.MAIL_IDENTIFICATION_TYPE);
        }

        vm.readMailServerTypeList = function(EntityId){
            var promise = EntityMasterDataService.readFilterByEntity(EntityId);
            promise.then(function(pl){
                vm.MailServerTypeList = pl.data;
            });
        }

        vm.readMailSecurityTypeList = function(EntityId){
            var promise = EntityMasterDataService.readFilterByEntity(EntityId);
            promise.then(function(pl){
                vm.MailSecurityTypeList = pl.data;
            });
        }

        vm.readMailIdentificationTypeList = function(EntityId){
            var promise = EntityMasterDataService.readFilterByEntity(EntityId);
            promise.then(function(pl){
                vm.MailIdentificationTypeList = pl.data;
            });
        }

        vm.read = function(id, entity){
            var promise = MailConfigurationService.read(id);
            promise.then(function(pl){
                vm.MailConfiguration = pl.data;                
            }); 
        }

        vm.readAll = function(){
            var promise = MailConfigurationService.readAll();
            promise.then(function(pl){
                vm.MailConfigurationList = pl.data;
            }); 
        }
    }
})();