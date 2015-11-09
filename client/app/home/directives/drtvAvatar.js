define(['../app.home'],
    function (app) {
        var name = 'userAvatar';
        var dependencies = [];
        var directive = function () {
            return {
                replace: true,
                templateUrl: 'app/home/directives/userAvatar.html'
            };
        };
        app.directive(name, dependencies.concat(directive));
    });