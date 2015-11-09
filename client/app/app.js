define([
    'angular', 'app', 'angular.ui-router', 'angular.animate', 'angular.aria',
    'angular.material', 'angular.material-icon', 'angular.messages',
    './config', 
    './_common/app.common', './_common/app.common.req',
    './home/app.home', './home/app.home.req'
], function (angular) {

    var app = angular.module('app', [
        'ui.router', 
        'ngAnimate', 'ngMaterial', 'ngMdIcons', 'ngMessages',
        'app.config', 'app.common', 'app.home'
    ]);

    // inject header before request
    app.config(['$httpProvider', function ($httpProvider) {
        $httpProvider.interceptors.push('SvcSessionInjector');
    }]);

    // first route to homepage
    app.config(['$urlRouterProvider', '$locationProvider', function ($urlRouterProvider, $locationProvider) {
        $locationProvider.html5Mode(true).hashPrefix('!');
        $urlRouterProvider.otherwise('/login');
    }]);

    // light-blue design
    app.config(function($mdThemingProvider) {
        var customBlueMap = $mdThemingProvider.extendPalette('light-blue', {
            'contrastDefaultColor': 'light',
            'contrastDarkColors': ['50'],
            '50': 'ffffff'
        });
        $mdThemingProvider.definePalette('customBlue', customBlueMap);
        $mdThemingProvider.theme('default')
            .primaryPalette('customBlue', {
            'default': '500',
            'hue-1': '50'
        })
            .accentPalette('pink');
        $mdThemingProvider.theme('input', 'default')
            .primaryPalette('grey')
    });
   
    app.run();
    return app;
});