angular.module('pipeline').factory('authentication', ['$http', '$rootScope', '$cookies', 'spinnerModal',
    function ($http, $rootScope, $cookies, spinnerModal) {
        var loginModal;
        var logoutModal;
        var authModal;

        function login(email, password, rememberMe, successCallback, failureCallback) {

            loginModal = spinnerModal();

            var data = { UserName: email, Password: password, RememberMe: rememberMe };

            $http.post('account/login', data).
                then(function success(response) {
                    if (response.data && response.data.Succeeded && response.data.Confirmed) {
                        $cookies.putObject('user', response.data);
                        $rootScope.currentUser = response.data;
                    }

                    if (successCallback) {
                        successCallback(response);
                    }

                    loginModal.close();

                }, function () {
                    if (failureCallback)
                        failureCallback(response);

                    loginModal.close();
                });
        }

        function logout(successCallback, failCallback) {
            if (typeof $cookies.getObject('user') === 'undefined') {
                if (successCallback)
                    successCallback();
                return;
            }

            logoutModal = spinnerModal();

            $http.post('account/logoff').
            then(function success(response) {
                logoutModal.close();
                if (successCallback)
                    successCallback();
                $cookies.remove('user');
                $rootScope.currentUser = null;
            }
            , function () {
                logoutModal.close();
                if (failCallback)
                    failCallback();
                $cookies.remove('user');
                $rootScope.currentUser = null;
            });
        }

        function isLoggedIn(loggedInCallback, notLoggedInCallback) {
            if (typeof $cookies.getObject('user') === 'undefined') {
                if (notLoggedInCallback)
                    notLoggedInCallback();
                return false;
            }

            $http.post('account/isauthenticated?email=' + $cookies.getObject('user').email).then(
                function (resp) {
                    if (resp.data && resp.data.Succeeded) {
                        // Update user with latest profile data at this point
                        $cookies.putObject('user', resp.data);
                        $rootScope.currentUser = resp.data;
                        if (loggedInCallback)
                            loggedInCallback();
                        return true;
                    }
                    else {
                        if(notLoggedInCallback)
                            notLoggedInCallback();
                        return false;
                    }
                },
                function (resp) {
                    console.log('Connection error occurred while attempting to connect to server.');
                    if (notLoggedInCallback)
                        notLoggedInCallback();

                    //authModal.close();
                });
        }

        return {
            login: login,
            logout: logout,
            isLoggedIn: isLoggedIn
        }
    }
]);