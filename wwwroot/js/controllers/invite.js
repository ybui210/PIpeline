(function () {
    angular.module('pipeline').controller('InviteController', ['$scope', '$rootScope', '$cookies', '$state', '$http', '$location', 'spinnerModal', '$mdToast', '$window', 'genericModal',
        function ($scope, $rootScope, $cookies, $state, $http, $location, spinnerModal, $mdToast, $window, genericModal) {
            $scope.errors = '';
            $scope.user = {};
           

            //Used for checkbox of invite form
            $scope.user.categories = [];

            $scope.desktopMode = function () {
                return $window.innerWidth > 800;
            }
            
            $http.get("/industrycategories/all").then(function (response) {
                for (var i = 0; i < 13; i++) {
                    $scope.user.categories.push({
                        ID: response.data[i].ID,
                        Category: response.data[i].Category,
                        Checked: false
                    })
                }
            });

            $scope.addCategory = function () {
                if ($scope.checkedOthers) {
                    $http.post('/industrycategories/appendnewcategory?category=' + $scope.user.otherCategory).then(
                        function successCallback(response) {
                            if (response && response.data.Succeeded) {

                            }
                            else if (response && response.status == 500) {
                                $scope.errors += '* ' + 'There was an error with the server.  Try again later.' + '\n';
                            }
                            else if (response && response.data && response.data.Errors) {
                                for (var i = 0; i < response.data.Errors.length; i++) {
                                    $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                                }
                            }

                        },
                        function errorCallback(response) {
                            if (response && response.data && response.data.Errors) {
                                for (var i = 0; i < response.data.Errors.length; i++) {
                                    $scope.errors += '* ' + response.data.Errors[i].Description + '\n';
                                }
                            }
                        }
                    );
                }
            }
            
            //handles form data
            $scope.errors = '';
            $scope.user.type = 'individual';
            $scope.user.purpose = "ForFunding";
            $scope.user.status = "New";

            //closes invite modal
            $rootScope.closeModal = function () {
                this.$close();
            }

            //form submission handler
            $scope.requestInvite = function (form) {
                if (!form.$valid) {
                    angular.forEach(form.$error, function (field) {
                        angular.forEach(field, function (errorField) {
                            errorField.$setTouched();
                        })
                    });
                    return;
                }

                $scope.errors = "";

                var temp = '';

                var data = 'FirstName=' + ($scope.user.firstname ? $scope.user.firstname : '');
                data += '&MiddleName=' + ($scope.user.middlename ? $scope.user.middlename : '');
                data += '&LastName=' + ($scope.user.lastname ? $scope.user.lastname : '');
                data += '&Email=' + $scope.user.email;
                data += '&Organization=' + ($scope.user.organization ? $scope.user.organization : '');
                data += '&Type=' + $scope.user.type;
                data += '&BusinessCategories=';
                for (var i = 0; i < $scope.user.categories.length; i++) {
                    if ($scope.user.categories[i].Checked) {
                        temp += $scope.user.categories[i].ID + ',';
                    }
                }
                if ($scope.checkedOthers && $scope.user.otherCategory !== '') {
                    $http.get('/industrycategories/getmaxid').then(function (response) {
                        if (response.data && response.data.Succeeded) {
                            temp += response.data.Max+1 + ',';
                        } else {
                            
                        }
                        
                    });
                    $scope.addCategory();
                }

                temp = temp.slice(0, -1);
                data += temp;
                data += '&Purpose=' + $scope.user.purpose;
                data += '&LinkedinUrl=' + ($scope.user.linkedin ? $scope.user.linkedin : '');
                data += '&WebsiteUrl=' + ($scope.user.website ? $scope.user.website : '');

                //check if business categories was check
                if (false) {
                    $scope.errors += '* ' + 'Categories of Interest Required\n';
                    return;
                }
                else {
                    var sModal = spinnerModal();
                    $http.post('invitationrequests/requestinvite?' + data).then(
                        function successCallback(response) {
                            if (response && response.data.Succeeded) {
                                if (window.innerWidth < 800) {
                                    $mdToast.show($mdToast.simple().textContent('Request received'));
                                } else {
                                    var x = genericModal('', 'Your request for an invitation has been received. We will review and notify you once you are approved.');
                                }
                                $state.go("home");
                                resetUserModel();
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
                    
                }

                function resetUserModel() {
                    $scope.user = {};

                    $scope.user.Email = '';
                    $scope.user.FirstName = '';
                    $scope.user.MiddleName = '';
                    $scope.user.LastName = '';
                    $scope.user.Organization = '';
                    $scope.user.Type = 'individual';
                    $scope.user.status = "New";

                    $scope.errors = '';
                }
            }
        }
    ]);
})();

