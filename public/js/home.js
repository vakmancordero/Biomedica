var app = angular.module('biomedicalApp', []);

app.controller('biomedicalController', function ($scope, $http) {

    $scope.typePerson = null;
    $scope.equipment = [];
    $scope.person = {};
    $scope.addPerson = {};
    $scope.assignedProfessor = {};
    $scope.assignments = [];

    angular.element(document).ready(function () {

        $scope.assignedProfessor.found = false

        console.log($scope.assignedProfessor.found);

        $('a#assignments').click(function(event) {

            event.preventDefault();

            $("#assignmentsModal").modal("show");

            return false;
        });

        $http({
            method: 'GET',
            url: '/search/asignaciones/'
        }).then(function (response) {

            angular.forEach(response.data, function(assignment, key) {
                $scope.assignments.push(assignment);
            });

            console.log($scope.assignments);

        }, function (response) {

            console.log("something went wrong");

        });

    });
    
    $scope.typeAction = function() {

        var table = $("#bootstrap_table");
        var selections = table.bootstrapTable('getSelections');

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

        if ($scope.typePerson == null) {

            swal(
                'No podemos seguir :/',
                'Elige un tipo de persona',
                'warning'
            );

        } else {

            $('#typeModal').modal('hide');

            setTimeout(function () {
                $("#equipmentModal").modal("show");
            }, 100);

        }

    };

    $scope.find = function() {

        var number = $scope.typePerson == "professor" ?
            number = $scope.person.control : number = $scope.person.matricula;

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

                    if ($scope.typePerson == 'professor') {

                        swal(
                            'Todo listo! Ahora puedes terminar la asignación.',
                            'Da click en el botón finalizar!',
                            'success'
                        );

                    }

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
                    'Ahora añade el nuevo elemento!' + toAdd.control,
                    'success'
                );

            } else {

                swal(
                    'No se han podido guardar los datos!',
                    'Matrícula duplicada o algún error similar!',
                    'error'
                );

            }

        }, function (response) {

            console.log("something went wrong");

            swal(
                'No se han podido guardar los datos!',
                'Matrícula duplicada o algún error similar!',
                'error'
            );

        });

        $scope.addPerson = {};

    };

    $scope.findProfessor = function() {

        console.log("Buscando y estableciendo profesor");

        var number = $scope.person.control;

        $http({
            method: 'GET',
            url: '/search/personas/' + number
        }).then(function (response) {

            var result = response.data;

            if (result != "") {

                var typePersonaResult = result.idTipoPersona == 1 ? 'student' : 'professor';

                if (typePersonaResult = "professor") {

                    $scope.assignedProfessor.found = true;

                    $scope.assignedProfessor.id = result.id;
                    $scope.assignedProfessor.nombre = result.nombre;
                    $scope.assignedProfessor.matricula = result.matricula;
                    $scope.assignedProfessor.carrera = result.carrera;
                    $scope.assignedProfessor.cuatrimestre = result.cuatrimestre;
                    $scope.assignedProfessor.idTipoPersona = result.idTipoPersona;

                    swal(
                        'Todo listo! Ahora puedes terminar la asignación.',
                        'Da click en el botón finalizar!',
                        'success'
                    );

                } else {

                    $scope.assignedProfessor.found = false;

                }

            } else {

                $scope.assignedProfessor.found = false;

            }

        }, function (response) {

            console.log("something went wrong");

        });

    };

    $scope.finishAssignment = function() {

        console.log("Finalizando asignación");

        if ($scope.person.found) {

            if ($scope.typePerson == 'student') {

                if ($scope.assignedProfessor.found) {

                    console.log("Resultados:");

                    console.log($scope.person);
                    console.log($scope.assignedProfessor);
                    console.log($scope.equipment);

                    $http({
                        method: 'POST',
                        url: '/create/asignacion/',
                        data: {
                            person: JSON.stringify($scope.person),
                            professor: JSON.stringify($scope.assignedProfessor),
                            equipment: JSON.stringify($scope.equipment),
                        },
                        dataType: 'JSON',
                    }).then(function (response) {

                        console.log(response);

                        if (response.statusText == "OK") {

                            swal(
                                'Asignación guardada satisfactoriamente!',
                                'Elementos utilizados: ' + $scope.equipment.length,
                                'success'
                            );

                            var table = $("#bootstrap_table");

                            angular.forEach($scope.equipment, function(equipment, key) {

                                table.bootstrapTable('remove', {
                                    field: 'id',
                                    values: [equipment.id]
                                });

                            });

                            $http({
                                method: 'GET',
                                url: '/search/asignaciones/'
                            }).then(function (response) {

                                $scope.assignments = [];

                                angular.forEach(response.data, function(assignment, key) {
                                    $scope.assignments.push(assignment);
                                });

                                console.log($scope.assignments);

                            }, function (response) {

                                console.log("something went wrong");

                            });

                            $("#equipmentModal").modal("hide");

                            $scope.resetVariables();

                        } else {

                            swal(
                                'Error al guardar la asignación!',
                                'Inténtelo de nuevo!',
                                'error'
                            );

                        }

                    }, function (response) {

                        swal(
                            'Error al guardar la asignación!',
                            'Inténtelo de nuevo!',
                            'error'
                        );

                    });

                } else {

                    console.log("Professor not working");

                }

            } else {

                if ($scope.typePerson == 'professor') {

                    console.log("Resultados:");

                    console.log($scope.person);
                    console.log($scope.equipment);

                    $http({
                        method: 'POST',
                        url: '/create/asignacion/',
                        data: {
                            person: JSON.stringify($scope.person),
                            equipment: JSON.stringify($scope.equipment),
                        },
                        dataType: 'JSON',
                    }).then(function (response) {

                        console.log(response);

                        if (response.statusText == "OK") {

                            swal(
                                'Asignación guardada satisfactoriamente!',
                                'Elementos utilizados: ' + $scope.equipment.length,
                                'success'
                            );

                            var table = $("#bootstrap_table");

                            angular.forEach($scope.equipment, function(equipment, key) {

                                table.bootstrapTable('remove', {
                                    field: 'id',
                                    values: [equipment.id]
                                });

                            });

                            $http({
                                method: 'GET',
                                url: '/search/asignaciones/'
                            }).then(function (response) {

                                $scope.assignments = [];

                                angular.forEach(response.data, function(assignment, key) {
                                    $scope.assignments.push(assignment);
                                });

                                console.log($scope.assignments);

                            }, function (response) {

                                console.log("something went wrong");

                            });

                            $("#equipmentModal").modal("hide");

                            $scope.resetVariables();

                        } else {

                            swal(
                                'Error al guardar la asignación!',
                                'Inténtelo de nuevo!',
                                'error'
                            );

                        }

                    }, function (response) {

                        swal(
                            'Error al guardar la asignación!',
                            'Inténtelo de nuevo!',
                            'error'
                        );

                    });

                }

            }

        }

    };

    $scope.delete = function(index) {

        swal({
            title: 'Estás seguro?',
            text: "No podrás revertir esta acción!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, elimínalo!'
        }).then(function () {

            $http({
                method: 'POST',
                url: '/delete/asignacion/',
                data: {
                    assignment: JSON.stringify($scope.assignments[index])
                },
                dataType: 'JSON',
            }).then(function (response) {

                if (response.data == "true") {

                    swal(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    );

                    $scope.assignments.splice(index, 1);

                    var table = $("#bootstrap_table");
                    var selections = table.bootstrapTable('refresh');

                } else {

                    alert("No se ha podido eliminar :/");

                }

            }, function (response) {

                console.log("something went wrong");

            });

        });

    };

    $scope.resetPerson = function() {
        $scope.person = {};
    };

    $scope.resetVariables = function() {
        $scope.person = {};
        $scope.typePerson = null;
    };

});