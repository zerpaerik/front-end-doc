(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('CountryTaxController', CountryTaxController);

    CountryTaxController.$inject = ['$scope', '$http', '$location', 'CountryTaxService', 'EntityMasterDataService', '$rootScope', 'toastr', 'HOST_ROUTE', 'ENTITY'];

    function CountryTaxController($scope, $http, $location, CountryTaxService, EntityMasterDataService, $rootScope, toastr, HOST_ROUTE, ENTITY) {
        
        var vm = this;

        vm.countrytax = [];
        vm.TaxPercentageList = [];
        vm.TaxList = [];
        vm.CountryList = [];
        vm.toggleSelected = true;

        vm.options = {
            format: "DD/MM/YYYY"
        }

        vm.create = function(){
            //vm.setToggleSelected();

            var promise = CountryTaxService.create(vm.countrytax);

            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El Plan de la Compañía fué creada satisfactoriamente");
                window.location = HOST_ROUTE.COUNTRYTAX;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear plan" + errorPl);
            };
        }

        vm.update = function(){
            var promise = CountryTaxService.update(vm.companyplan, vm.companyplan.id);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El Plan de la Compañía fué actualizada satisfactoriamente");
                window.location = HOST_ROUTE.COUNTRYTAX;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al actualizar plan" + errorPl);
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
                var promise = CompanyService.delete(id);
                promise.then(function(pl){
                    toastr.success("El registro fue eliminado satisfactoriamente");
                    window.location = HOST_ROUTE.COUNTRYTAX;    
                });
              }
            }); 

        }    

        vm.edit = function(id){
            var promise = CountryTaxService.read(id);
            promise.then(function(pl){
                vm.countrytax = pl.data;
                vm.country = pl.data.country;
                vm.tax = pl.data.tax;
                vm.taxpercentage = pl.data.taxpercentage;
                vm.loadList();
            });
        }

        vm.readAll = function(){
            var promise = CompanyPlanService.readAll();
            promise.then(function(pl){
                vm.companyplanList = pl.data;
            }); 
        }

        vm.setToggleSelected = function(){
            // 
            if(vm.toggleSelected==true)
                vm.countrytax.is_active=1;
            else 
                vm.countrytax.is_active=0;
        }

        vm.readToggleSelected = function(){
            // 
            if(vm.countrytax.is_active==1) 
                vm.toggleSelected=true;
            else 
                vm.toggleSelected=false;
        }

        vm.readCountryList = function(){
            var promise = EntityMasterDataService.readFilterByEntity(ENTITY.COUNTRY);
            promise.then(function(pl){
                vm.CountryList = pl.data;
            });    
        }

        vm.readTaxList = function(){
            var promise = EntityMasterDataService.readFilterByEntity(ENTITY.TAX);
            promise.then(function(pl){
                vm.TaxList = pl.data;
            });    
        }

        vm.readTaxPercentageList = function(){
            var promise = EntityMasterDataService.readFilterByEntity(ENTITY.TAX_PERCENTAGE);
            promise.then(function(pl){
                vm.TaxPercentageList = pl.data;
            });    
        }

        vm.loadList = function(){
            vm.readCountryList();
            vm.readTaxList();
            vm.readTaxPercentageList();
        }

        vm.selectCountry = function(country){
            vm.countrytax.country_id = country.id;
        }

        vm.selectTax = function(tax){
            vm.countrytax.tax_id = tax.id;
        }

        vm.selectTaxPercentage = function(tax){
            vm.countrytax.tax_percentage_id = tax.id;
        }

    }
})();