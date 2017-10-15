(function () {
    angular.module('pipeline').controller('CreateListingController', ['$scope', '$cookies', '$state', '$http', '$rootScope', '$log', '$location', 'spinnerModal', '$mdToast', '$window',
    function ($scope, $cookies, $state, $http, $rootScope, $log, $location, spinnerModal, $mdToast, $window) {

            var self = this;

            $scope.listing = {};
            $scope.categories = [];
            $scope.emptyimage = false;

            $http.get("/industrycategories/all").then(function (response) {
                for (var i = 0; i < response.data.length; i++) {
                    $scope.categories.push({
                        id: response.data[i].ID,
                        name: response.data[i].Category
                    })
                }

                $scope.listing.category = $scope.categories[0];
            });

            $http.post('/profiles/find?email=' + $rootScope.currentUser.email).then(
               function (response) {
                   if (response.data && response.data.Succeeded) {
                       $scope.userContactInfo = response.data;
                       $scope.toggleContactInfo();
                   }
                   else if (response.data && response.data.Errors) {
                       for (var i = 0; i < resp.data.Errors.length; i++) {
                           $scope.errors += '* ' + resp.data.Errors[i].Description + '\n';
                       }
                   }
               },
               function (response) {
                   if (response.data && response.data.Errors) {
                       for (var i = 0; i < resp.data.Errors.length; i++) {
                           $scope.errors += '* ' + resp.data.Errors[i].Description + '\n';
                       }
                   }
               }
           );

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

            $scope.listing.jurisdiction = $scope.jurisdictions[0];
            $scope.listing.startdate = new Date();
            $scope.listing.enddate = new Date();
            $scope.listing.contact = true;
            $scope.listing.type = 'investment';
            $scope.listing.user = $rootScope.currentUser.email;
            $scope.listing.investmenttype = $scope.investmenttypes[0].name;

            self.dropzoneConfig = {
                autoProcessQueue: false,
                parallelUploads: 100,
                maxFileSize: 5,
                paramName: 'img',
                enctype: 'multipart/form-data',
                url: '/listing/uploadimage'
            };  

            self.dzAddedFile = function (file) {
                $scope.emptyimage = true;
            };

            $scope.toggleContactInfo = function () {
                if ($scope.listing.contact) {
                    $scope.listing.email = $scope.userContactInfo.Email;
                    $scope.listing.firstname = $scope.userContactInfo.FirstName;
                    $scope.listing.lastname = $scope.userContactInfo.LastName;
                    $scope.listing.middlename = $scope.userContactInfo.MiddleName;
                    $scope.listing.mainphone = parseInt($scope.userContactInfo.MainPhone);
                    $scope.listing.secondphone = parseInt($scope.userContactInfo.SecondPhone);
                }
                else {
                    $scope.listing.email = '';
                    $scope.listing.firstname = '';
                    $scope.listing.lastname = '';
                    $scope.listing.middlename = '';
                    $scope.listing.mainphone = '';
                    $scope.listing.secondphone = '';
                }
            };

            $scope.createListing = function (form) {
                if ($scope.emptyimage) {
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

                    $http.post('listing/create', data).then(
                        function successCallback(response) {
                            if (response.data && response.data.Succeeded) {
                                process(response.data.Listing.ID, function () {
                                    resetListingModel();
                                    //$rootScope.selectItem('');
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
                } else {
                    var toast = $mdToast.simple().textContent("Images are required to create the form");

                    if ($window.innerWidth > 800) {
                        toast._options.position = 'bottom right';
                    }

                    $mdToast.show(toast);
                }
            };

            function process(guid, callback) {
                self.dropzone2.options.url = '/listing/uploadimage?Id=' + guid;

                self.dropzone2.on('queuecomplete', function () {
                    callback();
                    self.dropzone2.removeAllFiles();
                });

                self.dropzone2.processQueue();
            }

            function resetListingModel() {
                $scope.listing = {};

                $scope.listing.email = '';
                $scope.listing.firstname = '';
                $scope.listing.lastname = '';
                $scope.listing.middlename = '';
                $scope.listing.mainphone = '';
                $scope.listing.secondphone = '';

                $scope.listing.title = '';
                $scope.listing.summary = '';
                $scope.listing.description = '';
                $scope.listing.category = '';

                $scope.listing.price = '';
                $scope.listing.investmenttype = '';
                $scope.listing.lowest = '';
                $scope.listing.highest = '';

                $scope.listing.jurisdiction = $scope.jurisdictions[0];
                $scope.listing.startdate = new Date();
                $scope.listing.enddate = new Date();
                $scope.listing.contact = true;
                $scope.listing.type = 'investment';
                $scope.listing.user = $rootScope.currentUser.email;
                $scope.listing.investmenttype = $scope.investmenttypes[0].name;

                $scope.errors = '';
            }
        }
    ]);
})();
