(function () {
    "use strict";

    angular
        .module('QuantumApp')
        .controller('CompanyController', CompanyController);

    CompanyController.$inject = ['$scope', '$http', '$location', '$timeout', 'CompanyService', 'CorrelativeDocumentService', 'EntityMasterDataService', '$rootScope', 'ENTITY', 'toastr', 'HOST_ROUTE', 'SweetAlert', 'Upload'];

    function CompanyController($scope, $http, $location, $timeout, CompanyService, CorrelativeDocumentService, EntityMasterDataService, $rootScope, ENTITY, toastr, HOST_ROUTE, SweetAlert, Upload) {
        
        var vm = this;

        vm.companyList = [];
        vm.company     = [];
        vm.DocumentTypeList = [];
        vm.CorrelativeDocumentList = [];
        vm.EmissionTypeList = "";
        vm.EnvironmentTypeList = "";
        vm.accountingtoggleSelected = true;
        vm.artisantoggleSelected=false;
        vm.activetoggleSelected = true;
        vm.CertificadoModificado = false;
        vm.CertificadoEliminado = false;
        vm.LogoModificado = false;
        vm.LogoEliminado = false;
        vm.environmentTypeSelected = "";
        vm.emissionTypeSelected = "";
        vm.token = "";

        vm.create = function(){
            //
            vm.setToggleSelected();

            var promise = CompanyService.create(vm.company);
            promise.then(function(pl){
                var company_created = pl.data;
                toastr.success("La Compañía fué creada satisfactoriamente");

                vm.guardarCertificado(company_created.id);
                vm.guardarLogo(company_created.id);
                
                angular.forEach(vm.CorrelativeDocumentList, function(correlativo, key){
                    correlativo.company_id = company_created.id;
                });
                // Servicio para crear los correlativos de los documentos fiscales de la compañia creada.
                var promise_cor = CorrelativeDocumentService.create(vm.CorrelativeDocumentList);
                promise_cor.then(function(data){
                    toastr.success("Los Correlativos de los Tipos de Documentos fueron creados satisfactoriamente");
                    window.location = HOST_ROUTE.COMPANY;
                });
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al crear la Compañia" + errorPl);
            };
        }

        vm.loadNewCompany = function(){
            vm.createCorrelativeDocument();
            vm.readEnvironmentTypeList();
            vm.readEmissionTypeList();
        }

        vm.createCorrelativeDocument = function(){
            var promise = EntityMasterDataService.readFilterByEntity(ENTITY.DOCUMENT_TYPE);
            promise.then(function(pl){
                vm.DocumentTypeList = pl.data;
                angular.forEach(vm.DocumentTypeList, function(documentType, key){
                    var correlativeDocument = {};
                    correlativeDocument.increment_number = 0;
                    correlativeDocument.serie = "000000";
                    correlativeDocument.company_id = 0;
                    correlativeDocument.document_type_id = documentType.id;
                    correlativeDocument.documenttype = documentType;
                    vm.CorrelativeDocumentList.push(correlativeDocument);
                });
            });
        }

        vm.loadCorrelativeDocument = function(IdCompany){
            var promise = CorrelativeDocumentService.readFilter(IdCompany);
            promise.then(function(pl){
                vm.CorrelativeDocumentList = pl.data;
                vm.readEnvironmentTypeList();
                vm.readEmissionTypeList();
            });
        }

        vm.selectEmissionType = function(emission){
           vm.company.emission_type = emission; 
        }

        vm.selectEnvironmentType = function(environment){
           vm.company.environment_type = environment;
        }

        vm.readEnvironmentTypeList = function(){
           var promise = EntityMasterDataService.readFilterByEntity(ENTITY.ENVIRONMENT_TYPE);
           promise.then(function (pl) {
              vm.EnvironmentTypeList = pl.data;
              vm.environmentTypeSelected = vm.company.environment_type;
           });
        }

        vm.readEmissionTypeList = function(){
           var promise = EntityMasterDataService.readFilterByEntity(ENTITY.EMISSION_TYPE);
           promise.then(function (pl) {
              vm.EmissionTypeList = pl.data;
              vm.emissionTypeSelected = vm.company.emission_type;
           });
        }        

        vm.update = function(){
            vm.setToggleSelected();            

            var promise = CompanyService.update(vm.company, vm.company.id, vm.token);
            promise.then(function(pl){
                var retorno = pl.data;
                toastr.success("La Compañía fué actualizada satisfactoriamente");
                vm.guardarCertificado(vm.company.id);
                vm.guardarLogo(vm.company.id);                
                
                // Servicio para modificar los correlativos de los documentos fiscales de la compañia creada.
                var promise_cor = CorrelativeDocumentService.update(vm.CorrelativeDocumentList, vm.company.id);
                promise_cor.then(function(data){
                    toastr.success("Los Correlativos de los Tipos de Documentos fueron modificados satisfactoriamente");
                    window.location = HOST_ROUTE.COMPANY;
                });
                
            }),
            function (errorPl) {
                toastr.error("Ocurrió un error al actualizar la Compañía" + errorPl);
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
                    window.location = HOST_ROUTE.COMPANY;    
                });
              }
            }); 

        }       

        vm.edit = function(id){
            var promise = CompanyService.read(id);
            promise.then(function(pl){
                vm.company = pl.data;
                vm.loadCorrelativeDocument(id);
                vm.readCertificate(id);
                vm.readLogo(id);
                vm.readEnvironmentTypeList();
                vm.readEmissionTypeList();
                vm.readToggleSelected();
            });
        }

        vm.readCertificate = function(id){
            var promise = CompanyService.readCertificate(id);
            promise.then(function(pl){
                vm.Certificado = "data:application/x-pkcs12;base64," + pl.data;
            });
        }

        vm.readLogo = function(id){
            var promise = CompanyService.readLogo(id);
            promise.then(function(pl){
                vm.Logo = "data:image/png;base64," + pl.data;
            });
        }

        vm.readAll = function(){
            var promise = CompanyService.readAll();
            promise.then(function(pl){
                vm.companyList = pl.data;
            }); 
        }

        // Convierte el archivo seleccionado por el usuario el formato base64 para luego enviarlo a la API y lo guarde en la BD.
        vm.seleccionarCertificado = function (file) {
            if (file) {
                Upload.base64DataUrl(file).then(function (url) {
                    vm.Certificado = url;
                    vm.CertificadoModificado = true;
                    vm.CertificadoEliminado = false;
                });
            }
        };

        // Convierte el archivo seleccionado por el usuario el formato base64 para luego enviarlo a la API y lo guarde en la BD.
        vm.seleccionarLogo = function (file) {
            if (file) {
                Upload.base64DataUrl(file).then(function (url) {
                    vm.Logo = url;
                    vm.LogoModificado = true;
                    vm.LogoEliminado = false;
                });
            }
        };

        // Permite guardar el certificado de compañia en BD.
        vm.guardarCertificado = function (idCompany) {

            var file = vm.Certificado;

            // Valida que exista un archivo seleccionado.
            if (file) {

                var certificate = file;

                if (!(certificate === "" || certificate === null || certificate === undefined)) {

                    if (vm.CertificadoModificado) {
                        // Elimina el formato (data:image/jpeg;base64) del objeto creado por el módulo ng-UploadFile
                        if (!vm.CertificadoEliminado)
                            certificate = certificate.substring(certificate.indexOf(",") + 1);
                        else
                            certificate = ""; // Se está eliminando el archivo y se debe actualizar la BD.

                         var promise = CompanyService.UpdateCertificate(idCompany, certificate);

                         promise.then(function (pl) {
                            var resp = pl.data;
                            if (resp === "OK") {
                                toastr.success("Certificado guardado exitosamente");
                                vm.CertificadoModificado = false;
                            } else {
                                toastr.error('Error al guardar Certificado');
                            }
                        },
                            function (errorPl) {
                                $scope.error = errorPl;
                            });    
                    }
                }
            }
        };

        // Permite guardar la imagen del usuario en BD.
        vm.guardarLogo = function (idCompany) {

            var file = vm.Logo;

            // Valida que exista un archivo seleccionado.
            if (file) {

                var logo = file;

                if (!(logo === "" || logo === null || logo === undefined)) {

                    if (vm.LogoModificado) {
                        // Elimina el formato (data:image/jpeg;base64) del objeto creado por el módulo ng-UploadFile
                        if (!vm.LogoEliminado)
                            logo = logo.substring(logo.indexOf(",") + 1);
                        else
                            logo = ""; // Se está eliminando el archivo y se debe actualizar la BD.

                        var promise = CompanyService.UpdateLogo(idCompany, logo);

                        promise.then(function (pl) {
                            var resp = pl.data;
                            if (resp === "OK") {
                                toastr.success("Logo guardado exitosamente");
                                vm.LogoModificado = false;
                            } else {
                                toastr.error('Error al guardar Logo');
                            }

                        },
                            function (errorPl) {
                                $scope.error = errorPl;
                            });

                    }
                }
            }
        };

        vm.setToggleSelected = function(){
            //
            if(vm.accountingtoggleSelected==true)
                vm.company.is_accounting=1;
            else 
                vm.company.is_accounting=0;
            // 
            if(vm.activetoggleSelected==true)
                vm.company.is_active=1;
            else 
                vm.company.is_active=0;
            if(vm.artisantoggleSelected==true)
                vm.company.is_artisan=1;
            else
                vm.company.is_artisan=0;
        }

        vm.readToggleSelected = function(){
            //
            if(vm.company.is_accounting==1) 
                vm.accountingtoggleSelected=true;
            else 
                vm.accountingtoggleSelected=false;
            // 
            if(vm.company.is_active==1) 
                vm.activetoggleSelected=true;
            else 
                vm.activetoggleSelected=false;
            if(vm.company.is_artisan==1) 
                vm.artisantoggleSelected=true;
            else 
                vm.artisantoggleSelected=false;
        }

    }
})();