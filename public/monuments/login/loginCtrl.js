(function(angular){
    'use strict';
    var module = angular.module('monumentsLogin');

    module.controller("monumentsLoginCtrl", function($scope, $location, monumentsAuthSvc) {
        $scope.register = false;
        $scope.credentials = { email: "", password: "" };

        $scope.submit = function() {
            var action = $scope.register ? 'register' : 'login';
            monumentsAuthSvc[action]($scope.credentials).success(function() {
                $location.path('/gallery');
                $scope.isLoggedIn = true;
            });
        };
    });

}(window.angular));
