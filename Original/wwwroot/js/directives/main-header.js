angular.module('pipeline').directive('mainHeader', function() {
    return {
        restrict: 'E',
        templateUrl: '/views/shared/header.html',
        controller: 'HeaderController',
        controllerAs: 'headerCtrl'
    };
});