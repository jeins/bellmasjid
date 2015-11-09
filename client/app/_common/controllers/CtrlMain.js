define(['../app.common'], function(app){
		'use strict'

		var name = 'CtrlMain';
		var dependencies = ['$rootScope', 'SvcToken', '$location'];
		var controller = function($rootScope, SvcToken, $location){
			this.isLogin = function(){
				if(SvcToken.get().loggedIn){
					return true;
				}
				return false;
			};

            this.logout = function() {
            	SvcToken.reset();
				$location.path('/login');
            }
		} 
		app.controller(name, dependencies.concat(controller));
	})