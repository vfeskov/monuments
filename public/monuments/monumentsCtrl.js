(function(angular){
    'use strict';
    var module = angular.module('monuments');

    module.controller('monumentsCtrl', function($scope, $location, monumentsAuthSvc){
        $scope.isLoggedIn = monumentsAuthSvc.isLoggedIn();
        monumentsAuthSvc.watch(function(isLoggedIn){
            $scope.isLoggedIn = isLoggedIn;
        });
        $scope.logout = function(){
            monumentsAuthSvc.logout().then(function() {
                $location.path('/login');
            });
        };
    });

}(window.angular));
