angular.module('pipeline').service('listingTypeModal', ['$uibModal', function ($uibModal) {

    return function () {

        var instance = $uibModal.open({
            templateUrl: 'views/templates/listing-type-selection-modal.html',
            controller: 'SelectListingTypeController',
            controllerAs: 'selectListingTypeCtrl',
            windowClass: 'center-modal',
            windowTopClass: 'dialog-modal',

        });

        return instance.result;
    };
}]);