angular.module('app.controllers')
    .controller('ClientListController', ['$scope', 'Client', function ($scope, Client) {

        $scope.client = [];
        $scope.totalClients = 0;
        $scope.clientsPerPage = 9;

        $scope.pageChanged = function (newPage) {
            getResultsPage(newPage);
        };

        function getResultsPage(pageNumber) {
            Client.query({
                orderBy: 'created_at',
                sortedBy: 'desc',
                page: pageNumber,
                limit: $scope.clientsPerPage
            }, function (data) {
                $scope.clients = data.data;
                $scope.totalClients = data.meta.pagination.total;
            });
        }

        getResultsPage(1);

    }]);