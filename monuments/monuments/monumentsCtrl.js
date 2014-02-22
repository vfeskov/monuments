(function(angular){
    'use strict';
    var module = angular.module('monumentsMonuments');

    module.controller("monumentsMonumentsCtrl", function($scope, monumentsAuthSvc, monumentsCollectionsSvc, monumentsMonumentsSvc, $routeParams) {
        monumentsCollectionsSvc.getOne($routeParams.collectionid).then(function(collection){
            $scope.collection = collection;
        });
        monumentsMonumentsSvc.getAll($routeParams.collectionid).then(function(monuments){
            $scope.monuments = monuments;
        });
    });

    module.controller("monumentsMonumentsItemCtrl", function($scope, monumentsMonumentsSvc, $routeParams) {
        $scope.isEdited = false;
        $scope.delete = function(){
            monumentsMonumentsSvc.delete($routeParams.collectionid, $scope.monument.id).then(function(){
                $scope.monuments = $scope.monuments.splice($scope.$index, 1);
            });
        };
        $scope.edit = function(){
            $scope.isEdited = true;
            $scope.name = $scope.monument.name;
            $scope.description = $scope.monument.description;
            $scope.category_id = $scope.monument.category_id;
        };
        $scope.saveEdit = function(){
            monumentsMonumentsSvc.update($routeParams.collectionid, $scope.monument.id, $scope.newName).then(function(){
                $scope.isEdited = false;
                $scope.collection.name = $scope.name;
                $scope.collection.description = $scope.description;
                $scope.collection.category_id = $scope.category_id;
            }, function(){
                $scope.name = $scope.monument.name;
                $scope.description = $scope.monument.description;
                $scope.category_id = $scope.monument.category_id;
            });
        };
        $scope.cancelEdit = function(){
            $scope.isEdited = false;
        };
    });

    module.controller("monumentsMonumentsCreateCtrl", function($scope, monumentsMonumentsSvc, $routeParams) {
        $scope.create = function(){
            monumentsMonumentsSvc.create($routeParams.collectionid, {
                name: $scope.name,
                description: $scope.description,
                category_id: $scope.category_id
            }).then(function(monument){
                $scope.monuments.push(monument);
                $scope.name = '';
                $scope.description = '';
                $scope.category_id = '';
            });
        };
    });

}(window.angular));