require.config({
    paths: {
        'app': './app',

        'angular': '../lib/angular/angular',
        'angular.material': '../lib/angular-material/angular-material.min',
        'angular.animate': '../lib/angular-animate/angular-animate.min',
        'angular.aria': '../lib/angular-aria/angular-aria.min',
        'angular.material-icon': '../lib/angular-material-icons/angular-material-icons.min',
        'angular.messages': '../lib/angular-messages/angular-messages.min',
        'angular.ui-router': '../lib/angular-ui-router/release/angular-ui-router.min'
    },
    shim: {
        'angular' : {
            exports : 'angular'
        },
        'angular.ui-router': {
            deps: ['angular']
        },
        'angular.animate' : {
            deps : ['angular']
        },
        'angular.aria': {
            deps: ['angular']
        },
        'angular.material': {
            deps: ['angular.animate', 'angular.aria']
        },
        'angular.material-icon': {
            deps: ['angular.material']
        },
        'angular.messages': {
            deps: ['angular']
        }
    }
});

require(['angular', 'app'], function(angular, app){
    // angular.element().ready(function() {
    //     // bootstrap the app manually
    //     angular.bootstrap(document, ['myApp']);
    // }, false);
    angular.bootstrap(document, ['app']);
    // var $html = angular.element(document.getElementsByTagName('html')[0]);console.log($html);   
})