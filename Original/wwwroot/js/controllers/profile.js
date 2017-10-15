(function () {
    angular.module('pipeline').controller('ProfileController', ['$rootScope', '$scope', '$http', 'spinnerModal', 'changePasswordModal',
        function ($rootScope, $scope, $http, spinnerModal, changePasswordModal) {
        
        $scope.myProfile = {};
        $scope.errors = '';

        $scope.changePassword = function () {
            $scope.cpModal = changePasswordModal();
        }

        $scope.$watch('$viewContentLoaded', function () {
            var modal = spinnerModal();
            $scope.myProfile = {};
            $scope.errors = '';

            var url = '/profiles/find?email=' + $rootScope.currentUser.email;

            $scope.states = ('AL AK AZ AR CA CO CT DE FL GA HI ID IL IN IA KS KY LA ME MD MA MI MN MS ' +
                'MO MT NE NV NH NJ NM NY NC ND OH OK OR PA RI SC SD TN TX UT VT VA WA WV WI ' +
                'WY').split(' ').map(function (state) {
                    return { abbrev: state };
                })

            $scope.provinces = ('AB BC MB NB NL NT NS NU ON PE QC SK YT').split(' ').map(function (provinces) {
                return { abbrev: provinces };
            })

            $http.post(url).then(
                function (response) {
                    if (response.data && response.data.Succeeded) {
                        $scope.myProfile = response.data;
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

        $scope.saveChanges = function (form) {
            var modal = spinnerModal();
            var url = '/profiles/edit?';
            url += 'Email=' + $scope.myProfile.Email;
            url += '&FirstName=' + $scope.myProfile.FirstName;
            url += '&LastName=' + $scope.myProfile.LastName;
            url += '&MiddleName=' + $scope.myProfile.MiddleName;
            url += '&OrganizationName=' + $scope.myProfile.OrganizationName;
            url += '&Bio=' + $scope.myProfile.Bio;
            url += '&Street1=' + $scope.myProfile.Street1;
            url += '&Street2=' + $scope.myProfile.Street2;
            url += '&City=' + $scope.myProfile.City;
            url += '&ZipPostal=' + $scope.myProfile.ZipPostal;
            url += '&StateProvince=' + $scope.myProfile.StateProvince;
            url += '&Country=' + $scope.myProfile.Country;
            url += '&MainPhone=' + $scope.myProfile.MainPhone;
            url += '&SecondPhone=' + $scope.myProfile.SecondPhone;

            $http.post(url).then(
                function (response) {
                    if (response.data && response.data.Succeeded) {
                        // Open Success modal here
                        // No generic modal built yet so just do alert dialogue for now
                        form.$setPristine();
                    }
                    else if (response.data && response.data.Errors) {
                        for (var i = 0; i < resp.data.Errors.length; i++) {
                            $scope.errors += '* ' + resp.data.Errors[i].Description + '\n';
                        }
                        // Remove this alert with a modal dialogue later
                        alert('Save failed');
                    }

                    modal.close();
                },
                function (response) {
                    if (response.data && response.data.Errors) {
                        for (var i = 0; i < resp.data.Errors.length; i++) {
                            $scope.errors += '* ' + resp.data.Errors[i].Description + '\n';
                        }
                    }

                    modal.close();
                }
            );
        };
    }]);
})();