(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('PermissionController', PermissionController);

    PermissionController.$inject = ['$scope', '$http', '$location','PermissionService', 'EntityMasterDataService', '$rootScope', 'toastr', 'HOST_ROUTE', 'SweetAlert', 'ENTITY'];

    function PermissionController($scope, $http, $location, PermissionService, EntityMasterDataService, $rootScope, toastr, HOST_ROUTE, SweetAlert, ENTITY) {
        
        var vm = this;

        vm.PermissionList   = [];
        vm.RoleList         = [];
        vm.ModuleList       = [];            
        vm.permission       = [];
        vm.checked          = false;
        vm.permissionMatriz = [];   


        vm.create = function(){
            if(vm.toggleSelected == true)
                vm.permission.is_active = 1;
            else 
                vm.permission.is_active = 0;
                                   
            var perm = [];
            angular.forEach(vm.permissionMatriz, function(module, moduleKey){
                angular.forEach(module, function(permission, permissionKey){                    
                    var aux = {
                        "permission_id"        : vm.PermissionList[permissionKey].id,
                        "module_id" : vm.ModuleList[moduleKey].id 
                    };

                    perm.push(aux);                    
                });
            });

            vm.permission.selected = perm;

            var promise = PermissionService.create(vm.permission);

            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("La permisología fue creada satisfactoriamente");
                window.location = HOST_ROUTE.PERMISSION;
            }),            
            function (errorPl) {
                toastr.error("Ocurrió un error al crear la permisología: " + errorPl);
            };
        }

        vm.update = function(Id){
            if(vm.toggleSelected == true)
                vm.permission.is_active = 1;
            else 
                vm.permission.is_active = 0;
                                   
            var perm = [];
            angular.forEach(vm.permissionMatriz, function(module, moduleKey){
                angular.forEach(module, function(permission, permissionKey){
                    if(permission){
                        var aux = {
                            "permission_id"        : vm.PermissionList[permissionKey].id,
                            "module_id" : vm.ModuleList[moduleKey].id 
                        };

                        perm.push(aux);
                    }
                });
            });

            vm.permission.selected = perm;
            
            var promise = PermissionService.update(vm.permission, Id);
            
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("La permisología fue actualizada satisfactoriamente");
                window.location = HOST_ROUTE.PERMISSION;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al actualizar la permisología: " + errorPl);
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
                var promise = PermissionService.delete(id);
                promise.then(function(pl){
                    toastr.success("El registro fue eliminado satisfactoriamente");
                    window.location = HOST_ROUTE.PERMISSION;    
                });
              }
            }); 

        }   

        vm.edit = function(id){
            var promise = PermissionService.read(id);
            promise.then(function(pl){
                var aux = pl.data;
                if(aux.role.is_active === 1) 
                    vm.toggleSelected = true;
                else
                    vm.toggleSelected = false;

                var modPromise = EntityMasterDataService.readFilterByEntity(ENTITY.MODULE);
                modPromise.then(function(plm){
                    vm.ModuleList = plm.data;

                    var permPromise = EntityMasterDataService.readFilterByEntity(ENTITY.PERMISSION);
                    permPromise.then(function(plp){
                        vm.PermissionList = plp.data;                        

                        vm.permissionMatriz = new Array(vm.ModuleList.length);
                        for (var i = 0; i < vm.ModuleList.length; i++) {
                          vm.permissionMatriz[i] = new Array(vm.PermissionList.length);
                        }

                        angular.forEach(vm.ModuleList, function(module, moduleKey){
                            angular.forEach(vm.PermissionList, function(permission, permissionKey){                                
                                vm.permissionMatriz[moduleKey][permissionKey] = false;
                            });
                        });

                        vm.permission.role_name     = aux.role.name;
                        vm.permission.description   = aux.role.description;

                        angular.forEach(aux.permissions, function(auxPerm, auxPermKey){
                            angular.forEach(vm.ModuleList, function(module, moduleKey){
                                angular.forEach(vm.PermissionList, function(permission, permissionKey){
                                    if(auxPerm.module_id === module.id){
                                        if(auxPerm.permission_id === permission.id){                                            
                                            vm.permissionMatriz[moduleKey][permissionKey] = true;             
                                        }
                                    }                            
                                });
                            });
                        });
                    });
                });                                                             
            });
        }

        vm.readAll = function(){
            var promise = PermissionService.readAll();
            promise.then(function(pl){
                vm.PermissionList = pl.data;
            }); 
        }

        vm.readRoles = function(){
            var promise = EntityMasterDataService.readFilterByEntity(ENTITY.ROLE);
            promise.then(function(pl){
                vm.RoleList = pl.data;
            });
        }

        vm.readModules = function(){
            var promise = EntityMasterDataService.readFilterByEntity(ENTITY.MODULE);
            promise.then(function(pl){
                vm.ModuleList = pl.data;
            });
        }

        vm.readPermissions = function(){
            var promise = EntityMasterDataService.readFilterByEntity(ENTITY.PERMISSION);
            promise.then(function(pl){
                vm.PermissionList = pl.data;
            });
        }

        vm.readData = function(){
            vm.readRoles();
            vm.readModules();
            vm.readPermissions();
        }
    }
})();