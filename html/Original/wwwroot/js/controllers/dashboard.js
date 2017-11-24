(function () {
    angular.module('pipeline').controller('DashboardController', ['$rootScope', '$scope', '$state', '$localStorage',
        function ($rootScope, $scope, $state, $localStorage) {
            $scope.isSelected = function (selection) {
                return $rootScope.leftMenuSelection === selection;
            }
    }]);
})();