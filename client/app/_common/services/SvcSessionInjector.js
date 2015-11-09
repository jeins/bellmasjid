define(['../app.common'], function(app){
        'use strict'

        var name = 'SvcSessionInjector';
        var depedencies = ['$q', 'SvcToken', 'CONFIG'];
        var service = function($q, SvcToken, CONFIG){
            return {
                request: function(config) {
                    if(SvcToken.get().loggedIn){
                        config.headers[CONFIG.http.header.token] = SvcToken.get().token;
                        config.headers[CONFIG.http.header.req_type] = CONFIG.http.values.req_json;
                        config.headers[CONFIG.http.header.auth] = SvcToken.get().user;
                    }
                    
                    return config;
                }
            };
        };

        app.factory(name, depedencies.concat(service));
    });