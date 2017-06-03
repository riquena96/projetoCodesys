angular.module('app.services')
    .service('ProjectTaskStatus', ['$resource', 'appConfig',
        function($resource, appConfig) {

            return $resource(appConfig.baseUrl + '/project/:id/taskStatus/:idTask' , {
                id: '@id',
                idTask: '@idTask'
            },{
                update: {
                    method: 'PUT',
                }
            });

        }]);
