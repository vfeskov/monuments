(function(angular){
    'use strict';
    var module = angular.module('monuments', ['ngRoute', 'ngAnimate', 'angular-growl', 'ngSanitize', 'monumentsLogin', 'monumentsCollections', 'monumentsMonuments', 'monumentsPictures']);

    module.config(function($locationProvider, $routeProvider, growlProvider) {
        growlProvider.globalTimeToLive(5000);

        $locationProvider.html5Mode(true).hashPrefix('!');

        $routeProvider.otherwise({ redirectTo: '/collections' });
    });

    module.config(function($httpProvider){
        var logsOutUserOn401 = function($location, $q, monumentsSessionSvc) {
            var success = function(response) {
                return response;
            };

            var error = function(response) {
                if(response.status === 401) {
                    monumentsSessionSvc.unset('authenticated');
                    $location.path('/login');
                }
                return $q.reject(response);
            };

            return function(promise) {
                return promise.then(success, error);
            };
        };

        $httpProvider.responseInterceptors.push(logsOutUserOn401);
    });

    module.run(function($rootScope, $location, monumentsAuthSvc, growl) {
        var routesThatDontRequireAuth = ['/login', '/register'];

        $rootScope.$on('$routeChangeStart', function(event, next, current) {
            if(routesThatDontRequireAuth.indexOf($location.path()) === -1 && !monumentsAuthSvc.isLoggedIn()) {
                $location.path('/login');
                growl.addWarnMessage("Please log in to continue.");
            } else if (routesThatDontRequireAuth.indexOf($location.path()) >= -1 && monumentsAuthSvc.isLoggedIn()){
                //$location.path('/collections');
            }
        });
    });

}(window.angular));
