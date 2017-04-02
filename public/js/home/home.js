var app = angular.module('biomedicalApp', []);

app.controller('biomedicalController', function ($scope, $http) {

    $scope.typePerson = null;
    $scope.equipment = [];
    $scope.person = {};
    $scope.addPerson = {};
    $scope.assignedProfessor = {};
    $scope.assignments = [];
    $scope.equipmentCrud = {};

    var randomScalingFactor = function(){ return Math.round(Math.random()*1000)};

    angular.element(document).ready(function () {

        $scope.assignedProfessor.found = false;

        initButtons();
        initAssignments();

        var mostBar = document.getElementById("most-bar-chart").getContext("2d");
        var leastBar = document.getElementById("least-bar-chart").getContext("2d");

        $http({
            method: 'GET',
            url: '/search/testa/'
        }).then(function (response) {

            var mostChartData = getChartData(response.data.most);
            var leastChartData = getChartData(response.data.least);

            window.myBar = new Chart(mostBar).Bar(mostChartData, {
                responsive : true
            });

            window.myBar = new Chart(leastBar).Bar(leastChartData, {
                responsive : true
            });

        }, function (response) {

            console.log("something went wrong");

        });

    });

    function getChartData(arr) {

        var labels = [];
        var data = [];

        angular.forEach(arr, function(equipment, key) {

            labels.push(equipment.nombre);
            data.push(equipment.counter);

        });

        var datasets = [{
            fillColor : "rgba(154,232,225,0.5)",
            strokeColor : "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data : data
        }];

        var barChartData = {
            labels : labels,
            datasets : datasets
        };

        return barChartData;

    }

    function initButtons() {

        $('a.modal-click').click(function(event) {

            event.preventDefault();

            var idModal = $(this).attr('id');

            if (idModal == 'equipment') {

                $("#equipmentManagerModal").modal("show");

            } else if(idModal == 'maintenance') {

                $("#maintenanceModal").modal("show");

            } else if(idModal == 'assignments') {

                $("#assignmentsModal").modal("show");

            } else if(idModal == 'assignments_historial') {

                $("#assignmentsHistorialModal").modal("show");

            } else if(idModal == 'persons') {

                console.log("Modulo no finalizado");

            }

        });

        $('#createEquipmentSource').click(function(event) {

            $scope.equipmentCrud = {};

            $scope.$apply();

            $("#equipmentManagerModal").modal("hide");

            $("#createEquipmentModal").modal("show");

        });

        $('#watchMaintenanceSource').click(function(event) {

            $("#maintenanceModal").modal("hide");

            $("#watch_maintenanceModal").modal("show");


        });

        $('#sendMaintenanceSource').click(function(event) {

            var selections = $("#equipment_maintenance_table").bootstrapTable('getSelections');

            if (selections.length) {

                swal({
                    title: 'Estás seguro?',
                    text: "Enviarás a mantenimiento el/los equipo(s) seleccionado(s)!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, envíalos'
                }).then(function () {

                    $http({
                        method: 'POST',
                        url: '/create/maintenance/',
                        data: {
                            equipment: JSON.stringify(selections)
                        },
                        dataType: 'JSON',
                    }).then(function (response) {

                        if (response.data == "true") {

                            swal(
                                'Correcto!',
                                'Equipo enviado a mantenimiento.',
                                'success'
                            );

                            $("#equipment_maintenance_watch_table").bootstrapTable('refresh');
                            $("#equipment_maintenance_table").bootstrapTable('refresh');
                            $("#equipment_table").bootstrapTable('refresh');
                            $("#equipment_manager_table").bootstrapTable('refresh');
                            $("#assignments_table").bootstrapTable('refresh');

                        } else {

                            alert("No se han podido enviar los datos :/");

                        }

                    }, function (response) {

                        console.log("something went wrong");

                    });

                });


            } else {

                alert('Por favor establezca uno o más equipos');

            }

            console.log();

            // $("#equipmentManagerModal").modal("hide");
            // $("#createEquipmentModal").modal("show");

        });



        $('#createEquipmentModal, #updateEquipmentModal').on('hidden.bs.modal', function () {

            $("#equipmentManagerModal").modal("show");

        });

    }

    function initAssignments() {

        $http({
            method: 'GET',
            url: '/search/asignaciones/'
        }).then(function (response) {

            angular.forEach(response.data, function(assignment, key) {
                $scope.assignments.push(assignment);
            });

        }, function (response) {

            console.log("something went wrong");

        });

    }

    $scope.typeAction = function() {

        var table = $("#equipment_table");
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

                            angular.forEach($scope.equipment, function(equipment, key) {

                                $("#equipment_table").bootstrapTable('remove', {
                                    field: 'id',
                                    values: [equipment.id]
                                });

                                $("#equipment_manager_table").bootstrapTable('remove', {
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

                            var table = $("#equipment_table");

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
                        'Eliminado!',
                        'La asignación ha sido eliminada.',
                        'success'
                    );

                    $scope.assignments.splice(index, 1);

                    $("#equipment_table").bootstrapTable('refresh');

                    $("#equipment_manager_table").bootstrapTable('refresh');

                    $("#assignments_table").bootstrapTable('refresh');

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

    /* CRUD Equipo */

    $scope.addEquipment = function () {

        $http({
            method: 'POST',
            url: '/create/equipo/',
            data: {
                equipmentCrud: JSON.stringify($scope.equipmentCrud)
            },
            dataType: 'JSON',
        }).then(function (response) {

            console.log(response);

            if (response.statusText == "OK") {

                swal(
                    'Datos guardados satisfactoriamente!',
                    'Verifique el nuevo equipo!',
                    'success'
                );

                $("#equipment_table").bootstrapTable('refresh');

                $("#equipment_manager_table").bootstrapTable('refresh');

                $('#createEquipmentModal').modal('hide');

                setTimeout(function () {
                    $("#equipmentManagerModal").modal("show");
                }, 100);

            } else {

                swal(
                    'No se han podido guardar los datos!',
                    'Algo ha salido mal...!',
                    'error'
                );

            }

        }, function (response) {

            console.log("something went wrong");

            swal(
                'No se han podido guardar los datos!',
                'Algo ha salido mal...!',
                'error'
            );

        });

        $scope.equipmentCrud = {};


    };

    $scope.deleteEquipment = function (row, index) {

        swal({
            title: 'Estás seguro?',
            text: "No podrás revertir esta acción!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, elimínalo!'
        }).then(function () {

            console.log('Deleting');

            var equipment = row;

            $http({
                method: 'POST',
                url: '/delete/equipo/',
                data: {
                    equipmentCrud: JSON.stringify(equipment)
                },
                dataType: 'JSON',
            }).then(function (response) {

                if (response.data == "true") {

                    swal(
                        'Eliminado!',
                        'El equipo ha sido eliminado.',
                        'success'
                    );

                    $("#equipment_table").bootstrapTable('refresh');

                    $("#equipment_manager_table").bootstrapTable('refresh');

                } else {

                    alert("No se ha podido eliminar :/");

                }

            }, function (response) {

                console.log("something went wrong");

            });

        });

    };

    $scope.currentEquipment = {};

    $scope.updateEquipment = function () {

        $http({
            method: 'POST',
            url: '/update/equipo/',
            data: {
                equipmentCrud: JSON.stringify($scope.equipmentCrud)
            },
            dataType: 'JSON',
        }).then(function (response) {

            if (response.data == "true") {

                swal(
                    'Editado!',
                    'El equipo ha sido editado.',
                    'success'
                );

                $("#equipment_table").bootstrapTable('refresh');

                $("#equipment_manager_table").bootstrapTable('refresh');

                $('#updateEquipmentModal').modal('hide');

                setTimeout(function () {
                    $("#equipmentManagerModal").modal("show");
                }, 400);
            } else {

                alert("No se ha podido eliminar :/");

            }

        }, function (response) {

            console.log("something went wrong");

        });

    };



    $scope.removeMaintenanceEquipment = function (row, index) {

        console.log("Eliminando");

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
                url: '/delete/maintenance/',
                data: {
                    equipment: JSON.stringify(row)
                },
                dataType: 'JSON',
            }).then(function (response) {

                if (response.data == "true") {

                    swal(
                        'Eliminado!',
                        'El equipo ha sido removido de mantenimiento.',
                        'success'
                    );

                    $("#equipment_maintenance_watch_table").bootstrapTable('refresh');
                    $("#equipment_maintenance_table").bootstrapTable('refresh');
                    $("#equipment_table").bootstrapTable('refresh');
                    $("#equipment_manager_table").bootstrapTable('refresh');
                    $("#assignments_table").bootstrapTable('refresh');

                } else {

                    alert("No se ha podido eliminar :/");

                }

            }, function (response) {

                console.log("something went wrong");

            });

        });

        $scope.$apply();

    };

    $scope.openUpdateEquipment = function (row, index) {

        console.log("Editando");

        $("#equipmentManagerModal").modal("hide");
        $("#updateEquipmentModal").modal("show");

        console.log(row);

        $scope.currentEquipment = {
            id: row.id,
            nombre: row.Nombre,
            marca: row.Marca,
            modelo: row.Modelo,
            serie: row.NumeroSerie,
            inventario: row.NumeroInventario
        };

        $scope.equipmentCrud = $scope.currentEquipment;

        $scope.$apply();

    };

});

function deleteFormatter(value, row, index) {
    return [
        '<button class="btn btn-danger delete" href="javascript:void(0)">',
        'Eliminar',
        '</button>'
    ].join('');
}

function editFormatter(value, row, index) {
    return [
        '<button class="btn btn-primary edit" href="javascript:void(0)">',
        'Editar',
        '</button>'
    ].join('');
}

function deleteMaintenanceFormatter(value, row, index) {
    return [
        '<button class="btn btn-primary maintenanceEdit" href="javascript:void(0)">',
        'Remover',
        '</button>'
    ].join('');
}

window.operateEvents = {

    'click .delete': function (e, value, row, index) {

        var biomedicalApp = getApp('biomedicalApp');

        biomedicalApp.deleteEquipment(row, index);

    },
    'click .edit': function (e, value, row, index) {

        var biomedicalApp = getApp('biomedicalApp');

        biomedicalApp.openUpdateEquipment(row, index);

    },
    'click .maintenanceEdit': function (e, value, row, index) {

        var biomedicalApp = getApp('biomedicalApp');

        biomedicalApp.removeMaintenanceEquipment(row, index);

    }
};

function getApp(app) {

    return angular.element(
        $('[ng-app = ' + app + ']')
    ).scope().$$childHead;

}