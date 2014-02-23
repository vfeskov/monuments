(function(angular){
    'use strict';
    var module = angular.module('monumentsCollections', []);

    module.config(function($routeProvider) {
        $routeProvider.when('/collections', {
            templateUrl: '/monuments/collections/collectionsTpl.html',
            controller: 'monumentsCollectionsCtrl'
        });
    });

}(window.angular));
