(function(angular){
    'use strict';
    var module = angular.module('monumentsCollections');

    module.factory('monumentsCollectionsSvc', function($http, CSRF_TOKEN) {
        return {
            getAll: function(){
                return $http.get('/services/collections').then(function(response){
                    return response.data;
                });
            },
            getOne: function(id){
                return $http.get('/services/collections/'+id).then(function(response){
                    return response.data;
                });
            },
            create: function(name){
                return $http.post('/services/collections', {name: name, csrf_token: CSRF_TOKEN}).then(function(response){
                    return response.data;
                });
            },
            'delete': function(id){
                return $http['delete']('/services/collections/'+id).then(function(response){
                    return response.data;
                });
            },
            update: function(id, name){
                return $http.put('/services/collections/'+id, {name: name, csrf_token: CSRF_TOKEN}).then(function(response){
                    return response.data;
                });
            }
        };
    });
}(window.angular));