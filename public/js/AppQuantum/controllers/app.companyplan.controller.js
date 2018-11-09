(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('CompanyPlanController', CompanyPlanController);

    CompanyPlanController.$inject = ['$scope', '$http', '$location', 'CompanyPlanService', 'PlanService', 'CompanyService', '$rootScope', 'toastr', 'SweetAlert', 'HOST_ROUTE'];

    function CompanyPlanController($scope, $http, $location, CompanyPlanService, PlanService, CompanyService, $rootScope, toastr, SweetAlert, HOST_ROUTE) {
        
        var vm = this;

        vm.companyplanList = [];
        vm.companyplan = [];
        vm.CompanyList = [];
        vm.PlanList = [];
        vm.activetoggleSelected = true;

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

        vm.create = function(){
            vm.validarDatos();

            vm.companyplan.company_id = vm.company.id;
            vm.companyplan.plan_id = vm.plan.id;

            vm.setToggleSelected();

            var promise = CompanyPlanService.create(vm.companyplan);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El Plan de la Compañía fué creada satisfactoriamente");
                window.location = HOST_ROUTE.COMPANYPLAN;
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear Plan de Compañía" + errorPl);
            };
        }

        vm.update = function(){
            vm.validarDatos();   

            vm.companyplan.company_id = vm.company.id;
            vm.companyplan.plan_id = vm.plan.id;         

            vm.setToggleSelected();
            
            var promise = CompanyPlanService.update(vm.companyplan, vm.companyplan.id);

            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El Plan de la Compañía fué actualizada satisfactoriamente");
                window.location = HOST_ROUTE.COMPANYPLAN;
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
                var promise = CompanyPlanService.delete(id);
                promise.then(function(pl){
                    toastr.success("El registro fue eliminado satisfactoriamente");
                    window.location = HOST_ROUTE.COMPANYPLAN;    
                });
              }
            }); 
        }      

        vm.edit = function(id){
            var promise = CompanyPlanService.read(id);
            promise.then(function(pl){
                vm.loadList();
                vm.companyplan = pl.data;
                vm.company = vm.companyplan.company;
                vm.plan = vm.companyplan.plan;
                vm.companyplan.start_date = new Date(vm.companyplan.start_date.substring(0,4), 
                                                     parseInt(vm.companyplan.start_date.substring(5,7))-1,
                                                     vm.companyplan.start_date.substring(8));
                vm.companyplan.end_date = new Date(vm.companyplan.end_date.substring(0,4),
                                                   parseInt(vm.companyplan.end_date.substring(5,7))-1,
                                                   vm.companyplan.end_date.substring(8));
            });
        }

        vm.readAll = function(){
            var promise = CompanyPlanService.readAll();
            promise.then(function(pl){
                vm.companyplanList = pl.data;
            }); 
        }

        vm.selectPlan = function(plan){
            vm.plan.document_count = plan.document_count;
        }

        vm.setToggleSelected = function(){
            // 
            if(vm.activetoggleSelected==true)
                vm.companyplan.is_active=1;
            else 
                vm.companyplan.is_active=0;
        }

        vm.readToggleSelected = function(){
            // 
            if(vm.companyplan.is_active==1) 
                vm.activetoggleSelected=true;
            else 
                vm.activetoggleSelected=false;
        }

        vm.validarDatos = function(){
            // Rango de Fechas
            if(vm.companyplan.start_date > vm.companyplan.end_date){
                SweetAlert.swal("Rango de Fechas Incorrecto!", "La Fecha de Inicio debe ser menor a la Fecha Final!", "warning"); 
                return;
            }
            // Contador de Documento
            // if(vm.companyplan.document_count<=0){
            //     SweetAlert.swal("Contador Maximo de Documentos Incorrecto!", "El Contador de Documento no puede ser menor o igual a cero!", "warning"); 
            //     return;
            // }

            // if(isNaN(parseInt(vm.companyplan.document_count))){
            //     SweetAlert.swal("Contador Máximo de Documentos Incorrecto!", "El Contador de Documento acepta solo valores numéricos!", "warning"); 
            //     return;
            // }
            // Contador Actual
            if(vm.companyplan.current_counter<0){
                SweetAlert.swal("Contador Actual Incorrecto!", "El Contador Actual no puede ser menor o igual a cero!", "warning"); 
                return;
            }

            if(isNaN(parseInt(vm.companyplan.current_counter))){
                SweetAlert.swal("Contador Actual Incorrecto!", "El Contador Actual acepta solo valores numéricos!", "warning"); 
                return;
            }
        }

        vm.loadList = function(){
            vm.readCompanyList();
            vm.readPlanList();
        }

        vm.readCompanyList = function(){
            var promise = CompanyService.readAll();
            promise.then(function(pl){
                vm.CompanyList = pl.data;
            });    
        }

        vm.readPlanList = function(){
            var promise = PlanService.readAll();
            promise.then(function(pl){
                vm.PlanList = pl.data;
            });    
        }

        vm.popup1 = {
            opened: false
        }

        vm.open1 = function() {
            vm.popup1.opened = true;
        };

        vm.popup2 = {
            opened: false
        }

        vm.open2 = function() {
            vm.popup2.opened = true;
        };
    }
})();