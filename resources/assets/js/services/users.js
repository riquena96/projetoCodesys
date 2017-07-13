/**
 * Created by henrique on 08/07/2017.
 */
angular.module('app.services')
    .service('Users', ['$resource', 'appConfig', function ($resource, appConfig) {
        return $resource(appConfig.baseUrl + '/user', {
            update: {
                method: 'PUT'
            },
            query: {
                isArray: false
            }
        });

    }])