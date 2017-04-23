angular.module('app.controllers')
    .controller('projectDashboardController', [
        '$scope', '$location', '$routeParams', 'Project', function ($scope, $location, $routeParams, Project) {

            $scope.project = {

            };

            Project.query({
                orderBy: 'created_at',
                sortedBy: 'desc',

            }, function (response) {
                $scope.projects = response.data;
            });

            $scope.showProject = function (client) {
                $scope.project = client;
            };

        }]);