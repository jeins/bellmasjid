define(['../app.home'], function(app){
	'use strict';

	var name = 'CtrlAuth';
	var dependencies = ['$scope', 'SvcAuth', 'SvcToken', '$location', '$stateParams', '$mdToast'];
	var controller = function($scope, SvcAuth, SvcToken, $location, $stateParams, $mdToast){
		$scope.title = "Selamat Datang!";
		$scope.data = {};

		$scope.init = function(){
			if(SvcToken.get().loggedIn){
				$location.path('/home');
			}

			$scope.data.email = "";
			$scope.data.password = "";
			$scope.data.fullname = "";

			if($stateParams){
				$scope.data.email = $stateParams.email;
				$scope.data.fullname = $stateParams.fullname;
			}
		};

		$scope.init();

		$scope.$on('displayError', function(event, mass){
			$mdToast.show(
				$mdToast.simple()
					.content(mass)
					.position('bottom right')
					.hideDelay(3000)
			);
			$scope.init();
		});

		this.login = function () {
			if($scope.data.email && $scope.data.password){
				SvcAuth.login($scope.data)
					.then(function (result) {
						if(SvcToken.get().loggedIn){
							$location.path('/home');
						}
						if(!result.data.token){
							$scope.$broadcast('displayError', 'E-Mail atau Password Salah!');
						}
					})
					.catch(function (error) {
						console.log(error);
					});
			}
		};

		this.register = function() {
			if($scope.data.email && $scope.data.fullname && $scope.data.password){
				SvcAuth.register($scope.data)
					.then(function(result){
						if(result.data.add_user){
							$location.path('/register-complete/' + result.data.fullname +'/' + result.data.email);
						} else{
							$scope.$broadcast('displayError', 'E-Mail sudah terdaftar!');
						}
					})
					.catch(function (error) {
						console.log(error);
					});
			}
		};
	};
	app.controller(name, dependencies.concat(controller));
});