(function() {
    angular.module('pipeline').directive('inviteApproval', [function () {
        return {
            restrict: 'E',
            templateUrl: 'views/dashboard/admin/invite-approval.html',
            controller: 'AdminInviteController',
            controllerAs: 'adminInviteCtrl'
        }
    }]);
})();
