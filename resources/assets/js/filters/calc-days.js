angular.module('app.filters').filter('calcDays', ['appConfig', function (appConfig) {
    return function (input) {
        var currentDate = new Date();
        var dueDate = new Date(input);
        var dateDiff = Math.abs(dueDate.getTime() - currentDate.getTime());
        var diffDays = Math.ceil(dateDiff / (1000 * 3600 * 24));

        if (parseInt(dueDate.getTime() - currentDate.getTime()) >= 0) {
            return "+" + diffDays;
        }

        return "-" + diffDays;
    }
}]);