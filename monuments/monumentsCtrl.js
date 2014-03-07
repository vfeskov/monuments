(function(angular){
    'use strict';
    var module = angular.module('monuments');

    module.controller('monumentsCtrl', function($scope, $location, monumentsAuthSvc){
        $scope.isCollections = function(){
            return $location.path().indexOf('/collections')>-1;
        };
        $scope.isLoggedIn = monumentsAuthSvc.isLoggedIn();
        monumentsAuthSvc.watch(function(isLoggedIn){
            $scope.isLoggedIn = isLoggedIn;
        });
        $scope.logout = function(){
            monumentsAuthSvc.logout().then(function() {
                $location.path('/login');
            });
        };
        $scope.searchQuery = '';
        $scope.submitSearch = function(){
            if(!$scope.searchQuery) return;
            $location.path('/search/'+$scope.searchQuery);
        };
    });

}(window.angular));
