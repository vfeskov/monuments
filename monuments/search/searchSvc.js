(function(angular){
    'use strict';
    var module = angular.module('monumentsSearch');

    module.factory('monumentsSearchSvc', function($http, CSRF_TOKEN) {
        return {
            search: function(data){
                return $http.post('/services/search', angular.extend(data, {csrf_token: CSRF_TOKEN})).then(function(response){
                    return response.data;
                });
            }
        };
    });
}(window.angular));