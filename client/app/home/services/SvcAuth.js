define(['../app.home'], function(app){
        'use strict';

        var name = 'SvcAuth';
        var depedencies = ['$http', '$q', 'SvcToken', 'SvcEncrypt', 'CONFIG'];
        var service = function($http, $q, SvcToken, SvcEncrypt, CONFIG) {
            function login(data){
                var deferred = $q.defer();

                data.password = SvcEncrypt.encodeRSA(data.password);

                var req = {
                    url: CONFIG.http.host + '/v1/login',
                    method: 'POST',
                    data: data
                };

                $http(req)
                    .then(function(result){
                        if(result.data.token){
                            SvcToken.set(result.data.token, SvcEncrypt.encodeBase64(data.email));
                        }
                        deferred.resolve(result);   // nothing then "1" ..
                    })
                    .catch(function(error){
                        deferred.reject(error);
                    })
                ;
                return deferred.promise;
            }

            function register(data){
                var deferred = $q.defer();

                data.password = SvcEncrypt.encodeRSA(data.password);

                var req = {
                    url:  CONFIG.http.host + '/v1/register',
                    method: 'POST',
                    data: data
                };

                $http(req)
                    .then(function(result){
                        console.log(result);
                        // SEND EMAIL to Admin!
                        deferred.resolve(result);   // nothing then "1" ..
                    })
                    .catch(function(error){
                        deferred.reject(error);
                    })
                ;
                return deferred.promise;
            }

            return {
                login: login,
                register: register
            };
        };

        app.factory(name, depedencies.concat(service));
    });