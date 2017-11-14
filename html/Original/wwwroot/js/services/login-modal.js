angular.module('pipeline').service('loginModal', ['$uibModal', '$rootScope', function ($uibModal, $rootScope) {

    return function () {
        var instance = $uibModal.open({
            templateUrl: 'views/templates/login-form.html',
            controller: 'LoginController',
            controllerAs: 'loginCtrl',
            windowClass: 'center-modal'
        });

        return instance.result;
    };
}]);