define(['../app.common'], function(app){
        'use strict'

        var name = 'SvcToken';
        var depedencies = ['$rootScope', '$window'];
        var service = function($rootScope, $window){
            var session = {}; //* userInfo: token, user, loggedIn

            function resetSession(){
                session = {
                    token: "",
                    user: "",
                    loggedIn: false
                };
                //$window.sessionStorage["userInfo"] = null;
                $window.sessionStorage["session"] = JSON.stringify(session);
                //$rootScope.$emit('session:update', session);
                console.log('SESSION RESET - DONE');
            }

            function setSession(token, user){
                session = {
                    token: token,
                    user: user,
                    loggedIn: true
                };
                $window.sessionStorage["session"] = JSON.stringify(session);
                //$rootScope.$emit('session:update', session);
                console.log('SESSION SET - DONE');
            }

            function getSession() {
                return session;
            }

            function init() {
                if ($window.sessionStorage["session"]) {
                    session = JSON.parse($window.sessionStorage["session"]);
                } else {
                    resetSession();
                }
                console.log('SESSION INIT - DONE');
            }

            init();

            return {
                set: setSession,
                reset: resetSession,
                get: getSession,
            };
        };

        app.factory(name, depedencies.concat(service));
    });