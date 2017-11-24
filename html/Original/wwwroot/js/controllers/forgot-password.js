(function () {
    angular.module('pipeline').controller('ForgotPasswordController', ['$scope', '$http', '$mdToast', '$window', '$cookies', '$state', '$rootScope', '$location', 'spinnerModal', 'genericModal', '$mdToast', '$window',
        function ($scope, $http, $mdToast, $window, $cookies, $state, $rootScope, $location, spinnerModal, genericModal, $mdToast, $window) {

            $rootScope.tModal;
            var sModal;
           

            $scope.submitForgot = function (form) {
                sModal = spinnerModal();
                $scope.errors = '';
                if (!form.$valid) {
                    angular.forEach(form.$error, function (field) {
                        angular.forEach(field, function (errorField) {
                            errorField.$setTouched();
                        })
                    });
                    return;
                }

                var data = 'Email=' + $scope.forgotpwform.email;

                $http.post('/account/resetpw?' + data).
                   then(function successCallback(response) {
                       if (response && response.data.Succeeded) {
                           if (window.innerWidth < 800) {
                               $mdToast.show($mdToast.simple().textContent('Instructions to reset your password has been sent to your email.'));
                           } else {
                               var x = genericModal('', 'Instructions to reset your password has been sent to your email.');
                           }
                       }
                       else if (response && response.status == 500) {
                           $scope.errors += '* ' + 'There was an error with the server.  Try again later.' + '\n';
                       }
                       else if (response && response.data && response.data.Errors) {
                           for (var i = 0; i < response.data.Errors.length; i++) {
                               $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                           }
                           if (window.innerWidth < 800) {
                               $mdToast.show($mdToast.simple().textContent('Failure!'));
                           } else {
                               var y = genericModal('Failure!', '');
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
               
            }



            $scope.submitChangePassword = function (form) {
                $scope.errors = '';
                if (!form.$valid) {
                    angular.forEach(form.$error, function (field) {
                        angular.forEach(field, function (errorField) {
                            errorField.$setTouched();
                        })
                    });
                    return;
                }
                if (!$scope.passwordsMatch()) {
                    $scope.errors += '* ' + 'New passwords do not match';
                    return false;
                }
                sModal = spinnerModal();

                $scope.errors = '';

                var data = 'Email=' + $rootScope.currentUser.email;
                data += '&CurrentPassword=' + $scope.changepassword.currentpassword;
                data += '&NewPassword=' + $scope.changepassword.newpassword;

                $http.post('/account/changepassword?' + data).
                    then(function successCallback(response) {
                        if (response && response.data.Succeeded) {
                            var x = genericModal('Success!', 'Your password was changed!');
                        }
                        else if (response && response.status == 500) {
                            $scope.errors += '* ' + 'There was an error with the server.  Try again later.' + '\n';
                        }
                        else if (response && response.data && response.data.Errors) {
                            for (var i = 0; i < response.data.Errors.length; i++) {
                                $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                            }
                            var y = genericModal('Failure!', 'The current password entered is incorrect');
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
            }

            $rootScope.closeModal = function () {
                this.$close();
            }

            function resetModel() {
                $scope.forgotform = {};
                $scope.forgotform.email = '';
                $scope.errors = '';
            }
        }
    ]);
})();