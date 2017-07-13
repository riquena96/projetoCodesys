angular.module('app.controllers')
    .controller('UserNewController', [
        '$scope', '$location', 'Users', function ($scope, $location, Users) {
            $scope.user = new Users();

            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.user.$save().then(function () {
                        $location.path('/users');
                    }, function (error) {
                        
                    });
                }
            }

        }]);