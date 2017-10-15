(function () {
    angular.module('pipeline').controller('LandingController', ['$scope', '$rootScope', '$cookies', '$state', '$http', '$location', 'spinnerModal', 'genericModal', '$mdToast', '$window',
        function ($scope, $rootScope, $cookies, $state, $http, $location, spinnerModal, genericModal, $mdToast, $window) {
            $scope.errors = '';
            $scope.contact = {};

            $scope.contact.email = '';
            $scope.contact.name = '';
            $scope.contact.message = '';

            //form submission handler
            $scope.sendMessage = function (form) {
                if (!form.$valid) {
                    angular.forEach(form.$error, function (field) {
                        angular.forEach(field, function (errorField) {
                            errorField.$setTouched();
                        })
                    });
                    return;
                }

                $scope.errors = "";

                var data = 'Email=' + ($scope.contact.email ? $scope.contact.email : '');
                data += '&Name=' + ($scope.contact.name ? $scope.contact.name : '');
                data += '&Message=' + ($scope.contact.message ? $scope.contact.message.replace(/\n\r?/g, '<br />') : '');

                var sModal = spinnerModal();
                $http.post('landing/contactmessage?' + data).then(
                    function successCallback(response) {
                        if (response && response.data.Succeeded) {
                            $state.go("top");
                            resetContactModel();
                            if (window.innerWidth < 800) {
                                $mdToast.show($mdToast.simple().textContent('Your form has been submitted succesfully!'));
                            } else {
                                var x = genericModal('', 'Your form has been submitted succesfully!');
                            }
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
                    },
                    function errorCallback(response) {
                        if (response && response.data && response.data.Errors) {
                            for (var i = 0; i < response.data.Errors.length; i++) {
                                $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                            }
                        }
                        sModal.close();
                    }
                );
                $rootScope.closeModal = function () {
                    this.$close();
                };


                function resetContactModel() {
                    $scope.contact = {};

                    $scope.contact.email = '';
                    $scope.contact.name = '';
                    $scope.contact.message = '';

                    $scope.errors = '';
                }
            }
        }
    ]);
})();

