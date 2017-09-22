angular.module('pipeline').service('changePasswordModal', ['$uibModal', '$rootScope', function ($uibModal, $rootScope) {

    return function () {
        var instance = $uibModal.open({
            templateUrl: 'views/templates/changepassword-form.html',
            controller: 'ChangePasswordController',
            controllerAs: 'ChangePasswordCtrl',
            windowClass: 'center-modal'
        });

        return instance.result;
    };
}]);