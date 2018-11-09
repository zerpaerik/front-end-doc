(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('SupplierController', SupplierController);

    SupplierController.$inject = ['$scope', '$http', 'SupplierService', 'CompanyService', 'EntityMasterDataService', 'ENTITY', '$rootScope', 'toastr', 'HOST_ROUTE', 'SweetAlert'];

    function SupplierController($scope, $http, SupplierService, CompanyService, EntityMasterDataService, ENTITY, $rootScope, toastr, HOST_ROUTE, SweetAlert) {
        
        var vm = this;

        vm.SupplierList  = [];
        vm.CompanyList = [];
        vm.company = {};
        vm.supplier = {};
        vm.toggleSelected = true; 
        vm.IdentificationTypeSelected = true; 
        vm.IdentificationTypeList = [];
        vm.MaxCharIdentification = 13;
        vm.MinCharIdentification = 1;
        vm.formats    = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd/MM/yyyy', 'shortDate'];
        vm.formatDate = vm.formats[2];

        vm.altInputFormats = ['d!/M!/yyyy'];

        vm.options = {
            format: "DD/MM/YYYY"
        }

        vm.dateOptions = {
            dateDisabled: disabled,
            formatYear: 'yy',
            maxDate: new Date(2020, 5, 22),
            minDate: new Date(2018, 1, 1),
            startingDay: 1
        };

        // Disable weekend selection
        function disabled(data) {
            var date = data.date,
              mode = data.mode;
            return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
        }

        vm.popup1 = {
            opened: false
        }

        vm.open1 = function() {
            vm.popup1.opened = true;
        };

        vm.create = function(redir = true){
            if(vm.toggleSelected == true)
                vm.supplier.is_active = 1;
            else 
                vm.supplier.is_active = 0;
            
            vm.supplier.company_id = vm.company.id;            

            var promise = SupplierService.create(vm.supplier);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El proveedor fue creado satisfactoriamente");
                if(redir)
                    window.location = HOST_ROUTE.SUPPLIER;
                else{
                    //$rootScope.$emit("refreshClientList");
                    angular.element('#myModal').modal('hide');
                }
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear el proveedor" + errorPl);
            };
        }

        vm.update = function(){
            if(vm.toggleSelected==true)
                vm.supplier.is_active=1;
            else 
                vm.supplier.is_active=0;
            var promise = SupplierService.update(vm.supplier, vm.supplier.id);

            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El proveedor fue actualizado satisfactoriamente");
                window.location = HOST_ROUTE.SUPPLIER;
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
           vm.supplier.identification_type_id = identificationType.id;
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
                var promise = SupplierService.delete(id);
                promise.then(function(pl){
                    toastr.success("El registro fue eliminado satisfactoriamente");
                    window.location = HOST_ROUTE.SUPPLIER;    
                });
              }
            }); 

        } 

        vm.edit = function(id, UserRoleId, CompanyId){
            var promise = SupplierService.read(id);
            promise.then(function(pl){
                vm.supplier = pl.data;
                if(vm.supplier.is_active === 1) 
                    vm.toggleSelected = true;
                else
                    vm.toggleSelected = false;
                vm.readIdentificationType(vm.supplier.identification_type_id);
                vm.readCompanyList(UserRoleId, CompanyId);
            });
        }

        vm.readAll = function(){
            var promise = SupplierService.readAll(IdClient);
            promise.then(function(pl){
                vm.ListSuppliers = pl.data;
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
                            vm.fillBranch(CompanyId);
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