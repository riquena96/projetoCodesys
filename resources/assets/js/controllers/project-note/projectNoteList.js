angular.module('app.controllers')
    .controller('ProjectNoteListController', [
        '$scope', '$routeParams', '$compile', '$timeout', '$http', '$window', 'ProjectNote', 'Project',
        function ($scope, $routeParams, $compile, $timeout, $http, $window, ProjectNote, Project) {
        $scope.project = Project.query({id: $routeParams.id});
        $scope.projectNotes = ProjectNote.query({id: $routeParams.id});

        $scope.print = function(note) {
            $http.get('/build/views/templates/projectNoteShow.html').then(function(response) {
                $scope.note = note;
                var div = $('<div/>');
                div.html($compile(response.data)($scope));
                $timeout(function() {
                    var frame = $window.open('', '_blank', 'width=500, heigth=500');
                    frame.document.open();
                    frame.document.write(div.html());
                    frame.document.close();
                });
            });
        };
    }]);