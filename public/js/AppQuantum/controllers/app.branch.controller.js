(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('BranchController', BranchController);

    BranchController.$inject = ['$scope', '$http', 'BranchService', 'CompanyService', 'EntityMasterDataService', '$rootScope', 'toastr', 'HOST_ROUTE', 'SweetAlert', 'ENTITY'];

    function BranchController($scope, $http, BranchService, CompanyService, EntityMasterDataService, $rootScope, toastr,  HOST_ROUTE, SweetAlert, ENTITY) {
        
        var vm = this;

        vm.BranchesList = [];
        vm.CompanyList = [];    
        vm.EmissionTypeList = "";
        vm.EnvironmentTypeList = "";
        vm.toggleSelected = true;  
        vm.emissionTypeSelected    = [];
        vm.environmentTypeSelected = [];  

        vm.create = function(id){
            if(vm.toggleSelected==true)
                vm.branch.is_active=1;
            else 
                vm.branch.is_active=0;

            // vm.branch.environment_type = 1;
            // vm.branch.emission_type = 1;

            vm.branch.company_id = vm.company.id;

            var promise = BranchService.create(vm.branch, id);

            promise.then(function(pl){
                var retorno = pl.data;                
                toastr.success("La sucursal fué creada satisfactoriamente");
                //window.location = HOST_ROUTE.BRANCH + 'Dt/' + id;
                window.location = HOST_ROUTE.BRANCH;// + '/' + id;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear la sucursal" + errorPl);
            };
        }

        vm.update = function(){
            if(vm.toggleSelected==true)
                vm.branch.is_active=1;
            else 
                vm.branch.is_active=0;
            var promise = BranchService.update(vm.branch, vm.branch.id);
            promise.then(function(pl){
                var retorno = pl.data;                
                toastr.success("La sucursal fue actualizada satisfactoriamente");
                //.location = "http://localhost:8000/listBranches/"+ id;
                window.location = HOST_ROUTE.BRANCH;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al editar la sucursal" + errorPl);
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
                var promise = BranchService.delete(id);
                promise.then(function(pl){
                    toastr.success("El registro fue eliminado satisfactoriamente");
                    window.location = HOST_ROUTE.BRANCH;    
                });
              }
            }); 

        } 

        // vm.delete = function(id){            
        //     var promise = BranchService.delete(id);
        //     promise.then(function(pl){
        //         var retorno = pl.data;
        //         toastr.success("La sucursal fue eliminada satisfactoriamente");
        //         window.location = "http://localhost:8000/listBranches/"+vm.branch.company_id;
        //     }),
        //     function (errorPl) {
        //         toastr.error("Ocurrió un error al eliminar la sucursal" + errorPl);
        //     };
        // }      

        vm.edit = function(id, UserRoleId, CompanyId){
            var promise = BranchService.read(id);
            promise.then(function(pl){
                vm.branch = pl.data;
                vm.company = vm.branch.company;
                
                if(vm.branch.is_active===1) 
                    vm.toggleSelected = true;
                else
                    vm.toggleSelected = false;

                vm.loadList(UserRoleId, CompanyId);
                vm.emissionTypeSelected    = vm.branch.emission_type;
                vm.environmentTypeSelected = vm.branch.environment_type;
                //vm.readCompanyList();
            });
        }        

        vm.readAll = function(idCompany){
            var promise = BranchService.readAll(idCompany);
            promise.then(function(pl){
                vm.branchesList = pl.data;
            }); 
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
                        }
                   });
                }
            });    
        }

        vm.readCompany = function(){
            var promise = CompanyService.read();
            promise.then(function(pl){
                vm.Company = pl.data;
            });       
        }

        vm.selectEmissionType = function(emission){
           vm.branch.emission_type = emission; 
        }

        vm.selectEnvironmentType = function(environment){
           vm.branch.environment_type = environment;
        }

        vm.readEnvironmentTypeList = function(){
           var promise = EntityMasterDataService.readFilterByEntity(ENTITY.ENVIRONMENT_TYPE);
           promise.then(function (pl) {
              vm.EnvironmentTypeList = pl.data;
              //vm.environmentTypeSelected = vm.environmentTypeSelected;
           });
        }

        vm.readEmissionTypeList = function(){
           var promise = EntityMasterDataService.readFilterByEntity(ENTITY.EMISSION_TYPE);
           promise.then(function (pl) {
              vm.EmissionTypeList = pl.data;
              //vm.emissionTypeSelected = vm.anch.emission_type;
           });
        }

        vm.loadList = function(UserRoleId, CompanyId){
            vm.readCompanyList(UserRoleId, CompanyId);
            vm.readCompany();
            vm.readEnvironmentTypeList();
            vm.readEmissionTypeList();
        }

    }
})();