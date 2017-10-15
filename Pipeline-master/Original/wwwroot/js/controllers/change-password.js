(function () {
    angular.module('pipeline').controller('ChangePasswordController', ['$scope', '$http', '$cookies', '$state', '$mdToast', '$window', '$rootScope', '$location', 'spinnerModal', 'genericModal',
        function ($scope, $http, $cookies, $state, $mdToast, $window, $rootScope, $location, spinnerModal, genericModal) {

            $rootScope.tModal;
            var sModal;
            
            $scope.changepassword = {};
            $scope.changepassword.source;
            resetModel();
            $scope.errors = '';

            $scope.$watch('$viewContentLoading', function () {
                var url = $location.url().split('?')[1];
                if (url) {
                    var token = url.split('&')[0].split('verification=')[1];
                    var email = url.split('&email=')[1];
                    var postMethod = url.slice(0, 5);
                }
                

                if (postMethod == "verif") {
                    
                    if (token === '' || email === '') {
                        var toast = $mdToast.simple().textContent('Error encountered');
                        if ($window.innerWidth > 800) {
                            toast._options.position = 'bottom right';
                        }
                        $mdToast.show(toast);                     
                    }
                    $scope.changepassword.token = token;
                    $scope.changepassword.email = email;
                    $scope.changepassword.source = 1;


                } else {
                    $scope.changepassword.source = 0;
                }
                
            });

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


                if ($scope.changepassword.source === 0) {
                    var data = 'Email=' + $scope.changepassword.email;
                    data += '&CurrentPassword=' + $scope.changepassword.currentpassword;
                    data += '&NewPassword=' + $scope.changepassword.newpassword;

                    $http.post('/account/changepassword?' + data).
                    then(function successCallback(response) {
                        if (response && response.data.Succeeded) {
                            var x = genericModal('Success!', 'Your password was changed!');
                            //successmodal
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
                    this.$close();
                }
                else if ($scope.changepassword.source === 1) {
                    var data = 'Email=' + $scope.changepassword.email;
                    data += '&CurrentPassword=' + $scope.changepassword.currentpassword;
                    data += '&NewPassword=' + $scope.changepassword.newpassword;
                    data += '&Token=' + $scope.changepassword.token;

                    $http.post('/account/changefpassword?' + data).
                    then(function successCallback(response) {
                        if (response && response.data.Succeeded) {
                            var x = genericModal('Success!', 'Your password was changed!');
                            //successmodal
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
                }
                 
            }

            $rootScope.closeModal = function () {
                this.$close();
            }

            $scope.passwordsMatch = function () {
                return $scope.changepassword.newpassword === $scope.changepassword.confirmpassword;
            }

            function resetModel() {
                $scope.changepassword = {};

                $scope.changepassword.currentpassword = '';
                $scope.changepassword.newpassword = '';
                $scope.changepassword.confirmpassword = '';
                $scope.changepassword.source = 0;

                $scope.errors = '';
            }
        }
    ]);
})();