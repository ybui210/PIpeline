angular.module('pipeline').service('termsofserviceModal', ['$uibModal', '$rootScope', function ($uibModal, $rootScope) {

    return function () {
        var instance = $uibModal.open({
            templateUrl: 'views/templates/termsofservice.html',
            controller: 'RegistrationController',
            controllerAs: 'registrationCtrl',
            windowClass: 'center-modal-wide',
            windowTopClass: 'termsofservice-modal',
            backdrop: 'static',
            keyboard: false
        });

        return instance.result;
    };
}]);