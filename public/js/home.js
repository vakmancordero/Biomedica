var app = angular.module('biomedicalApp', []);

app.controller('biomedicalController', function ($scope, $http) {

    $scope.typePerson = {};
    $scope.equipment = [];
    $scope.person = {};
    $scope.addPerson = {};

    angular.element(document).ready(function () {

        console.log("working");

    });
    
    $scope.typeAction = function() {

        var table = $("#bootstrap_table");
        var selections = table.bootstrapTable('getSelections')

        if (selections.length) {

            console.log('Correcto! Datos seleccionados:');
            console.log(selections);

            $scope.equipment = selections;

            $("#typeModal").modal("show");

        } else {

            alert('Por favor establezca uno o más equipos');

        }
        
    };

    $scope.open = function() {

        console.log($scope.typePerson);
        console.log($scope.equipment);

        if (JSON.stringify($scope.typePerson) != "{}") {

            $("#equipmentModal").modal("show");

            setTimeout(function(){
                $('#typeModal').modal('hide')
            }, 100);

        } else {

            swal(
                'No podemos seguir :/',
                'Elige un tipo de persona',
                'warning'
            )

        }

    };

    $scope.find = function() {

        var number = $scope.typePerson == "professor" ?
            number = $scope.person.control : number = $scope.person.matricula;

        console.log("here");

        $http({
            method: 'GET',
            url: '/search/personas/' + number
        }).then(function (response) {

            var result = response.data;

            if (result != "") {

                var typePersonaResult = result.idTipoPersona == 1 ? 'student' : 'professor';

                if ($scope.typePerson == typePersonaResult) {

                    $scope.person.found = true;

                    $scope.person.id = result.id;
                    $scope.person.nombre = result.nombre;
                    $scope.person.matricula = result.matricula;
                    $scope.person.carrera = result.carrera;
                    $scope.person.cuatrimestre = result.cuatrimestre;
                    $scope.person.idTipoPersona = result.idTipoPersona;

                } else {

                    $scope.person.found = false;

                }

            } else {

                $scope.person.found = false;

            }

        }, function (response) {

            console.log("something went wrong");

        });

    };

    $scope.add = function() {

        var toAdd = $scope.addPerson;

        var idTipoPersona = $scope.typePerson == 'student' ? 1 : 2;

        toAdd.idTipoPersona = idTipoPersona;

        console.log(toAdd);

        $http({
            method: 'POST',
            url: '/create/persona/',
            data: JSON.stringify(toAdd),
            dataType: 'JSON',
        }).then(function (response) {

            console.log(response);

            if (response.statusText == "OK") {

                swal(
                    'Datos guardados satisfactoriamente!',
                    'Ahora añade el nuevo elemento!',
                    'success'
                )

            } else {

                swal(
                    'No se han podido guardar los datos!',
                    'Matrícula duplicada o algún error similar!',
                    'error'
                )

            }

        }, function (response) {

            console.log("something went wrong");

            swal(
                'No se han podido guardar los datos!',
                'Matrícula duplicada o algún error similar!',
                'error'
            )

        });

        $scope.addPerson = {};

    };

    $scope.resetVariables = function() {

        console.log("Resetting variables");

        $scope.person = {};
        $scope.typePerson = {};

    }

});