angular.module('app.controllers')
    .controller('projectDashboardController', [
        '$scope', '$location', '$resource', '$routeParams', 'Project', 'ProjectTaskStatus',
        function ($scope, $location, $resource, $routeParams, Project, ProjectTaskStatus) {

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
            
            $scope.alteraStatusTarefa = function (id, idTask) {
                ProjectTaskStatus.update({
                    id: id,
                    idTask: idTask
                });
                var tarefaConcluida = angular.element(document.querySelector('#tarefa'));
                var checkboxTarefa = angular.element(document.querySelector('#checkboxTarefa'));
                tarefaConcluida.addClass('checkbox disabled text-through text-disabled task-padding');
                checkboxTarefa.attr('disabled', 'disabled');
            };

        }]);