var app = angular.module('biomedicalApp', []);

app.controller('biomedicalController', function ($scope) {

    alert('Hello World');

    $http({
        method: 'GET',
        url: '/'
    }).then(function successCallback(response) {



    }, function errorCallback(response) {

    });

});