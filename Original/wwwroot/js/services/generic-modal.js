angular.module('pipeline').service('genericModal', ['$uibModal', '$rootScope', function ($uibModal, $rootScope) {

    //===how to use:===
    //*MUST INCLUDE
    //
    //constructor:
    //
    //var x = genericModal(<title goes here>, <body goes here>);
    //
    //include closeModal method:
    //
    //$rootScope.closeModal = function () {
    //    this.$close();
    //};
    //
    //inject '$rootScope' and 'genericModal'

    return function (title, body) {
        var instance = $uibModal.open({
            templateUrl: 'views/templates/generic-modal.html',
            windowClass: 'center-modal',
            windowTopClass: 'dialog-modal',
        });
        $rootScope.title = title;
        $rootScope.body = body;

        return instance.result;
    }
}]);