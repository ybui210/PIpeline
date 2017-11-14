(function() {
    angular.module('pipeline').controller('ListingDetailsController', ['$rootScope', '$scope', '$http', '$stateParams', 'spinnerModal', 'Lightbox',
        function ($rootScope, $scope, $http, $stateParams, spinnerModal, Lightbox) {

            $scope.listing = {};

            $scope.direction = 'left';
            $scope.currentIndex = 0;
            $scope.blurContact = function () {
                return true;
            }

            $scope.setCurrentSlideIndex = function (index) {
                $scope.direction = (index > $scope.currentIndex) ? 'left' : 'right';
                $scope.currentIndex = index;
            };

            $scope.isCurrentSlideIndex = function (index) {
                return $scope.currentIndex === index;
            };

            $scope.prevSlide = function () {
                $scope.direction = 'left';
                $scope.currentIndex = ($scope.currentIndex < $scope.slides.length - 1) ? ++$scope.currentIndex : 0;
            };

            $scope.nextSlide = function () {
                $scope.direction = 'right';
                $scope.currentIndex = ($scope.currentIndex > 0) ? --$scope.currentIndex : $scope.slides.length - 1;
            };

            $scope.$on('$viewContentLoaded', function () {
                var modal = spinnerModal();

                $http.post('/listing/find?ID=' + $stateParams.listingId).then(
                    function (response) {
                        if (response.data && response.data.Succeeded) {
                            $scope.listing = response.data.Listing;
                        }
                        else if (response.data && response.data.Errors) {
                            for (var i = 0; i < response.data.Errors.length; i++) {
                                $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                            }
                        }
                        modal.close();
                    },
                    function (response) {
                        if (response.data && response.data.Errors) {
                            for (var i = 0; i < response.data.Errors.length; i++) {
                                $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                            }
                        }
                        modal.close();
                    }
                );
            });


            $scope.openLightboxModal = function (index) {
                Lightbox.openModal($scope.listing.images, index);
            };
        }
    ]);
})();