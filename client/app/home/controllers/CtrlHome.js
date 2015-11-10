define(['../app.home'], function(app){
	'use strict';

	var name = 'CtrlHome';
	var dependencies = ['$scope','$mdSidenav', '$mdDialog', '$timeout', '$window', 'SvcBukaPintu'];
	var controller = function($scope, $mdSidenav, $mdDialog, $timeout, $window, SvcBukaPintu){
		$scope.title = "Buka Pintu!";
		$scope.toggleSidenav = function(menuId) {
			$mdSidenav(menuId).toggle();
		};

		this.pencetBell = function(){
			SvcBukaPintu.bukapintu();
			$timeout(function($locationProvider, $location) {
				$window.history.back(1);
			}, 3000);

		}
	};
	app.controller(name, dependencies.concat(controller));
});