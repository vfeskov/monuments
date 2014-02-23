(function(angular){
    'use strict';
    var module = angular.module('monumentsSearch', []);

    module.config(function($routeProvider) {
        $routeProvider.when('/search/:query', {
            templateUrl: '/monuments/search/searchTpl.html',
            controller: 'monumentsSearchCtrl'
        });
    });

}(window.angular));
