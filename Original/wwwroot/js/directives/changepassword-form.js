angular.module('pipeline').directive('changepasswordForm', function () {
    return {
        restrict: 'E',
        templateUrl: 'views/templates/changepassword-form.html',
        controller: 'ChangePasswordController',
        controllerAs: 'ChangePasswordCtrl'
    }
});