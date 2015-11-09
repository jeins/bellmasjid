define(['angular'], function (angular) {
    'use strict';

    var home = angular.module('app.home', []);

    home.config([
    	'$urlRouterProvider', '$stateProvider',
    	function($urlRouterProvider, $stateProvider){
    		$stateProvider
	            .state('home', {
	                url: '/home',
	                templateUrl: 'app/home/templates/home.html',
	                controller: 'CtrlHome as CHome'
	            })
                .state('login', {
                    url: '/login',
                    templateUrl: 'app/home/templates/login.html',
                    controller: 'CtrlAuth as CAuth'
                })
                .state('register', {
                    url: '/register',
                    templateUrl: 'app/home/templates/register.html',
                    controller: 'CtrlAuth as CAuth'
                })
                .state('register-complete', {
                    url: '/register-complete/:fullname/:email',
                    templateUrl: 'app/home/templates/register_confirm.html',
                    controller: 'CtrlAuth as CAuth'
                })
    	}
	]);

    return home;
});