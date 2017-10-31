(function () {
    angular.module('pipeline').controller('MyListingsController', ['$scope', '$http', '$cookies', '$state', '$mdToast', '$window',
        function ($scope, $http, $cookies, $state, $mdToast, $window) {
            $scope.listings = [];

            $scope.$watch('$viewContentLoaded', function () {
                $scope.getMyListings();
            });

            $scope.showCardStack = function () {
                return $window.innerWidth < 800;
            }

            function showStartDialog() {
                var simple = $mdToast.simple().textContent('Swipe left or right for next listing.').action("OK");
                simple._options.hideDelay = 10000;

                $mdToast.show(simple);
            }

            $scope.nextListing = function (index, event) {
                var listing = $scope.listings.splice(index, 1);
                if ($scope.listings.length === 0) {
                    $scope.$apply();
                }
            };

            $scope.getMyListings = function () {
                $http.post('/listing/getuserlistings?email=' + $cookies.getObject('user').email).then(
                    function (response) {
                        if (response.data && response.data.Succeeded) {
                            $scope.listings = response.data.Listings;

                            if ($window.innerWidth < 800) {
                                showStartDialog();
                            }
                        }
                        else if (response.data && response.data.Errors) {
                            var toast = $mdToast.simple().textContent(response.data.Errors[0].Description);

                            if ($window.innerWidth > 800) {
                                toast._options.position = 'bottom right';
                            }

                            $mdToast.show(toast);
                        }
                        else {
                            var toast = $mdToast.simple().textContent("Error occurred attempting to retrieve your listings");

                            if ($window.innerWidth > 800) {
                                toast._options.position = 'bottom right';
                            }

                            $mdToast.show(toast);
                        }
                    },
                    function (response) {

                    }
                );
            };

            $scope.deleteListing = function (index) {
                var listing = $scope.listings[index];
                $scope.listings.splice(index, 1);


                var data = {
                    Email: $cookies.getObject('user').email,
                    ListingId: listing.listing.ID
                };

                $http.post('/listing/deletelisting', data).then(
                     function (response) {
                         if (response.data && response.data.Succeeded) {
                             var toast = $mdToast.simple().textContent('Listing Deleted');

                             if ($window.innerWidth > 800) {
                                 toast._options.position = 'bottom right';
                             }

                             $mdToast.show(toast);
                         }
                         else if (response.data && response.data.Errors) {
                             var toast = $mdToast.simple().textContent(response.data.Errors[0].Description);

                             if ($window.innerWidth > 800) {
                                 toast._options.position = 'bottom right';
                             }

                             $scope.listings.push(listing);

                             $mdToast.show(toast);
                         }
                         else {
                             var toast = $mdToast.simple().textContent("Error occurred attempting to delete listing");

                             if ($window.innerWidth > 800) {
                                 toast._options.position = 'bottom right';
                             }

                             $scope.listings.push(listing);

                             $mdToast.show(toast);
                         }
                     },
                     function (response) {
                         if (response.data && response.data.Errors) {
                             var toast = $mdToast.simple().textContent(response.data.Errors[0].Description);

                             if ($window.innerWidth > 800) {
                                 toast._options.position = 'bottom right';
                             }

                             $mdToast.show(toast);
                         }
                         else {
                             var toast = $mdToast.simple().textContent("Error occurred attempting to delete listing");

                             if ($window.innerWidth > 800) {
                                 toast._options.position = 'bottom right';
                             }

                             $mdToast.show(toast);
                         }

                         $scope.listings.push(listing);
                     }
                );
            };

            $scope.openListingDetail = function (id) {
                $state.go("dashboard.listing", { "listingId": id });
            };

            $scope.editListing = function (id) {
                $state.go('dashboard.edit', { "listingId": id});
            }
        }
    ]);
})();

