(function () {
    angular.module('pipeline').controller('SelectListingTypeController', ['$scope', '$rootScope',
        function ($scope, $rootScope) {
            $scope.chooseType = function (type) {
                $scope.$close(type);
                $rootScope.$broadcast('listingTypeSelected', type);
            };
        }
    ]);
})();