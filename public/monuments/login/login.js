(function(angular){
    'use strict';
    var module = angular.module('monumentsLogin', []);

    module.config(function($routeProvider) {
        $routeProvider.when('/login', {
            templateUrl: 'monuments/login/loginTpl.html',
            controller: 'monumentsLoginCtrl'
        });
    });

}(window.angular));
