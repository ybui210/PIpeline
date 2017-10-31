(function() {
    angular.module('pipeline').controller('LoginController', ['$scope', '$state', 'authentication', 'genericModal', '$rootScope', '$mdToast', '$window', 
        function ($scope, $state, authentication, genericModal, $rootScope, $mdToast, $window ) {

            $scope.errors = '';
            $scope.login = {};

            $scope.submitLogin = function login(form) {
                if (!form.$valid) {
                    angular.forEach(form.$error, function (field) {
                        angular.forEach(field, function (errorField) {
                            errorField.$setTouched();
                        })
                    });
                    return;
                }

                $scope.errors = '';

                function successCallback(response) {
                    if (response.data && response.data.Succeeded && response.data.Confirmed) {
                        $state.go("dashboard");

                        // Close login modal if it's open
                        if(typeof $scope.$close !== 'undefined') {
                            $scope.$close();
                        }
                    } else if (response.data && response.data.Succeeded && !response.data.Confirmed) {
                        if (window.innerWidth < 800) {
                            $mdToast.show($mdToast.simple().textContent('You need to confirm your email before logging in.'));
                        } else {
                            var x = genericModal('', 'You need to confirm your email before logging in.');
                        }
                        $state.go("home");
                        // Close login modal if it's open
                        if (typeof $scope.$close !== 'undefined') {
                            $scope.$close();
                        }
                    }
                    else {
                        $scope.errors += '* ' + 'Invalid email or password' + '\n';

                        if (response.data && response.data.Errors) {
                            for (var i = 0; i < response.data.Errors.length; i++) {
                                $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                            }
                        }
                    }
                }

                function errorCallback(response) {
                    $scope.errors += '* Connecting to the server failed. Check your internet connection or try again later.\n';
                }

                authentication.login(
                    $scope.login.email,
                    $scope.login.password, 
                    $scope.login.rememberme || false,
                    successCallback,
                    errorCallback
                );
            }

            $rootScope.closeModal = function () {
                this.$close();
            }

            function resetLogin() {
                $scope.login = {};
                $scope.errors = '';
            }

            $rootScope.desktopMode = function () {
                return $window.innerWidth > 800;
            }
        }
    ]);
})();