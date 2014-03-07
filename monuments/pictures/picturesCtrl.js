(function(angular){
    'use strict';
    var module = angular.module('monumentsPictures');

    module.controller("monumentsPicturesCtrl", function($scope, monumentsAuthSvc, monumentsCollectionsSvc, monumentsMonumentsSvc, monumentsPicturesSvc, $routeParams, $rootScope) {
        $rootScope.loading = true;
        monumentsCollectionsSvc.getOne($routeParams.collectionid).then(function(collection){
            $rootScope.currentCollection = collection;
        });
        monumentsMonumentsSvc.getOne($routeParams.collectionid, $routeParams.monumentid).then(function(monument){
            $rootScope.currentMonument = monument;
        });
        monumentsPicturesSvc.getAll($routeParams.collectionid, $routeParams.monumentid).then(function(pictures){
            $rootScope.loading = false;
            $scope.pictures = pictures;
        });
    });

    module.controller("monumentsPicturesItemCtrl", function($scope, monumentsPicturesSvc, $routeParams) {
        $scope.isEdited = false;
        $scope.delete = function(){
            monumentsPicturesSvc.delete($routeParams.collectionid, $routeParams.monumentid, $scope.picture.id).then(function(){
                $scope.pictures = $scope.pictures.splice($scope.$index, 1);
            });
        };
        $scope.edit = function(){
            $scope.isEdited = true;
            $scope.name = $scope.picture.name;
            $scope.description = $scope.picture.description;
            $scope.date = $scope.picture.date;
        };
        $scope.saveEdit = function(){
            monumentsPicturesSvc.update($routeParams.collectionid, $routeParams.monumentid, $scope.picture.id, {
                name: $scope.name,
                description: $scope.description,
                date: $scope.date
            }).then(function(){
                $scope.isEdited = false;
                $scope.picture.name = $scope.name;
                $scope.picture.description = $scope.description;
                $scope.picture.date = $scope.date;
            }, function(){
                $scope.name = $scope.picture.name;
                $scope.description = $scope.picture.description;
                $scope.date = $scope.picture.date;
            });
        };
        $scope.cancelEdit = function(){
            $scope.isEdited = false;
        };
    });

    module.controller("monumentsPicturesCreateCtrl", function($scope, monumentsPicturesSvc, $routeParams) {
        $scope.image = '';
        $scope.name = '';
        $scope.description = '';
        $scope.date = '';
        $scope.create = function(){
            monumentsPicturesSvc.create($routeParams.collectionid, $routeParams.monumentid, {
                image: angular.element('input[type=file][name=image]')[0].files[0],
                name: $scope.name,
                description: $scope.description,
                date: $scope.date
            }).then(function(picture){
                $scope.pictures.push(picture);
                $scope.image = '';
                $scope.name = '';
                $scope.description = '';
                $scope.date = '';
            });
        };
    });

}(window.angular));
