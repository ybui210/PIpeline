(function () {
    angular.module('pipeline').controller('ListingsController', ['$rootScope', '$scope', '$http', 'listingTypeModal', '$window', '$mdToast',  '$state', '$cookies', 'genericModal',
        function ($rootScope, $scope, $http, listingTypeModal, $window, $mdToast, $state, $cookies, genericModal) {
            var self = this;
            $scope.listings = [];
            
            $scope.$watch('$viewContentLoaded', function () {
                listingTypeModal();
            });

            $scope.$on('listingTypeSelected', function (event, type) {
                $scope.listings = [];

                if (type === 'investments') {
                    $scope.getInvestmentListings();
                    $scope.title = 'INVESTMENT OPPORTUNITIES';
                }
                else if (type === 'finances') {
                    $scope.getFinancingListings();
                    $scope.title = 'INVESTORS'
                }
            });

            function showStartDialog() {
                var simple = $mdToast.simple().textContent('Swipe left for next listing. Swipe right to save listing.').action("OK");
                simple._options.hideDelay = 8000;

                $mdToast.show(simple);
            }

            $scope.getInvestmentListings = function () {
                $http.post('/listing/allinvestments?email=' + $rootScope.currentUser.email).then(
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
                            var toast = $mdToast.simple().textContent("Error occurred attempting to retrieve listings");

                            if ($window.innerWidth > 800) {
                                toast._options.position = 'bottom right';
                            }

                            $mdToast.show(toast);
                        }
                    },
                    function (response) {
                        var toast = $mdToast.simple().textContent("Error occurred attempting to retrieve listings");

                        if ($window.innerWidth > 800) {
                            toast._options.position = 'bottom right';
                        }

                        $mdToast.show(toast);
                    }
                );
            };

            $scope.getFinancingListings = function () {
                $http.post('/listing/allfinances?email=' + $rootScope.currentUser.email).then(
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
                            var toast = $mdToast.simple().textContent("Error occurred attempting to retrieve listings");

                            if ($window.innerWidth > 800) {
                                toast._options.position = 'bottom right';
                            }

                            $mdToast.show(toast);
                        }
                    },
                    function (response) {
                        var toast = $mdToast.simple().textContent("Error occurred attempting to retrieve listings");

                        if ($window.innerWidth > 800) {
                            toast._options.position = 'bottom right';
                        }

                        $mdToast.show(toast);
                    }
                );
            };

            $scope.showCardStack = function () {
                return $window.innerWidth < 800;
            }

            $scope.saveListing = function (index) {
                var listing = $scope.listings[index];
                if ($scope.showCardStack()) {
                    $scope.listings.splice(index, 1);
                }

                var data = {
                    Email: $cookies.getObject('user').email,
                    ListingId: listing.listing.ID
                };

                $http.post('/listing/savelisting', data).then(
                    function (response) {
                        if (response.data && response.data.Succeeded) {

                            var toast = $mdToast.simple().textContent('Listing Saved');

                            if ($window.innerWidth > 800) {
                                toast._options.position = 'bottom right';
                            }
                            listing.saved = true;
                            $mdToast.show(toast);
                        }
                        else if (response.data && response.data.Errors) {
                            var toast = $mdToast.simple().textContent(response.data.Errors[0].Description);

                            if ($window.innerWidth > 800) {
                                toast._options.position = 'bottom right';
                            }

                            if ($scope.showCardStack()) {
                                $scope.listings.push(listing);
                            }

                            $mdToast.show(toast);
                        }
                        else {
                            var toast = $mdToast.simple().textContent("Error occurred attempting to save listing");

                            if ($window.innerWidth > 800) {
                                toast._options.position = 'bottom right';
                            }

                            if ($scope.showCardStack()) {
                                $scope.listings.push(listing);
                            }

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

                        if ($scope.showCardStack()) {
                            $scope.listings.push(listing[0]);
                        }
                    }
                );
            };

            $scope.nextListing = function (index, event) {
                var listing = $scope.listings.splice(index, 1);
                if ($scope.listings.length === 0) {
                    $scope.$apply();
                }
            };

            $scope.openListingDetail = function (id) {
                $state.go("dashboard.listing", { "listingId": id });
            }


            $rootScope.closeModal = function () {
                this.$close();
            };
        }
    ]);
})();

