(function(angular){
    'use strict';
    var module = angular.module('monumentsCollections');

    module.controller("monumentsCollectionsCtrl", function($scope, monumentsAuthSvc, monumentsCollectionsSvc, $rootScope) {
        $rootScope.currentCollection = false;
        $rootScope.currentMonument = false;
        $rootScope.loading = true;
        monumentsCollectionsSvc.getAll().then(function(collections){
            $scope.collections = collections;
            $rootScope.loading = false;
        });
    });

    module.controller("monumentsCollectionsItemCtrl", function($scope, monumentsCollectionsSvc) {
        $scope.isEdited = false;
        $scope.delete = function(){
            monumentsCollectionsSvc.delete($scope.collection.id).then(function(){
                $scope.collections = $scope.collections.splice($scope.$index, 1);
            });
        };
        $scope.edit = function(){
            $scope.isEdited = true;
            $scope.newName = $scope.collection.name;
        };
        $scope.saveEdit = function(){
            monumentsCollectionsSvc.update($scope.collection.id, $scope.newName).then(function(){
                $scope.isEdited = false;
                $scope.collection.name = $scope.newName;
            }, function(){
                $scope.newName = $scope.collection.name;
            });
        };
        $scope.cancelEdit = function(){
            $scope.isEdited = false;
        };
    });

    module.controller("monumentsCollectionsCreateCtrl", function($scope, monumentsCollectionsSvc) {
        $scope.name = '';
        $scope.create = function(){
            monumentsCollectionsSvc.create($scope.name).then(function(collection){
                $scope.collections.push(collection);
                $scope.name = '';
            });
        };
    });

}(window.angular));
