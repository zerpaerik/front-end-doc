(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('PlanController', PlanController);

    PlanController.$inject = ['$scope', '$http', '$location','PlanService', '$rootScope', 'toastr', 'HOST_ROUTE', 'SweetAlert'];

    function PlanController($scope, $http, $location, PlanService, $rootScope, toastr, HOST_ROUTE, SweetAlert) {
        
        var vm = this;

        vm.PlanList = [];
        vm.CompanyList = [];
        vm.plan = [];
        vm.checked = false;

        vm.create = function(){
            if(vm.toggleSelected==true)
                vm.plan.is_active=1;
            else 
                vm.plan.is_active=0;
            var promise = PlanService.create(vm.plan);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El plan fué creada satisfactoriamente");
                window.location = HOST_ROUTE.PLAN;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear plan" + errorPl);
            };
        }

        vm.update = function(){
            if(vm.toggleSelected==true)
                vm.plan.is_active=1;
            else 
                vm.plan.is_active=0;
            var promise = PlanService.update(vm.plan, vm.plan.id);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El plan fué actualizada satisfactoriamente");
                window.location = HOST_ROUTE.PLAN;
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
                var promise = PlanService.delete(id);
                promise.then(function(pl){
                    toastr.success("El registro fue eliminado satisfactoriamente");
                    window.location = HOST_ROUTE.PLAN;    
                });
              }
            }); 

        }   

        vm.edit = function(id){
            var promise = PlanService.read(id);
            promise.then(function(pl){
                vm.plan = pl.data;
                if(vm.plan.is_active===1) 
                    vm.toggleSelected = true;
                else
                    vm.toggleSelected = false;
            });
        }

        vm.readAll = function(){
            var promise = PlanService.readAll();
            promise.then(function(pl){
                vm.PlanList = pl.data;
            }); 
        }
    }
})();