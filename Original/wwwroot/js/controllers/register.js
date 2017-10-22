(function () {
    angular.module('pipeline').controller('RegistrationController', ['$scope', '$http', '$mdToast', '$window', '$cookies', '$state', '$rootScope', '$location', 'spinnerModal', 'termsofserviceModal', 'genericModal',
        function ($scope, $http, $mdToast, $window, $cookies, $state, $rootScope, $location, spinnerModal, termsofserviceModal, genericModal) {

            $rootScope.tModal;

            $scope.termsofserviceCheck = false;

            $scope.registration = {};
            resetResgistrationModel();
            $scope.errors = '';
            $scope.registration.status = "New";
            $scope.registration.ztype = 'individual';

            $scope.toggleTermsofServiceCheck = function () {
                tModal.close();
                $scope.termsofserviceCheck = !$scope.termsofserviceCheck;
            }     

            $scope.desktopMode = function () {
                return $window.innerWidth > 800;
            }

            $scope.$on('$viewContentLoaded', function () {
                var url = $location.url().split('?')[1];
                var postMethod = url.slice(0, 5);


                if (postMethod == "Verif") {
                    $http.post('account/validate?' + url).then(
                    function (response, status) { // on success
                        if (response.data.Succeeded) {
                            if (window.innerWidth < 800) {
                                $mdToast.show($mdToast.simple().textContent('Your email has validated successfully!'));
                            } else {
                                var x = genericModal('', 'Your email was validated successfully!');
                            }
                            $state.go("login");
                        }
                        else if (response && response.data && response.data.Errors) {
                            for (var i = 0; i < response.data.Errors.length; i++) {
                                $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                                if (window.innerWidth < 800) {
                                    $mdToast.show($mdToast.simple().textContent('Your email failed to validate!'));
                                } else {
                                    var x = genericModal('', 'Your email failed to validate!');
                                }
                            }
                        }
                    },
                    function (error, status) { // on error
                        console.log(error);
                    });
                }
                // check to ensure an email and code is entered
                else if (typeof url !== "undefined") {
                    var sModal = spinnerModal();

                    $http.post('account/propogate?' + url).then(
                    function (response, status) { // on success
                        if (response.data.Succeeded)
                        {
                            // general registration fields
                            $scope.registration.email = response.data.Email || '';
                            $scope.registration.ztype = response.data.UserType || '';

                            // individual
                            $scope.registration.firstname = response.data.FirstName || '';
                            $scope.registration.middlename = response.data.MiddleName || '';
                            $scope.registration.lastname = response.data.LastName || '';

                            // organization
                            $scope.registration.organization = response.data.OrganizationName || '';
                        }
                        else if(response.data.Message === "Invalid") {
                            $scope.registration.status = "Invalid";
                        }
                        else if (response.data.Messege === "Expired") {
                            $scope.registration.status = "Expired";
                        }
                        else if (response && response.data && response.data.Errors) {
                            for (var i = 0; i < response.data.Errors.length; i++) {
                                $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                            }
                        }

                        sModal.close();
                    },
                    function (error, status) { // on error
                        console.log(error);
                        sModal.close();
                    });
                }
                else
                {
                    $state.go("home");
                }
            });

            $rootScope.closeMe = function () {
               this.$close();
            };

            $scope.toggleTermsofServiceCheck = function () {
                $scope.termsofserviceCheck = !$scope.termsofserviceCheck;
            }
            
            $scope.submitRegistration = function (form) {
                if (!form.$valid) {
                    angular.forEach(form.$error, function (field) {
                        angular.forEach(field, function (errorField) {
                            errorField.$setTouched();
                        })
                    });
                    return;
                }

                if (!$scope.passwordsMatch()) 
                {
                    return false;
                }


                $rootScope.tModal = termsofserviceModal().then(function () {
                    var sModal = spinnerModal();

                    $scope.errors = '';

                    var data = 'FirstName=' + $scope.registration.firstname || '';
                    data += '&MiddleName=' + $scope.registration.middlename || '';
                    data += '&LastName=' + $scope.registration.lastname || '';
                    data += '&Email=' + $scope.registration.email;
                    data += '&Password=' + $scope.registration.password;
                    data += '&Organization=' + $scope.registration.organization || '';
                    data += '&Type=' + $scope.registration.ztype;

                    $http.post('account/register?' + data).
                        then(function successCallback(response) {
                            if (response && response.data.Succeeded) {
                                if (window.innerWidth < 800) {
                                    $mdToast.show($mdToast.simple().textContent('Verify your account before logging in'));
                                } else {
                                    var x = genericModal('', 'Verify your account before logging in');
                                }
                                $state.go("top");
                                resetResgistrationModel();
                            }
                            else if (response && response.status == 500) {
                                $scope.errors += '* ' + 'There was an error with the server.  Try again later.' + '\n';
                            }
                            else if (response && response.data && response.data.Errors) {
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
                        })
                    .catch(function () {


                    });
                });
            }

            $scope.passwordsMatch = function () {
                return $scope.registration.password === $scope.registration.confirmpassword;
            }

            function resetResgistrationModel() {
                $scope.registration = {};

                $scope.registration.firstname = '';
                $scope.registration.middlename = '';
                $scope.registration.lastname = '';
                $scope.registration.organization = '';
                $scope.registration.ztype = 'individual';

                $scope.errors = '';
            }

            $rootScope.closeModal = function () {
                this.$close();
            };
        }
    ]);
})();