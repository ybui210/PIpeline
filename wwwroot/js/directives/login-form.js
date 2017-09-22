angular.module('pipeline').directive('loginForm', function () {
    return {
        restrict: 'E',
        templateUrl: 'views/templates/login-form.html',
        controller: 'LoginController',
        controllerAs: 'loginCtrl'
    }
});