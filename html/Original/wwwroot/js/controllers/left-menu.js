(function () {
    angular.module('pipeline').controller('LeftMenuController', ['$rootScope', '$scope', '$state', '$localStorage', '$cookieStore', 'authentication', '$window',
    function ($rootScope, $scope, $state, $localStorage, $cookieStore, authentication, $window) {

        var isMoble = false;
        var mobile = 800;
        $scope.isMobile = function () {
            return window.innerWidth
        }, $scope.$watch($scope.isMobile, function (size) {
            if (size < mobile)
            {
                $scope.mobile = true;
                isMoble = true;
            }
            else
            {
                $scope.mobile = false;
                isMobile = false;
            }
        })

        var o = 992;
        $scope.getWidth = function () {
            return window.innerWidth
        }, $scope.$watch($scope.getWidth, function (g) {
            $scope.toggle = g >= o ? angular.isDefined($cookieStore.get("toggle")) ? $cookieStore.get("toggle") ? !0 : !1 : !0 : !1
        }), $scope.toggleSidebar = function () {
            $scope.toggle = !$scope.toggle, $cookieStore.put("toggle", $scope.toggle)
        }, window.onresize = function () {
            $scope.$apply()
        }

        $rootScope.selectItem = function (item) {
            $localStorage.MenuSelection = item;
            $rootScope.leftMenuSelection = item;
            if (isMoble === true)
            {
                $scope.toggle = !$scope.toggle, $cookieStore.put("toggle", $scope.toggle);
            }
            $state.go(item);
        };

        $scope.logout = function logout() {
            authentication.logout(function () {
                $state.go('home');
            }, null);
        };

        $scope.showLeftMenu = function () {
            return $state.includes('dashboard');
        };

        $scope.mobileMode = function () {
            return window.innerWidth < 800;
        };

        //    $scope.isSidenavOpen = false;

        //    $scope.toggle = true;

        //    $scope.toggleSideNav = function () {
        //        $mdSidenav('leftNav').toggle();

        //    };


        //    if ($rootScope.leftMenuSelection === null)
        //    {
        //        $rootScope.leftMenuSelection = 'main';
        //    }
        //    else
        //    {
        //        $rootScope.leftMenuSelection = $localStorage.MenuSelection;
        //    }


        //$scope.showLeftMenu = function () {
        //    return $state.includes('dashboard');
        //};

        //$scope.itemSelected = function (item) {
        //    return item === $rootScope.leftMenuSelection;
        //};

        //$rootScope.selectItem = function (item) {
        //    $localStorage.MenuSelection = item;
        //    $rootScope.leftMenuSelection = item;
        //    $state.go(item);
        //};

        //$scope.toggleSubmenu = function (event) {
        //    var submenuItems;

        //    if (event.target.tagName === "SPAN") {
        //        submenuItems = event.target.parentElement.parentElement.nextElementSibling;
        //    }
        //    else if (event.target.tagName === "A") {
        //        submenuItems = event.target.parentElement.nextElementSibling;
        //    }
        //    else {
        //        submenuItems = event.target.nextElementSibling;
        //    }

        //    // TODO: Close any opened submenus except for the one clicked


        //    var height = submenuItems.clientHeight;
        //    var nextGroup = submenuItems.parentElement.nextElementSibling;

        //    if (submenuItems.classList.contains('opened')) {
        //        submenuItems.classList.remove('opened');
        //    }
        //    else {
        //        submenuItems.classList.add('opened');
        //    }
        //};



        //if ($localStorage.sidebarMinimized === null)
        //{
        //    $localStorage.sidebarMinimized = false;
        //}
        //else
        //{
        //    $scope.sidebarMinimized = $localStorage.sidebarMinimized;
        //}

        //$scope.toggleLeftSidebar = function () {
        //    $rootScope.Ui.toggle('uiSidebarLeft');
        //    $scope.sidebarMinimized = $scope.sidebarMinimized ? false : true;
        //    $localStorage.sidebarMinimized = $scope.sidebarMinimized
        //}
    }]);
})();