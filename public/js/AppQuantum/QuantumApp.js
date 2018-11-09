(function () {
    'use strict';

    var app = angular.module('QuantumApp', [
        'ngAnimate',
        'ngSanitize',
        'ui.bootstrap',
        'toastr',
        'jcs-autoValidate',
        'ui.toggle',
        'ae-datetimepicker',
        'oitozero.ngSweetAlert',
        'isteven-multi-select',
        'localytics.directives',
        'ui.grid',
        'angucomplete-alt',
        'ngFileUpload',
        'ui.mask',
        'sb.checkbox'
    ]);

    app.config(function (toastrConfig) {
        angular.extend(toastrConfig, {
            autoDismiss: true,
            containerId: 'toast-container',
            maxOpened: 0,
            newestOnTop: true,
            positionClass: 'toast-bottom-right',
            preventDuplicates: false,
            preventOpenDuplicates: false,
            target: 'body'
        });
    });


    //test var
    
    app.constant('SERVER_CONFIG', {
        // 'API_HOST': 'http://74.127.61.115:9000/api' 
          'API_HOST': 'http://127.0.0.1:8080/api-rest-doc/public/api'
    });

    app.constant('SRI_SERVICE', {
        // Enlaces en la Nube
        'URL'           : 'http:///127.0.0.1:8080/invoice/validate/',
        'URL_RETENTION' : 'http:///127.0.0.1:8080/taxdocument/validate/',
        'URL_CREDITNOTE': 'http:///127.0.0.1:8080/creditnote/validate/',
        'URL_DEBITNOTE' : 'http:///127.0.0.1:8080/debitnote/validate/',
        'URL_REMISSION' : 'http:///127.0.0.1:8080/remission/validate/'

        // Enlaces Locales        
        // 'URL'           : 'http://localhost:8000/invoice/validate/',
        // 'URL_RETENTION' : 'http://localhost:8000/taxdocument/validate/',
        // 'URL_CREDITNOTE': 'http://localhost:8000/creditnote/validate/',
        // 'URL_DEBITNOTE' : 'http://localhost:8000/debitnote/validate/',
        // 'URL_REMISSION' : 'http://localhost:8000/remission/validate/'
    });

    app.constant('API_ROUTE', {
        'BRANCH'                : '/branch',
        'CLIENT'                : '/client',
        'PRODUCT'               : '/product',
        'PLAN'                  : '/plan',
        'USER'                  : '/user',    
        'COMPANY'               : '/company',
        'COMPANYPLAN'           : '/companyplan',
        'ENTITY'                : '/entity',
        'ENTITYMASTERDATA'      : '/entitymasterdata',
        'MAILCONFIGURATION'     : '/mailconfiguration',
        'INVOICE'               : '/invoice',
        'PREINVOICE'            : '/preinvoice',
        'COUNTRYTAX'            : '/countryTax' , 
        'PRODUCT_TAX'           : '/producttax',
        'CORRELATIVE_DOCUMENT'  : '/correlativedocument',
        'PERMISSION'            : '/permission',
        'SUPPLIER'              : '/supplier',
        'TAXDOCUMENT'           : '/taxdocument',
        'CREDITNOTE'            : '/creditnote',
        'DEBITNOTE'             : '/debitnote',
        'REMISSION'             : '/remission',
        'DISPATCHER'            : '/dispatcher'
    });

    app.constant('HOST_ROUTE', {
        'BRANCH'            : '/branch',
        'CLIENT'            : '/client',
        'PRODUCT'           : '/product',
        'PLAN'              : '/plan',
        'USER'              : '/user',
        'COMPANY'           : '/company',
        'COMPANYPLAN'       : '/companyplan',
        'ENTITYMASTERDATA'  : '/entitymasterdata',
        'MAILCONFIGURATION' : '/mailconfiguration',
        'MODULE'            : '/module',
        'ROLE'              : '/role',
        'PERMISSION'        : '/permission',
        'INVOICE'           : '/invoice',
        'PREINVOICE'        : '/invoice/prefactura',
        'COUNTRYTAX'        : '/countrytax',
        'SUPPLIER'          : '/supplier',
        'TAXDOCUMENT'       : '/taxdocument',
        'CREDITNOTE'        : '/creditnote',
        'DEBITNOTE'         : '/debitnote',
        'REMISSION'         : '/remission',
        'DISPATCHER'        : '/dispatcher'
    });

    app.constant('API_ACTION', {
        'CREATE'    : '/store',
        'READ'      : '/edit',
        'READALL'   : '/index',
        'UPDATE'    : '/update',
        'DELETE'    : '/delete'
    });

    app.constant('ENTITY', {
        'PAYMENT_TYPE'              : 1,
        'MAIL_SERVER_TYPE'          : 2,
        'MAIL_SECURITY_TYPE'        : 3,
        'MAIL_IDENTIFICATION_TYPE'  : 4,
        'PERMISSION'                : 5,
        'ROLE'                      : 6,
        'MODULE'                    : 7,
        'DOCUMENT_TYPE'             : 8,
        'TAX'                       : 9,
        'CURRENCY'                  : 10,
        'COUNTRY'                   : 11,
        'LANGUAGE'                  : 12,
        'TRANSPORTATION_TYPE'       : 13,
        'IDENTIFICATION_TYPE'       : 14,
        'EMISSION_TYPE'             : 15,
        'ENVIRONMENT_TYPE'          : 16,
        'TAX_PERCENTAGE'            : 17,
        'BANK'                      : 18,
        'TIME_UNIT'                 : 19,
        'RETENTION_DOCUMENT'        : 20,
        'TAX_RETENTION'             : 21,
        'TAX_RETENTION_PERCENTAGE'  : 22,
        'RETENTION_LIST'            : 23,
        'CREDIT_NOTE'               : 24,
        'DEBIT_NOTE'                : 25,
        'REMISSION'                 : 26
    });

    app.constant('DEFAULT_COUNTRY', {'EC': 28});

    app.constant('DOCUMENT_TYPE', {
        'FACTURA': 42,
        'RETENCION': 43,
        'NOTA_CREDITO': 44,
        'NOTA_DEBITO': 45,
        'GUIA_REMISION': 46
    });

    app.constant('TAX', {
        'IVA_0'  : 1,
        'IVA_12' : 2,
        'IVA_14' : 3,
        'IVA_NO_OBJETO' : 4,
        'IVA_EXENTO' : 5
    });

    app.constant('REMISSION_DEFAULT_TAX_CODE', {'TAX_CODE': 147});
    app.constant('NOTA_DEBITO_DEFAULT_TAX_CODE', {'TAX_CODE': 148});

    app.directive("enterKey", function(){
        return function(scope, element, attrs){
            element.bind("keydown keypress", function(event){
                if(event.which === 13 || event.which === 40 || event.which === 39 || 
                   event.which === 38 || event.which === 37 || event.which === 9){
                    scope.$apply(function(){
                        scope.$eval(attrs.enterKey);
                    });
                    //event.preventDefault();
                }
            });
        };
    });

    app.directive("fileread", [function () {
      return {
        scope: {
          opts: '='
        },
        link: function ($scope, $elm, $attrs) {
          $elm.on('change', function (changeEvent) {
            var reader = new FileReader();
            
            reader.onload = function (evt) {
              $scope.$apply(function () {
                var data = evt.target.result;
                
                var workbook = XLSX.read(data, {type: 'binary'});
                
                var headerNames = XLSX.utils.sheet_to_json( workbook.Sheets[workbook.SheetNames[0]], { header: 1 })[0];
                
                var data = XLSX.utils.sheet_to_json( workbook.Sheets[workbook.SheetNames[0]]);
                
                $scope.opts.columnDefs = [];
                headerNames.forEach(function (h) {
                  $scope.opts.columnDefs.push({ field: h });
                });
                
                $scope.opts.data = data;
                
                $elm.val(null);
              });
            };
            
            reader.readAsBinaryString(changeEvent.target.files[0]);
          });
        }
      };
    }]);
    
    app.run([
        'defaultErrorMessageResolver',
        function (defaultErrorMessageResolver) {
            // To change the root resource file path
            defaultErrorMessageResolver.setI18nFileRootPath('/js/angular_plugins/ng-autovalidate');
            defaultErrorMessageResolver.setCulture('es-CO');
        }
    ]);

    app.run(['$rootScope', '$log', '$location', '$window', '$timeout',  
         function ($rootScope, $log, $location, $window, $timeout) {

    //     $rootScope.$on("$stateChangeStart", function (event, toState, toParams) {
    //         if (toState.name === 'Logout') {
    //             $window.location.href = "Account/Login";
    //         }
    //     });

     }]);


})();
