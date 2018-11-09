(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('UserController', UserController);

    UserController.$inject = ['$scope', 'SERVER_CONFIG', '$http', 'UserService', 'CompanyService', 'BranchService', 
    'EntityMasterDataService', 'ENTITY', 'toastr', '$rootScope', 'HOST_ROUTE', 'SweetAlert'];

    function UserController($scope, SERVER_CONFIG, $http, UserService, CompanyService, BranchService, 
        EntityMasterDataService, ENTITY, toastr, $rootScope, HOST_ROUTE, SweetAlert) {
        
        var vm = this;

        vm.APIHOST      = SERVER_CONFIG.API_HOST;
        vm.UserList     = [];
        vm.CompanyList  = [];
        vm.BranchList   = [];
        vm.RoleList     = [];
        vm.role = [];        
    
        vm.create = function(){
            if(vm.toggleSelected == true)
                vm.user.is_active = 1;
            else 
                vm.user.is_active = 0;

            if(vm.company.id.id !== undefined)
                vm.user.company_id = vm.company.id.id;
            else
                vm.user.company_id = vm.company.id;
            
            vm.user.branch_office_id = vm.branch.id.id;
            vm.user.role = vm.role.id.id;
            var promise = UserService.create(vm.user);
            promise.then(function(pl){
                var retorno = pl.data;                
                toastr.success("El usuario fue creado satisfactoriamente");
                window.location = HOST_ROUTE.USER;                
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear el usuario" + errorPl);
            };
        }

        vm.update = function(){
            if(vm.toggleSelected == true)
                vm.user.is_active = 1;
            else 
                vm.user.is_active = 0;

            vm.user.company.digital_certificate = null;
            vm.user.company.logo = null;
            vm.user.company_id  = vm.user.company.id;
            vm.user.branch_id   = vm.user.branch.id;
            vm.user.role = vm.role.id;

            var promise = UserService.update(vm.user, vm.user.id);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El usuario fue actualizado satisfactoriamente");
                window.location = HOST_ROUTE.USER;                
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al editar el usuario" + errorPl);
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
                var promise = UserService.delete(id);
                promise.then(function(pl){
                    toastr.success("El registro fue eliminado satisfactoriamente");
                    window.location = HOST_ROUTE.USER;    
                });
              }
            }); 

        }     

        vm.edit = function(id, roleUser, roleToCheck){
            var promise = UserService.read(id);
            promise.then(function(pl){
                vm.user = pl.data.user;                
                
                var promiseRol = EntityMasterDataService.readFilterByEntity(ENTITY.ROLE);
                
                promiseRol.then(function(plR){
                    vm.RoleList = plR.data;
                    if(roleUser != roleToCheck){
                    for (var i = 0; i < vm.RoleList.length; i++) {
                        if(parseInt(vm.RoleList[i].code) === roleToCheck){
                            vm.RoleList.splice(i, 1);
                            var aux = 1;
                        }
                    }
                }
                    vm.role = pl.data.currentRole;
                }); 
                
                vm.readCompanyList(roleUser, vm.user.company_id);
                vm.fillBranch(vm.user.company_id);   
                 
                if(vm.user.is_active == 1)
                    vm.toggleSelected = true;
                else 
                    vm.toggleSelected = false;            
            });
        }

        vm.readAll = function(id){
            var promise = UserService.readAll(id);
            promise.then(function(pl){
                vm.UserList = pl.data;
            }); 
        }

        vm.loadCompanies = function(userRoleId, CompanyId){
            vm.readCompanyList(userRoleId, CompanyId);            
        }

        vm.loadRole = function(roleUser, roleToCheck){
            vm.readRoleList(roleUser, roleToCheck);            
        }

        vm.loadBranches = function(Id){            
            vm.readBranchList(Id);
        }

        vm.fillBranch = function(CompanyId){                              
            vm.readBranchList(CompanyId);
        }

        vm.readCompanyList = function(UserRoleId, CompanyId){
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
                            vm.company = company;
                            vm.fillBranch(CompanyId);
                        }
                   });
                }
            });    
        }

        vm.readBranchList = function(id){            
            var promise = BranchService.readAll(id);
            promise.then(function(pl){                
                vm.BranchList = pl.data;
            });    
        }

        vm.readRoleList = function(roleUser, roleToCheck){
            var promise = EntityMasterDataService.readFilterByEntity(ENTITY.ROLE);
            promise.then(function(pl){
                vm.RoleList = pl.data;
                if(roleUser != roleToCheck){
                    for (var i = 0; i < vm.RoleList.length; i++) {
                        if(parseInt(vm.RoleList[i].code) === roleToCheck){
                            vm.RoleList.splice(i, 1);
                            var aux = 1;
                        }
                    }
                }
            });    
        }

    }
})();