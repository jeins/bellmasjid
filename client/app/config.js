define(['angular'], function (angular) {
    'use strict';

    var config = angular.module('app.config', []);

    config.constant('CONFIG', {
        'init': {
            'appPath': 'app/'
        },
        'http': {
            'header': {
                'token': 'API-Token',
                'auth': 'WWW-Authorization',
                'req_type': 'Content-Type'
            },
            'values': {
            	'req_json': 'application/json'
            }
        },
        'key': {
            'base1': '_?1WK2!=',
            'base2': 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='
        }
    })

    return config;
});