angular.module('app.controllers')
    .controller('HomeController', ['$scope', '$cookies', '$timeout', '$pusher', 'Project',
        function ($scope, $cookies, $timeout, $pusher, Project) {

        $scope.tasks = [];

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
        var pusher = $pusher(window.client);
        var channel = pusher.subscribe('user.' + $cookies.getObject('user').id);
        channel.bind('CodeProject\\Events\\TaskWasIncluded',
            function (data) {
                if ($scope.tasks.length == 6) {
                    $scope.tasks.splice($scope.tasks.length - 1,1);
                }
                $timeout(function() {
                    $scope.tasks.unshift(data.task);
                },300);
            }
        );

        $scope.styleList = function () {
            $('.box-project').removeClass("col-sm-4").addClass("col-sm-10");
        };

        $scope.styleGrid = function () {
            $('.box-project').removeClass("col-sm-10").addClass("col-sm-4");
        };
    }]);