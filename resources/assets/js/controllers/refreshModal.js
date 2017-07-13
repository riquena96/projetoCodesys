angular.module('app.controllers')
    .controller('RefreshModalController',
        ['$rootScope', '$scope', '$location', '$modalInstance', '$interval', 'authService', 'User', 'OAuth', 'OAuthToken',
            function ($rootScope, $scope, $location, $modalInstance, $interval, authService, User, OAuth, OAuthToken) {

                $scope.$on('event:auth-loginConfirmed', function () {
                    $rootScope.loginModalOpened = false;
                    $modalInstance.close();
                });

                $scope.$on('$routeChangeStart', function () {
                    $rootScope.loginModalOpened = false;
                    $modalInstance.dismiss('cancel');
                });

                $scope.$on('event:auth-loginCancelled', function () {
                    OAuthToken.removeToken();
                });

                OAuth.getRefreshToken().then(function () {
                    $interval(function () {
                        authService.loginConfirmed();
                    }, 5000);
                }, function (data) {
                    $scope.cancel();
                });

                $scope.cancel = function () {
                    authService.loginCancelled();
                    $location.path('login');
                };
            }]);