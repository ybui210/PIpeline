angular.module('pipeline').service('spinnerModal', ['$uibModal', '$rootScope', function ($uibModal, $rootScope) {

    return function () {
        var instance = $uibModal.open({
            templateUrl: 'views/templates/spinner.html',
            windowClass: 'center-modal',
            windowTopClass: 'spinner-modal-top',
            backdrop  : 'static',
            keyboard  : false
        });

        return instance;
    };
}]);