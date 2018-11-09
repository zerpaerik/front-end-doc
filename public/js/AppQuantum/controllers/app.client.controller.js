(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('ClientController', ClientController);

    ClientController.$inject = ['$scope', '$http', 'ClientService', 'CompanyService', 'EntityMasterDataService', 'ENTITY', '$rootScope', 'toastr', 'HOST_ROUTE', 'SweetAlert'];

    function ClientController($scope, $http, ClientService, CompanyService, EntityMasterDataService, ENTITY, $rootScope, toastr, HOST_ROUTE, SweetAlert) {
        
        var vm = this;

        vm.ClientList  = [];
        vm.CompanyList = [];
        vm.company = {};
        vm.client = {};
        vm.toggleSelected = true; 
        vm.IdentificationTypeSelected = true; 
        vm.IdentificationTypeList = [];
        vm.MaxCharIdentification = 13;
        vm.MinCharIdentification = 1;
        vm.UserRole = 1;

        // Variables de Importación de Datos
        vm.gridOptions = {};
        vm.gridOptions.data = [];
        vm.gridOptions.columnDefs = [];
        
        
        vm.resetImport = function() {
          vm.gridOptions.data = [];
          vm.gridOptions.columnDefs = [];
        }

        vm.saveImport = function(){
          var promise = ClientService.createMultiple(vm.gridOptions.data);
          promise.then(function(pl){
              toastr.success("La importación de Cliente ha sido exitosa");
              //window.location = HOST_ROUTE.PRODUCT;
          },function(error){
              toastr.error("Error en importación de Clientes");
          });
        }

        vm.create = function(redir = true){
            if(vm.toggleSelected==true)
                vm.client.is_active=1;
            else 
                vm.client.is_active=0;
            
            vm.client.company_id = vm.company.id;            

            var promise = ClientService.create(vm.client);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El cliente fué creado satisfactoriamente");
                if(redir)
                    window.location = HOST_ROUTE.CLIENT;
                else{
                    //$rootScope.$emit("refreshClientList");
                    angular.element('#myModal').modal('hide');
                }
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear Cliente" + errorPl);
            };
        }

        vm.update = function(){
            if(vm.toggleSelected==true)
                vm.client.is_active=1;
            else 
                vm.client.is_active=0;
            var promise = ClientService.update(vm.client, vm.client.id);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El cliente fué actualizado satisfactoriamente");
                window.location = HOST_ROUTE.CLIENT;
            });
        }  

        vm.selectIdentification = function(identificationType){
            // Cédula o Pasaporte
            if(identificationType.id == 18 || identificationType.id == 19){
              vm.MaxCharIdentification = 20;
              vm.MinCharIdentification = 1;
            }
            else{
              vm.MaxCharIdentification = 13;
              vm.MinCharIdentification = 13;
            }
            
            vm.client.identification_type_id = identificationType.id;
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
                var promise = ClientService.delete(id);
                promise.then(function(pl){
                    toastr.success("El registro fue eliminado satisfactoriamente");
                    window.location = HOST_ROUTE.CLIENT;    
                });
              }
            }); 

        } 

        vm.edit = function(id, UserRoleId, CompanyId){
            vm.UserRoleId = UserRoleId;
            var promise = ClientService.read(id);
            promise.then(function(pl){
                vm.client = pl.data;
                if(vm.client.is_active===1) 
                    vm.toggleSelected = true;
                else
                    vm.toggleSelected = false;
                vm.readIdentificationType(vm.client.identification_type_id);
                vm.readCompanyList(UserRoleId, CompanyId);
            });
        }

        vm.readAll = function(){
            var promise = ClientService.readAll(IdClient);
            promise.then(function(pl){
                vm.ListClients = pl.data;
            }); 
        }

        vm.readCompanyList = function(UserRoleId, CompanyId){
            vm.UserRoleId = UserRoleId;
            var promise = CompanyService.readAll();
            promise.then(function(pl){
                if(UserRoleId===1)// SuperAdministrador
                   vm.CompanyList = pl.data;
                else
                {
                   var datos = pl.data;
                   angular.forEach(datos, function(company, key){
                        if(company.id===CompanyId){
                            vm.CompanyList.push(company);
                        }
                   });
                }
            });    
        }

        vm.readIdentificationTypeList = function(){
            var promise = EntityMasterDataService.readFilterByEntity(ENTITY.IDENTIFICATION_TYPE);
            promise.then(function(pl){
                vm.IdentificationTypeList = pl.data;
            }); 
        }

        vm.readIdentificationType = function(id){
            var promise = EntityMasterDataService.read(id);
            promise.then(function(pl){
                vm.IdentificationTypeSelected = pl.data;
            }); 
        }



        vm.readIdentificationTypeList();
    }
})();