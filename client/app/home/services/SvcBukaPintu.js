define(['../app.home'], function(app){
        'use strict';

        var name = 'SvcBukaPintu';
        var depedencies = ['$http', '$q', 'CONFIG'];
        var service = function($http, $q, CONFIG) {
            function bukapintu(){
                var deferred = $q.defer();

                var req = {
                    url:  CONFIG.http.host + '/v1/bukapintu',
                    method: 'GET',
                    data: ''
                };

                $http(req)
                    .then(function(result){
                        console.log(result);
                        deferred.resolve(result.data.load);   // nothing then "1" ..
                    })
                    .catch(function(error){
                        deferred.reject(error);
                    })
                ;
                return deferred.promise;
            }

            return {
                bukapintu: bukapintu
            };
        };

        app.factory(name, depedencies.concat(service));
    });