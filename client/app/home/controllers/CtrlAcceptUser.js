define(['../app.home'], function(app){
    'use strict';

    var name = 'CtrlAcceptUser';
    var dependencies = ['$scope', 'SvcUsers'];
    var controller = function($scope, SvcUsers){
        $scope.title = "Pending Users";
        $scope.users = {};
        $scope.total_users = 0;

        this.init = function(){
            SvcUsers.getPendingUsers()
                .then(function(result){console.log(result);
                    if(result.new_user){
                        $scope.users = result.users;
                        $scope.total_users = result.total_users;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
        this.init();
    };
    app.controller(name, dependencies.concat(controller));
});