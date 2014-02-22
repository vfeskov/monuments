(function(angular){
    'use strict';
    var module = angular.module('monumentsPictures');

    module.factory('monumentsPicturesSvc', function($http, CSRF_TOKEN) {
        var formDataObject = function(data) {
            var fd = new FormData();
            angular.forEach(data, function(value, key) {
                fd.append(key, value);
            });
            return fd;
        };
        return {
            getAll: function(collectionId, monumentId){
                return $http.get('/services/collections/'+collectionId+'/monuments/'+monumentId+'/pictures').then(function(response){
                    return response.data;
                });
            },
            getOne: function(collectionId, monumentId, id){
                return $http.get('/services/collections/'+collectionId+'/monuments/'+monumentId+'/pictures/'+id).then(function(response){
                    return response.data;
                });
            },
            create: function(collectionId, monumentId, data){
                return $http({
                    method: 'POST',
                    headers: {
                        'Content-Type': undefined
                    },
                    url: '/services/collections/'+collectionId+'/monuments/'+monumentId+'/pictures',
                    data: angular.extend(data, {csrf_token: CSRF_TOKEN}),
                    transformRequest: formDataObject
                }).then(function(response){
                    return response.data;
                });
            },
            'delete': function(collectionId, monumentId, id){
                return $http['delete']('/services/collections/'+collectionId+'/monuments/'+monumentId+'/pictures/'+id).then(function(response){
                    return response.data;
                });
            },
            update: function(collectionId, monumentId, id, data){
                return $http.put('/services/collections/'+collectionId+'/monuments/'+monumentId+'/pictures/'+id, angular.extend(data, {csrf_token: CSRF_TOKEN})).then(function(response){
                    return response.data;
                });
            }
        };
    });
}(window.angular));