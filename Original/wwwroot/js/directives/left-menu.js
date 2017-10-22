(function () {
    angular.module('pipeline').directive('leftMenu', function () {
        return {
            restrict: 'E',
            templateUrl: '/views/shared/left-menu.html',
            controller: 'LeftMenuController'
        }
    });
})();
