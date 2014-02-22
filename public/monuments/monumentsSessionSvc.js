(function(angular){
    'use strict';
    var module = angular.module('monuments');

    module.factory("monumentsSessionSvc", function() {
        return {
            get: function(key) {
                return sessionStorage.getItem(key);
            },
            set: function(key, val) {
                return sessionStorage.setItem(key, val);
            },
            unset: function(key) {
                return sessionStorage.removeItem(key);
            }
        }
    });
}(window.angular));
