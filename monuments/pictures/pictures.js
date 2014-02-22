(function(angular){
    'use strict';
    var module = angular.module('monumentsPictures', []);

    module.config(function($routeProvider) {
        $routeProvider.when('/collections/:collectionid/monuments/:monumentid/pictures', {
            templateUrl: '/monuments/pictures/picturesTpl.html',
            controller: 'monumentsPicturesCtrl'
        });
    });

}(window.angular));
