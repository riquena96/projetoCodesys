angular.module('app.controllers')
    .controller('ProjectListController', [
        '$scope', '$routeParams', 'Project', function ($scope, $routeParams, Project) {

            $scope.projects = [];
            $scope.totalProjects = 0;
            $scope.projectsPerPage = 15;

            $scope.pagination = {
                current: 1
            };

            $scope.pageChanged = function (newPage) {
                getResultsPage(newPage);
            };

            function getResultsPage(pageNumber) {
                Project.query({
                    page: pageNumber,
                }, function (data) {
                    $scope.projects = data.data;
                    $scope.totalProjects = data.meta.pagination.total;
                });
            }

            getResultsPage(1);
        }]);