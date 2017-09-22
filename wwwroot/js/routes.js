angular.module('pipeline').config(function ($stateProvider, $urlRouterProvider) {
    var $cookies;
    angular.injector(['ngCookies']).invoke(['$cookies', function($_cookies) {
        $cookies = $_cookies;
    }])

    $urlRouterProvider.otherwise(function ($injector, $location) {
        var $state = $injector.get('$state');

        if (typeof $cookies.getObject('user') !== 'undefined') {
            $state.go('dashboard');
        } else {
            $state.go('home');
        }
    });

    $urlRouterProvider.when('dashboard', function ($injector, $location) {
        var $state = $injector.get('$state');

        if (typeof $cookies.getObject('user') !== 'undefined') {
            $state.go('dashboard');
        } else {
            $state.go('home');
        }
    });

    $stateProvider
        .state('home', {
            url: '/home',
            templateUrl: 'views/templates/home.html',
            data: {
                requireLogin: false
            },
            controller: 'LandingController'
        })
        .state('top', {
            url: '/home#page-top',
            templateUrl: 'views/templates/home.html',
            data: {
                requireLogin: false
            },
            controller: 'LandingController'
        })
        .state('about', {
            url: '/home#about',
            templateUrl: 'views/templates/home.html',
            data: {
                requireLogin: false
            },
            controller: 'LandingController'
        })
        .state('features', {
            url: '/home#features',
            templateUrl: 'views/templates/home.html',
            data: {
                requireLogin: false
            },
            controller: 'LandingController'
        })
        .state('contact', {
            url: '/home#contact',
            templateUrl: 'views/templates/home.html',
            data: {
                requireLogin: false
            },
            controller: 'LandingController'
        })
        .state('dashboard', {
            url: '/dashboard',
            templateUrl: 'views/templates/dashboard.html',
            data: {
                requireLogin: true
            },
            controller: 'DashboardController'
        })
        .state('dashboard.inviteapproval', {
            url: '/invite-approval',
            templateUrl: 'views/dashboard/admin/invite-approval.html',
            data: {
                requireLogin: true
            },
            controller: 'AdminInviteController'
        })
        .state('dashboard.browse', {
            url: '/browse',
            templateUrl: 'views/dashboard/user/main2.html',
            data: {
                requireLogin: true
            },
            controller: 'ListingsController'
        })
        .state('dashboard.mylistings', {
            url: '/mylistings',
            templateUrl: 'views/dashboard/user/my-listings.html',
            data: {
                requireLogin: true
            },
            controller: 'MyListingsController'
        })
        .state('dashboard.createlisting', {
            url: '/createlisting',
            templateUrl: 'views/dashboard/user/create-listing2.html',
            data: {
                requireLogin: true
            },
            controller: 'CreateListingController',
            controllerAs: 'ctrl'
        })
        .state('dashboard.saved-listings', {
            url: '/saved-listings',
            templateUrl: 'views/dashboard/user/saved-listings.html',
            data: {
                requireLogin: true
            },
            controller: 'SavedListingsController'
        })
        .state('dashboard.profile', {
            url: '/profile',
            templateUrl: 'views/dashboard/user/profile.html',
            data: {
                requireLogin: true
            },
            controller: 'ProfileController'
        })
        .state('dashboard.messages', {
            url: '/messages',
            templateUrl: 'views/dashboard/shared/messages.html',
            data: {
                requireLogin: true
            }
        })
        .state('dashboard.edit', {
            url: '/edit/:listingId',
            templateUrl: 'views/dashboard/user/edit-listing.html',
            data: {
                requireLogin: true
            },
            controller: "EditListingController"
        })
        .state('dashboard.settings', {
            url: '/settings',
            templateUrl: 'views/dashboard/user/settings.html',
            data: {
                requireLogin: true
            }
        })
        .state('login', {
            url: '/login',
            templateUrl: 'views/templates/login.html',
            data: {
                requireLogin: false
            }
        })
        .state('invite', {
            url: '/invite',
            templateUrl: 'views/templates/invite.html',
            data: {
                requireLogin: false
            },
            controller: 'InviteController'
        })
        .state('register', {
            url: '/register',
            templateUrl: 'views/templates/register.html',
            data: {
                requireLogin: false
            },
            controller: 'RegistrationController'
        })
        .state('forgot', {
            url: '/forgot',
            templateUrl: 'views/templates/forgot.html',
            data: {
                requireLogin: false
            },
            controller: 'ForgotPasswordController',
        })
        .state('changepassword', {
            url: '/changepassword',
            templateUrl: 'views/templates/changepassword.html',
            data: {
                requireLogin: false
            },
            controller: 'ChangePasswordController',
        })
        .state('dashboard.listing', {
            url: '/listing/:listingId',
            templateUrl: 'views/dashboard/user/listing-details.html',
            data: {
                requireLogin: true
            },
            controller: 'ListingDetailsController'
        })
});