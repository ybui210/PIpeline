(function () {
    angular.module('pipeline').controller('AdminInviteController', ['$scope', '$mdToast', '$window', '$http', 'spinnerModal', 'genericModal', '$rootScope',
        function ($scope, $mdToast, $window, $http, spinnerModal, genericModal, $rootScope) {
            var sModal;

            $scope.errors = '';

            $scope.inviteRequests = [];

            $scope.$watch('$viewContentLoaded', function () {
                $scope.inviteRequests = [];

                sModal = spinnerModal();

                $http.get('invitationrequests/all').then(
                   function (resp) {
                       if (resp.data && resp.data.Succeeded) {
                           for (var i = 0; i < resp.data.Results.length; i++) {
                               $scope.inviteRequests.push(resp.data.Results[i]);
                           }
                       }
                       else if (resp.data && resp.data.Errors) {
                           for (var i = 0; i < resp.data.Errors.length; i++) {
                               $scope.errors += '* ' + resp.data.Errors[i].Description + '\n';
                           }
                       }

                       sModal.close();
                   },
                   function (resp) {
                       if (resp.data && resp.data.Errors) {
                           for (var i = 0; i < resp.data.Errors.length; i++) {
                               $scope.errors += '* ' + resp.data.Errors[i].Description + '\n';
                           }
                       }

                       sModal.close();
                   }
               );
            });

            $scope.approveRequest = function (index) {
                sModal = spinnerModal();

                var request = $scope.inviteRequests[index];
                var data = 'Email=' + request.request.Email;
                
                $http.post('invitationrequests/approverequest?' + data).then(
                    function (response) {
                        if (response.data && response.data.Succeeded) {
                            if (response.data.EmailSent) {
                                if (window.innerWidth < 800) {
                                    $mdToast.show($mdToast.simple().textContent('User has been approved!'));
                                } else {
                                    var x = genericModal('', 'User has been approved!');
                                }
                            }
                            $scope.inviteRequests.splice(index, 1);
                        }
                        else if (response.data && response.data.Errors) {
                            for (var i = 0; i < response.data.Errors.length; i++) {
                                $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                            }
                        }
                        
                        sModal.close();
                    },
                    function (response) {
                        if (response.data && response.data.Errors) {
                            for (var i = 0; i < response.data.Errors.length; i++) {
                                $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                            }
                        }

                        sModal.close();
                    }
                );
            }

            $scope.denyRequest = function (index) {
                sModal = spinnerModal();

                var request = $scope.inviteRequests[index];
                var data = 'Email=' + request.request.Email;

                $http.post('invitationrequests/denyrequest?' + data).then(
                    function (response) {
                        if (response.data && response.data.Succeeded) {
                            if (response.data.EmailSent) {
                                if (window.innerWidth < 800) {
                                    $mdToast.show($mdToast.simple().textContent('User has been denied!'));
                                } else {
                                    var x = genericModal('', 'User has been denied!');
                                }
                            }
                            $scope.inviteRequests.splice(index, 1);
                        }
                        else if (response.data && response.data.Errors) {
                            for (var i = 0; i < response.data.Errors.length; i++) {
                                $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                            }
                        }

                        sModal.close();
                    },
                    function (response) {
                        if (response.data && response.data.Errors) {
                            for (var i = 0; i < response.data.Errors.length; i++) {
                                $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                            }
                        }

                        sModal.close();
                    }
                );
            }
            $rootScope.closeModal = function () {
                this.$close();
            }
        }
    ]);
})();

