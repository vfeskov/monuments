(function(angular){
    'use strict';
    var module = angular.module('monumentsMonuments', []);

    module.config(function($routeProvider) {
        $routeProvider.when('/collections/:collectionid/monuments', {
            templateUrl: '/monuments/monuments/monumentsTpl.html',
            controller: 'monumentsMonumentsCtrl'
        });
    });

}(window.angular));
