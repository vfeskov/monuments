(function(angular){
    'use strict';
    var module = angular.module('monumentsMonuments');

    module.factory('monumentsMonumentsSvc', function($http, CSRF_TOKEN) {
        return {
            getAll: function(collectionId){
                return $http.get('/services/collections/'+collectionId+'/monuments').then(function(response){
                    return response.data;
                });
            },
            getOne: function(collectionId, id){
                return $http.get('/services/collections/'+collectionId+'/monuments/'+id).then(function(response){
                    return response.data;
                });
            },
            create: function(collectionId, data){
                return $http.post('/services/collections/'+collectionId+'/monuments', angular.extend(data, {csrf_token: CSRF_TOKEN})).then(function(response){
                    return response.data;
                });
            },
            'delete': function(collectionId, id){
                return $http['delete']('/services/collections/'+collectionId+'/monuments/'+id).then(function(response){
                    return response.data;
                });
            },
            update: function(collectionId, id, data){
                return $http.put('/services/collections/'+collectionId+'/monuments/'+id, angular.extend(data, {csrf_token: CSRF_TOKEN})).then(function(response){
                    return response.data;
                });
            }
        };
    });
}(window.angular));