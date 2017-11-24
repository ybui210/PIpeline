(function() {
    angular.module('pipeline').controller('HeaderController', ['$rootScope', '$scope', '$state',
        function ($rootScope, $scope, $state) {
            $scope.isActive = function (viewLocation) {
                return $state.is(viewLocation);
            };
        }
    ]);
})();