(function(angular){
    'use strict';

    var module = angular.module('monuments');

    module.factory("monumentsAuthSvc", function($http, $sanitize, monumentsSessionSvc, growl, CSRF_TOKEN) {

        var cacheSession   = function() {
            monumentsSessionSvc.set('authenticated', true);
            watchers.forEach(function(cb){cb(true);});
        };

        var uncacheSession = function() {
            monumentsSessionSvc.unset('authenticated');
            watchers.forEach(function(cb){cb(false);});
        };

        var loginError = function(response) {
            growl.addErrorMessage(response.flash);
        };

        var sanitizeCredentials = function(credentials) {
            return {
                email: $sanitize(credentials.email),
                password: $sanitize(credentials.password),
                password_confirmation: $sanitize(credentials.password_confirmation),
                csrf_token: CSRF_TOKEN
            };
        };

        var watchers = [];

        return {
            register: function(credentials) {
                var register = $http.post("/auth/register", sanitizeCredentials(credentials));
                register.then(cacheSession, loginError);
                return register;
            },
            login: function(credentials) {
                var login = $http.post("/auth/login", sanitizeCredentials(credentials));
                login.then(cacheSession, loginError);
                return login;
            },
            logout: function() {
                var logout = $http.get("/auth/logout");
                logout.then(uncacheSession);
                return logout;
            },
            isLoggedIn: function() {
                return monumentsSessionSvc.get('authenticated');
            },
            watch: function(cb) {
                watchers.push(cb);
            }
        };
    });
}(window.angular));
