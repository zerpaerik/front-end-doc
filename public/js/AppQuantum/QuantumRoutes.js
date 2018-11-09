(function () {
    "use strict";

    var app = angular.module("QuantumApp");

    app.config([
        "$logProvider", "$stateProvider", "$urlRouterProvider", "$locationProvider", "$httpProvider", 
        function ($logProvider, $stateProvider, $urlRouterProvider, $locationProvider, $httpProvider) {
            // configure Idle settings
            $stateProvider
                .state("Home",
                {
                    url: "/",
                    views: {
                        "content": {
                            templateUrl: '/Home/Index'
                        }
                    }
                })
                .state("Usuarios", {
                    url: "/UsuarioPermisos",
                    views: {
                        "content": {
                            templateUrl: "/Usuarios/Usuarios"
                        }
                    }
                })
                .state("GestionUsuarios", {
                    url: "/Usuarios/GestionUsuario/:Id",
                    views: {
                        "content": {
                            templateUrl: function (params) {
                                return '/Usuarios/GestionUsuario/' + params.Id;
                            }

                        }
                    }
                })
                .state("Logout", {
                    url: "/Logout"
                });
            $urlRouterProvider.when('', '/');
        }
    ]);
})();