define(['../app.home'], function(app){
    'use strict';

    var name = 'SvcUsers';
    var depedencies = ['$http', '$q', 'CONFIG'];
    var service = function($http, $q, CONFIG) {
        function getPendingUsers(){
            var deferred = $q.defer();

            var req = {
                url:  CONFIG.http.host + '/v1/pending-users',
                method: 'GET',
                data: ''
            };

            $http(req)
                .then(function(result){
                    deferred.resolve(result.data);
                })
                .catch(function(error){
                    deferred.reject(error);
                })
            ;
            return deferred.promise;
        }

        return {
            getPendingUsers: getPendingUsers
        };
    };

    app.factory(name, depedencies.concat(service));
});