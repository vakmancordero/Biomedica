var app = angular.module('biomedicalApp', []);

app.controller('biomedicalController', function ($scope, $http) {

    $http({
        method: 'GET',
        url: '/search/equipos/'
    }).then(function (response) {

        return response.data.equipos;

    }, function (response) {

    });

});