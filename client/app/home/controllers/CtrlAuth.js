define(['../app.home'], function(app){
		'use strict';

		var name = 'CtrlAuth';
		var dependencies = ['$scope', 'SvcAuth', 'SvcToken', '$location', '$stateParams', '$mdToast'];
		var controller = function($scope, SvcAuth, SvcToken, $location, $stateParams, $mdToast){
			$scope.title = "Selamat Datang!";
			this.data = {};

			this.init = function(){
				if(SvcToken.get().loggedIn){
					$location.path('/home');
				}

				this.data.email = "";
				this.data.password = "";
				this.data.fullname = "";

				if($stateParams){
					this.data.email = $stateParams.email;
					this.data.fullname = $stateParams.fullname;
				}
			}

            this.showError = function(message) {
			    $mdToast.show(
			    	$mdToast.simple()
			        	.content(message)
			        	.position($scope.getToastPosition())
			        	.hideDelay(3000)
			    );
		  	};

			this.login = function () {
                if(this.data.email && this.data.password){
                    SvcAuth.login(this.data)
                        .then(function (result) {
							if(SvcToken.get().loggedIn){
								$location.path('/home');
							} 
							if(!result.data.token){
        						this.showError("E-Mail atau Password Salah!");
        						this.data.email = "";
        						this.data.password = "";
							}
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            };

            this.register = function() {
            	if(this.data.email && this.data.fullname && this.data.password){
            		SvcAuth.register(this.data)
            			.then(function(result){
        					if(result.data.add_user){
        						$location.path('/register-complete/' + result.data.fullname +'/' + result.data.email);
        					} else{
        						this.showError("E-Mail sudah terdaftar!");
        						this.data.email = "";
        						this.data.password = "";
        					}
            			})
                        .catch(function (error) {
                            console.log(error);
                        });
            	}
            }

            this.init();
		} 
		app.controller(name, dependencies.concat(controller));
	})