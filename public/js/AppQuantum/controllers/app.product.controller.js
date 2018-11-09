(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('ProductController', ProductController);

    ProductController.$inject = ['$scope', 'SERVER_CONFIG', '$http', 'ProductService', 'CountryTaxService', 'ProductTaxService', 'toastr', '$rootScope', 'HOST_ROUTE', 'SweetAlert', 'ENTITY'];

    function ProductController($scope, SERVER_CONFIG, $http, ProductService, CountryTaxService, ProductTaxService, toastr, $rootScope, HOST_ROUTE, SweetAlert, ENTITY) {
        
        var vm = this;

        vm.APIHOST = SERVER_CONFIG.API_HOST;
        vm.ProductsList = [];
        vm.CompanyList = [];
        vm.ProductTax = {};
        vm.ProductTaxList = [];
        vm.CountryTaxList = [];
        vm.activetoggleSelected = true;
        vm.saletoggleSelected = true;
        vm.purchasetoggleSelected = true;
        vm.TipoPorcentaje = "";
        vm.Tasa = "";
        vm.enableButton = false;

        // Variables de Importación de Datos
        vm.gridOptions = {};
        vm.gridOptions.data = [];
        vm.gridOptions.columnDefs = [];
        
        
        vm.resetImport = function() {
          vm.gridOptions.data = [];
          vm.gridOptions.columnDefs = [];
        }

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

        vm.popup = {
            opened: false
        }

        vm.open = function() {
            vm.popup.opened = true;
        };

        // Disable weekend selection
        function disabled(data) {
            var date = data.date,
              mode = data.mode;
            return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
        }

        vm.saveImport = function(){
          var promise = ProductService.createMultiple(vm.gridOptions.data);
          promise.then(function(pl){
              toastr.success("La importación de Productos ha sido exitosa");
              //window.location = HOST_ROUTE.PRODUCT;
          },function(error){
              toastr.error("Error en importación de Productos");
          });
        }

        vm.create = function(Id){
            vm.setToggleSelected();
            vm.product.company_id = Id;

            if(vm.ProductTaxList.length === 0){
              SweetAlert.swal({
                    title: 'Error al registrar producto',
                    text: "Debe asociar un impuesto por defecto para el producto",
                    type: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar',                    
                    confirmButtonClass: 'btn btn-success',                    
                    buttonsStyling: false
              });
            }
            else{
              var promise = ProductService.create(vm.product);
              promise.then(function(pl){
                  var product = pl.data;                
                  toastr.success("El producto fue creado satisfactoriamente");
                  angular.forEach(vm.ProductTaxList, function(producttax, key){
                      producttax.product_id = product.id;
                  });

                  var promise_tax = ProductTaxService.create(vm.ProductTaxList);
                  promise_tax.then(function(data){
                      toastr.success("Los impuestos para el producto fueron creados satisfactoriamente");
                      window.location = HOST_ROUTE.PRODUCT;
                  });
                  
              }),
              function (errorPl) {
                  toastr.error("Ocurrió un error al crear el producto" + errorPl);
              };
            }
        }

        vm.update = function(){
            vm.setToggleSelected();
            var promise = ProductService.update(vm.product, vm.product.id);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("El producto fue actualizado satisfactoriamente");
                
                angular.forEach(vm.ProductTaxList, function(producttax, key){
                    if(angular.isUndefined(producttax.id)) producttax.id = 0;
                    producttax.product_id = vm.product.id;
                });

                var promise_tax = ProductTaxService.update(vm.ProductTaxList, vm.product.id);
                promise_tax.then(function(data){
                    toastr.success("Los impuestos para el producto fueron actualizados satisfactoriamente");
                    window.location = HOST_ROUTE.PRODUCT;
                });                
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al editar el producto" + errorPl);
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
                var promise = ProductService.delete(id);
                promise.then(function(pl){
                    toastr.success("El registro fue eliminado satisfactoriamente");
                    window.location = HOST_ROUTE.PRODUCT;    
                });
              }
            }); 

        }   

        vm.edit = function(id, IdCountry){
            var promise = ProductService.read(id);
            promise.then(function(pl){
                vm.product = pl.data;
                vm.readCountryTaxList(IdCountry);
                var promise_tax  = ProductTaxService.readFilter(id);
                promise_tax.then(function(datos){
                    vm.ProductTaxList = datos.data;
                    angular.forEach(vm.ProductTaxList, function(producttax){
                         var promise_country = CountryTaxService.read(producttax.country_tax_id);
                         promise_country.then(function(countrytax){
                             var countryTax = countrytax.data;
                             producttax.countrytax.tax = countryTax.tax;
                             producttax.countrytax.taxpercentage = countryTax.taxpercentage;
                             vm.product.expired_date = new Date(vm.product.expired_date.substring(0,4), 
                                                                parseInt(vm.product.expired_date.substring(5,7))-1,
                                                                vm.product.expired_date.substring(8));
                         });
                    });
                });
                vm.readToggleSelected();
            });
        }

        vm.readAll = function(idCompany){
            var promise = ProductService.readAll(idCompany);
            promise.then(function(pl){
                vm.ProductsList = pl.data;
            }); 
        }

        vm.readCompanyList = function(){
            var promise = CompanyService.readAll();
            promise.then(function(pl){
                vm.CompanyList = pl.data;
            });    
        }

        vm.readCountryTaxList = function(IdCountry){
            var promise = CountryTaxService.readFilter(IdCountry, ENTITY.TAX);
            promise.then(function(pl){
                vm.CountryTaxList = pl.data;
            }); 
        }

        vm.selectProductTax = function(tax){
           var promise = CountryTaxService.read(tax);
           promise.then(function(pl){
              var countryTax = pl.data;
              vm.ProductTax.product_id = 0;
              vm.ProductTax.country_tax_id = tax; 
              vm.ProductTax.countrytax = countryTax;
              vm.TipoPorcentaje = countryTax.taxpercentage.name;
              vm.Tasa = countryTax.tax.name;
              vm.enableButton = true;
           });
           
        }

        vm.addProductTax = function(){
           var tax_exists = false;

           angular.forEach(vm.ProductTaxList, function(tax, key){
                if(tax.country_tax_id===vm.ProductTax.country_tax_id){
                  tax_exists = true;
                }
                if(vm.defaultTaxtoggleSelected===true && tax.is_default===1){
                  tax.is_default = 0;
                }
           });

           if(!tax_exists){
              if(vm.defaultTaxtoggleSelected===true) {
                vm.ProductTax.is_default = 1;
              }else{
                vm.ProductTax.is_default = 0;
              }
              vm.ProductTaxList.push(vm.ProductTax); 
              vm.ProductTax = {};
              vm.TipoPorcentaje = "";
              vm.Tasa = "";
              vm.taxSelected = "";
              vm.enableButton=false;
           }
           else 
              SweetAlert.swal("Impuesto de Producto!", "El impuesto ya está asociado al Producto", "warning"); 
        }

        vm.deleteProductTax = function(productTax){
            var index = 0;
            var deleted = false;

            SweetAlert.swal({
                  title: 'Eliminar Impuesto',
                  text: "¿Está seguro que desea eliminar el Impuesto?",
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
                 deleted = true;
                 if(productTax.id>0){
                    var promise = ProductTaxService.delete(productTax.id);
                    promise.then(function(pl){
                       
                    },
                      function (errorPl) {
                       toastr.error("Error al tratar de eliminar Impuesto");
                       deleted = false;
                    });  
                 }
                 if(deleted){
                    index = vm.ProductTaxList.indexOf(productTax);
                    vm.ProductTaxList.splice(index, 1);  
                 } 
              }
            }); 
            
        }
        
        vm.setToggleSelected = function(){
            //
            if(vm.purchasetoggleSelected==true)
                vm.product.is_purchase_active=1;
            else 
                vm.product.is_purchase_active=0;

            if(vm.salestoggleSelected==true)
                vm.product.is_sale_active=1;
            else 
                vm.product.is_sale_active=0;
            // 
            if(vm.activetoggleSelected==true)
                vm.product.is_active=1;
            else 
                vm.product.is_active=0;
        }

        vm.readToggleSelected = function(){
            //
            if(vm.product.is_purchase_active==1) 
                vm.purchasetoggleSelected=true;
            else 
                vm.purchasetoggleSelected=false;

            if(vm.product.is_sale_active==1) 
                vm.salestoggleSelected=true;
            else 
                vm.salestoggleSelected=false;

            // 
            if(vm.product.is_active==1) 
                vm.activetoggleSelected=true;
            else 
                vm.activetoggleSelected=false;
        }

        vm.resetImport();

    }
})();