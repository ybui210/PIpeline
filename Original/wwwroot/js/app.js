(function() {
    var app = angular.module('pipeline', ['gajus.swing', 'ngCookies', 'ui.router', 'mobile-angular-ui', 'ui.bootstrap', 'ngDropzone', 'ngMaterial', 'ngMessages', 'ngStorage', 'bootstrapLightbox', 'ngAnimate']);

    app.config(function($httpProvider) {
        $httpProvider.interceptors.push(function ($timeout, $q, $injector) {
            var loginModal, $http, $state;

            $timeout(function () {
                loginModal = $injector.get('loginModal');
                $http = $injector.get('$http');
                $state = $injector.get('$state');
            });

            return {
                responseError: function (rejection) {
                    if (rejection.status !== 401) {
                        return rejection;
                    }

                    var deferred = $q.defer();

                    loginModal()
                      .then(function () {
                          deferred.resolve($http(rejection.config));
                      })
                      .catch(function () {
                          $state.go('home');
                          deferred.reject(rejection);
                      });

                    return deferred.promise;
                }
            };
        });
    });

    app.run(function ($rootScope, $state, loginModal, $cookies, authentication, $timeout, $location, $document) {

        // This is a hack to remove overthrow-enabled class on start-up
        $document[0].documentElement.classList = [];

        // Load the user cookie into rootScope currentUser if the user cookie is set
        if (typeof $cookies.getObject('user') !== 'undefined') {
            $rootScope.currentUser = $cookies.getObject('user');
        }

        $timeout(function () {
            if ($state.is('home') && typeof $cookies.getObject('user') !== 'undefined') {
                $state.go("dashboard");
            }
        });

        $rootScope.$on('$stateChangeStart', function (event, toState, toParams) {
            var requireLogin = toState.data.requireLogin;

                if (requireLogin) {
                    authentication.isLoggedIn(null, function () {
                        event.preventDefault();
                    });
                } 
        });
    });

})();
