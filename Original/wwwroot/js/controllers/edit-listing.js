(function () {
    angular.module('pipeline').controller('EditListingController', ['$scope', '$http', 'spinnerModal', '$stateParams',
        function ($scope, $http, spinnerModal, $stateParams) {

            $scope.jurisdictions = [
                { id: 1, name: 'Canada' },
                { id: 2, name: 'USA' },
                { id: 3, name: 'Middle East' },
                { id: 4, name: 'Africa' },
                { id: 5, name: 'Australia' },
                { id: 6, name: 'South America' },
                { id: 7, name: 'Asia' },
                { id: 8, name: 'Mexico' }
            ];

            $scope.investmenttypes = [
                { id: 1, name: 'Business for Sale' },
                { id: 2, name: 'Joint Partnership' },
                { id: 3, name: 'Public Equity' },
                { id: 4, name: 'Private Equity' },
            ];

            $scope.listing = {};
            $scope.categories = [];

            $http.get("/industrycategories/all").then(function (response) {
                for (var i = 0; i < response.data.length; i++) {
                    $scope.categories.push({
                        id: response.data[i].ID,
                        name: response.data[i].Category
                    })
                }
            });

            $scope.$on('$viewContentLoaded', function () {
                var modal = spinnerModal();

                $http.post('/listing/find?ID=' + $stateParams.listingId).then(
                    function (response) {
                        if (response.data && response.data.Succeeded) {
                            $scope.listing = response.data.Listing;
                            $scope.listing.StartDate = new Date($scope.listing.StartDate);
                            $scope.listing.EndingDate = new Date($scope.listing.EndingDate);
                            $scope.listing.type = $scope.listing.HighestCapital ? 'finance' : 'investment';
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

            $scope.editListing = function (form) {
                if (!form.$valid) {
                    angular.forEach(form.$error, function (field) {
                        angular.forEach(field, function (errorField) {
                            errorField.$setTouched();
                        })
                    });
                    return;
                }

                var ed = $scope.listing.enddate;
                var enddate = ed.getDate() + '-'
                enddate += ed.getMonth() < 10 ? '0' + (ed.getMonth() + 1) : ed.getMonth() + 1;
                enddate += '-' + ed.getFullYear();

                var sd = $scope.listing.enddate;
                var startdate = sd.getDate() + '-'
                startdate += sd.getMonth() < 10 ? '0' + (sd.getMonth() + 1) : sd.getMonth() + 1;
                startdate += '-' + sd.getFullYear();

                var sModal = spinnerModal();

                $scope.errors = "";

                var data = {
                    ID: $scope.listing.ID,
                    Title: $scope.listing.title,
                    Summary: $scope.listing.summary,
                    Description: $scope.listing.description,
                    Jurisdiction: $scope.listing.jurisdiction.name,
                    Category: $scope.listing.category.name,
                    StartDate: startdate,
                    EndDate: enddate,
                    Email: $scope.listing.email,
                    User: $scope.listing.user,
                    FirstName: $scope.listing.firstname,
                    MiddleName: $scope.listing.middlename,
                    LastName: $scope.listing.lastname,
                    MainPhone: $scope.listing.mainphone,
                    SecondPhone: $scope.listing.secondphone,
                    Contact: $scope.listing.contact,
                    Type: $scope.listing.type,
                    LowestCapital: $scope.listing.lowest,
                    HighestCapital: $scope.listing.highest,
                    SeekPrice: $scope.listing.price,
                    InvestmentType: $scope.listing.investmenttype
                };

                $http.post('listing/editlisting', data).then(
                    function successCallback(response) {
                        if (response.data && response.data.Succeeded) {
                            process(response.data.Listing.ID, function () {
                                resetListingModel();
                                $rootScope.selectItem('');
                                $scope.$apply();
                                $state.go("dashboard.listing", { "listingId": response.data.Listing.ID });
                            });
                        }
                        else if (response.data && response.data.Errors) {
                            for (var i = 0; i < response.data.Errors.length; i++) {
                                $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                            }
                        }

                        sModal.close();

                    }, function errorCallback(response) {
                        if (response && response.data && response.data.Errors) {
                            for (var i = 0; i < response.data.Errors.length; i++) {
                                $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                            }
                        }
                        sModal.close();
                    });
                sModal.close();
            };

        }
    ]);
})();

