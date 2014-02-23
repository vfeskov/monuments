(function(angular){
    'use strict';
    var module = angular.module('monumentsSearch');

    module.controller("monumentsSearchCtrl", function($scope, monumentsSearchSvc, $routeParams) {
        $scope.query = $routeParams.query;
        monumentsSearchSvc.search({
            query: $scope.query
        }).then(function(monuments){
            $scope.monuments = monuments;
        });
    });

}(window.angular));
