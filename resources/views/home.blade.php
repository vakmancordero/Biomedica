@extends('layouts.template')

@section('javascript')
    <script src="lib/sweet/sweetalert2.min.js"></script>
    <script src="js/home/home.js"></script>
@stop

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/sweet/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}">
@stop

@section('content')
    <div ng-app="biomedicalApp" ng-controller="biomedicalController">

        {{-- Modal de asignaciones pendientes --}}
        <div class="modal fade" id="assignmentsModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Asignaciones</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h2>Lista de asignaciones pendientes de entrega:</h2>
                                    </div>
                                    <div class="panel-body">
                                        {{--<table class="table">--}}
                                        {{--<thead class="thead-inverse">--}}
                                        {{--<tr>--}}
                                        {{--<th>ID</th>--}}
                                        {{--<th>Equipo</th>--}}
                                        {{--<th>EquipoID</th>--}}
                                        {{--<th>Persona</th>--}}
                                        {{--<th>Responsable</th>--}}
                                        {{--<th>Estado</th>--}}
                                        {{--<th>Eliminar</th>--}}
                                        {{--</tr>--}}
                                        {{--</thead>--}}
                                        {{--<tbody>--}}
                                        {{--<tr ng-repeat="assignment in assignments track by $index">--}}
                                        {{--<td>@{{assignment.id}}</td>--}}
                                        {{--<td>@{{assignment.equipo}}</td>--}}
                                        {{--<td><strong>@{{assignment.idEquipo}}</strong></td>--}}
                                        {{--<td>@{{assignment.persona}}</td>--}}
                                        {{--<td>@{{assignment.responsable}}</td>--}}
                                        {{--<td>@{{assignment.estado}}</td>--}}
                                        {{--<td ng-if="assignment.estado == 'activo'"><input type="button" ng-click="delete($index)" class="btn btn-danger btn-sm" value="Eliminar"></td>--}}
                                        {{--</tr>--}}
                                        {{--</tbody>--}}
                                        {{--</table>--}}
                                        <table id="removeAssignmentsTable"
                                               data-toggle="table"
                                               data-url="/search/asignaciones/"
                                               data-show-refresh="true"
                                               data-show-toggle="true"
                                               data-show-columns="true"
                                               data-search="true"
                                               data-select-item-name="toolbar1"
                                               data-pagination="true"
                                               data-sort-name="name"
                                               data-sort-order="desc"
                                               data-click-to-select="true"
                                               data-maintain-selected="true">
                                            <thead>
                                            <tr>
                                                <th data-checkbox="true" >ID</th>
                                                <th data-field="id" data-sortable="true">ID</th>
                                                <th data-field="equipo" data-sortable="true">Equipo</th>
                                                <th data-field="idEquipo" data-sortable="true">EquipoID</th>
                                                <th data-field="persona" data-sortable="true">Persona</th>
                                                <th data-field="responsable" data-sortable="true">Responsable</th>
                                                <th data-field="estado" data-sortable="true">Estado</th>
                                                <th data-field="materia" data-sortable="true">Materia</th>
                                                <th data-field="cuatrimestre" data-sortable="true">Cuatrimestre</th>
                                                {{--<th data-field="Nombre"  data-sortable="true">Nombre</th>--}}
                                                {{--<th data-field="Marca" data-sortable="true">Marca</th>--}}
                                                {{--<th data-field="Modelo" data-sortable="true">Modelo</th>--}}
                                                {{--<th data-field="NumeroSerie" data-sortable="true">No. Serie</th>--}}
                                                {{--<th data-field="NumeroInventario" data-sortable="true">No. Inventario</th>--}}
                                                {{--<th data-field="Observaciones" data-sortable="true">Observaciones</th>--}}
                                                {{--<th data-field="Estado" data-sortable="true">Estado</th>--}}
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <button id="removeAssignments" class="btn btn-lg btn-success">Remover asignaciones</button>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal de historial de asignaciones no pendientes --}}
        <div class="modal fade" id="assignmentsHistorialModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Historial de asignaciones</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h2 style="color: darkslategrey">Historial de asignaciones finalizadas:</h2>
                                    </div>
                                    <div class="panel-body">
                                        <table id="assignments_table"
                                               data-toggle="table"
                                               data-url="/search/asignaciones/historial"
                                               data-show-refresh="true"
                                               data-show-toggle="true"
                                               data-show-columns="true"
                                               data-show-export="true"
                                               data-detail-view="true"
                                               data-search="true"
                                               data-pagination="true"
                                               data-sort-name="name"
                                               data-sort-order="desc"
                                               data-page-list="[5, 6, 10, 25, 50, 100]"
                                               data-page-size="6"
                                               data-click-to-select="true"
                                               data-maintain-selected="true">
                                            <thead>
                                            <tr>
                                                {{--<th data-checkbox="true" >ID</th>--}}
                                                <th data-field="id" data-sortable="true">ID</th>
                                                <th data-field="equipo"  data-sortable="true">Equipo</th>
                                                <th data-field="idEquipo"  data-sortable="true">EquipoID</th>
                                                <th data-field="persona" data-sortable="true">Persona</th>
                                                <th data-field="responsable" data-sortable="true">Responsable</th>
                                                <th data-field="fecha" data-sortable="true">Fecha</th>
                                                <th data-formatter="pdfFormatter" data-events="operateEvents">Imprimir</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal de tipo de persona --}}
        <div class="modal fade" id="typeModal" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Asignar a:</h3>
                    </div>
                    <div class="modal-body text-center">
                        <label>
                            <input type="radio" name="type_person" value="professor" ng-model="typePerson"/>
                            <img src="{{ asset('img/professor.png') }}">
                            Profesor
                        </label>
                        <label>
                            <input type="radio" name="type_person" value="student" ng-model="typePerson"/>
                            <img src="{{ asset('img/student.png') }}">
                            Estudiante
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" ng-click="open()">Continuar</button>
                        <a href="#" ng-click="resetVariables()" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal de asignacion de equipo y personas --}}
        <div class="modal fade" id="equipmentModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Asignar equipo a:</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <ol class="breadcrumb">
                                <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                                <li class="active">Asignar equipo</li>
                            </ol>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="page-header">Asignar equipo</h1>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        @{{typePerson == "student" ?
                                            'Buscar estudiante' :
                                            'Buscar profesor'
                                        }}
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-6">
                                            <form ng-submit="find()">
                                                <div class="form-group">
                                                    <div ng-switch on="typePerson">
                                                        <div ng-switch-when="student">
                                                            <label>Matricula: </label>
                                                            <input type="text" ng-disabled="person.found" pattern="\d*" maxlength="6" class="form-control" placeholder="Ejemplo: 113128" required ng-model="person.matricula">
                                                        </div>
                                                        <div ng-switch-default>
                                                            <label>No. Control:</label>
                                                            <input type="text" ng-disabled="person.found" pattern="\d*" maxlength="4" class="form-control" placeholder="Ejemplo: 1131" required ng-model="person.control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-success" type="submit">Buscar</button>
                                                <button class="btn btn-danger" type="reset" ng-click="resetPerson()">Cancelar</button>
                                            </form>
                                            <hr/>
                                            <div ng-switch on="person.found">
                                                <div ng-switch-when="true">

                                                    <div ng-switch on="typePerson">
                                                        <div ng-switch-when="student">
                                                            <div ng-switch on="assignedProfessor.found">
                                                                <div ng-switch-when="true">
                                                                    <h4>Buscar <strong style="color: forestgreen">profesor</strong> a asignar </h4>
                                                                    <h4>Asignación: <strong style="color: darkslategrey">[@{{ assignedProfessor.nombre }}]</strong></h4>
                                                                </div>
                                                                <div ng-switch-when="false">
                                                                    <h4>Buscar <strong style="color: forestgreen">profesor</strong> a asignar
                                                                        <strong style="color: darkred">[Sin asignar]</strong>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                            <form ng-submit="findProfessor()">
                                                                <div class="form-group">
                                                                    <label>No. Control:</label>
                                                                    <input type="text" pattern="\d*" maxlength="4" class="form-control" placeholder="Ejemplo: 1131" required ng-model="person.control">
                                                                </div>
                                                                <div class="text-right">
                                                                    <button class="btn btn-default" type="submit">Buscar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="panel panel-success">
                                                <div ng-switch on="person.found">
                                                    <div ng-switch-when="true">
                                                        <div class="panel-heading">
                                                            <strong class="text-success">Encontrado</strong>
                                                        </div>
                                                        <div class="panel-body">

                                                            <table class="table table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>Atributo</th>
                                                                    <th>Descripción</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>ID</td>
                                                                    <td>@{{person.id}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Nombre</td>
                                                                    <td>@{{person.nombre}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        @{{typePerson == "student" ?
                                                                            'Matrícula' :
                                                                            'No. Control'
                                                                        }}
                                                                    </td>
                                                                    <td>@{{person.matricula}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Carrera</td>
                                                                    <td>@{{person.carrera}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Cuatrimestre:</td>
                                                                    {{--<td>@{{person.carrera}}</td>--}}
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <select class="form-control" ng-model="person.cuatrimestrePE">
                                                                                <option>1</option>
                                                                                <option>2</option>
                                                                                <option>3</option>
                                                                                <option>4</option>
                                                                                <option>5</option>
                                                                                <option>6</option>
                                                                                <option>7</option>
                                                                                <option>8</option>
                                                                                <option>9</option>
                                                                                <option>10</option>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Materia:</td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <select class="form-control" ng-model="person.materia">
                                                                                <option>Mediciones eléctricas</option>
                                                                                <option>Fundamentos de electrónica</option>
                                                                                <option>Electrónica analógica</option>
                                                                                <option>Electrónica digital</option>
                                                                                <option>Sensores y actuadores biomédicos.</option>
                                                                                <option>Máquinas eléctricas.</option>
                                                                                <option>Electrónica de potencia.</option>
                                                                                <option>Suministros de energía eléctrica.</option>
                                                                                <option>Desarrollo de sistemas biomédicos.</option>
                                                                                <option>Integración de sistemas biomédicos.</option>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div ng-switch-when="false">
                                                        <div class="panel-heading">
                                                            <strong class="text-danger">No encontrado</strong>
                                                        </div>
                                                        <div class="panel-body">
                                                            <h2>Crear
                                                                @{{
                                                                    typePerson == "student" ?
                                                                        ' alumno' :
                                                                        ' profesor'
                                                                }}
                                                            </h2>
                                                            <form ng-submit="add()">
                                                                <div class="form-group">
                                                                    <label for="name">Nombre:</label>
                                                                    <input type="text" class="form-control" id="name" placeholder="Introducir nombre" required ng-model="addPerson.nombre">
                                                                </div>
                                                                <div class="form-group">
                                                                    <div ng-switch on="typePerson">
                                                                        <div ng-switch-when="student">
                                                                            <label for="mat">Matrícula:</label>
                                                                            <input id="mat" type="text" pattern="\d*" maxlength="6" class="form-control" placeholder="Ejemplo: 113128" required ng-model="addPerson.matricula">
                                                                        </div>
                                                                        <div ng-switch-when="professor">
                                                                            <label for="cont">Número de control:</label>
                                                                            <input id="cont" type="text" pattern="\d*" maxlength="4" class="form-control" placeholder="Ejemplo: 1131" required ng-model="addPerson.control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="career" >Carrera: </label>
                                                                    <select class="form-control" id="career" required ng-model="addPerson.carrera">
                                                                        <option>Ing. Biomédica</option>
                                                                        <option>Ing. en Desarrollo de Software</option>
                                                                        <option>Ing. Mecatronica</option>
                                                                        <option>Ing. Energía</option>
                                                                        <option>Ing. en Tecnología Ambiental</option>
                                                                        <option>Ing. Agroindustrial</option>
                                                                        <option>Ing. Petrolera</option>
                                                                        <option>Ing. Manofactura</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div ng-switch on="typePerson">
                                                                        <div ng-switch-when="student">
                                                                            <label>Cuatrimestre: </label>
                                                                            <select class="form-control" required ng-model="addPerson.cuatrimestre">
                                                                                <option>1</option>
                                                                                <option>2</option>
                                                                                <option>3</option>
                                                                                <option>4</option>
                                                                                <option>5</option>
                                                                                <option>6</option>
                                                                                <option>7</option>
                                                                                <option>8</option>
                                                                                <option>9</option>
                                                                                <option>10</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div ng-switch-default></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" ng-click="finishAssignment()">Finalizar</button>
                        <a href="#" ng-click="resetVariables()" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal de administrador de equipos --}}
        <div class="modal fade" id="equipmentManagerModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Administrador de equipos</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h2>Tabla de equipos disponibles en almacén:</h2>
                                    </div>
                                    <div class="panel-body">

                                        <table id="equipment_manager_table"
                                               data-toggle="table"
                                               data-url="/search/equipos/"
                                               data-show-refresh="true"
                                               data-show-toggle="true"
                                               data-show-columns="true"
                                               data-show-export="true"
                                               data-detail-view="true"
                                               data-search="true"
                                               data-pagination="true"
                                               data-sort-name="name"
                                               data-sort-order="desc"
                                               data-page-list="[5, 6, 10, 25, 50, 100]"
                                               data-page-size="6"
                                               data-click-to-select="true"
                                               data-maintain-selected="true">
                                            <thead>
                                            <tr>
                                                <th data-field="id" data-sortable="true">ID</th>
                                                <th data-field="Nombre"  data-sortable="true">Nombre</th>
                                                <th data-field="Marca" data-sortable="true">Marca</th>
                                                <th data-field="Modelo" data-sortable="true">Modelo</th>
                                                <th data-field="NumeroSerie" data-sortable="true">No. Serie</th>
                                                <th data-field="NumeroInventario" data-sortable="true">No. Inventario</th>
                                                <th data-field="Observaciones" data-sortable="true">Observaciones</th>
                                                <th data-formatter="editFormatter" data-events="operateEvents">Editar</th>
                                                <th data-formatter="deleteFormatter" data-events="operateEvents">Eliminar</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="createEquipmentSource" class="btn btn-success">Crear un equipo</button>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Crear un equipo --}}
        <div class="modal fade" id="createEquipmentModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Administrador de equipos
                                    </div>
                                    <div class="panel-body">
                                        <div class="panel-body">
                                            <h2>Crear equipo</h2>
                                            <form ng-submit="addEquipment()">
                                                <div class="form-group">
                                                    <label for="name">Nombre:</label>
                                                    <input type="text" class="form-control" id="name" placeholder="Introducir nombre" required ng-model="equipmentCrud.nombre">
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="marca">Marca:</label>
                                                        <input type="text" class="form-control" id="marca" placeholder="Introducir marca" required ng-model="equipmentCrud.marca">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="modelo">Modelo:</label>
                                                        <input type="text" class="form-control" id="modelo" placeholder="Introducir modelo" required ng-model="equipmentCrud.modelo">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="serie">No. Serie:</label>
                                                        <input type="text" class="form-control" id="serie" placeholder="Introducir No. Serie" required ng-model="equipmentCrud.serie">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="inventario">No. Inventario:</label>
                                                        <input type="text" class="form-control" id="inventario" placeholder="Introducir No. Inventario" required ng-model="equipmentCrud.inventario">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{--<a href="#" ng-click="resetVariables()" data-dismiss="modal" class="btn btn-danger">Cerrar</a>--}}
                        <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Editar un equipo --}}
        <div class="modal fade" id="updateEquipmentModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Administrador de equipos
                                    </div>
                                    <div class="panel-body">
                                        <div class="panel-body">
                                            <h2>Editar equipo</h2>
                                            <form ng-submit="updateEquipment()">
                                                <div class="form-group">
                                                    <label for="name">Nombre:</label>
                                                    <input type="text" class="form-control" id="name" placeholder="Introducir nombre" required ng-model="equipmentCrud.nombre">
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="marca">Marca:</label>
                                                        <input type="text" class="form-control" id="marca" placeholder="Introducir marca" required ng-model="equipmentCrud.marca">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="modelo">Modelo:</label>
                                                        <input type="text" class="form-control" id="modelo" placeholder="Introducir modelo" required ng-model="equipmentCrud.modelo">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="serie">No. Serie:</label>
                                                        <input type="text" class="form-control" id="serie" placeholder="Introducir No. Serie" required ng-model="equipmentCrud.serie">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="inventario">No. Inventario:</label>
                                                        <input type="text" class="form-control" id="inventario" placeholder="Introducir No. Inventario" required ng-model="equipmentCrud.inventario">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="inventario">Observaciones:</label>
                                                        <textarea class="form-control" rows="5" id="observacion" placeholder="Introducir una observación" ng-model="equipmentCrud.observacion"></textarea>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{--<a href="#" ng-click="resetVariables()" data-dismiss="modal" class="btn btn-danger">Cerrar</a>--}}
                        <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla de equipos disponibles --}}
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                    <li class="active">Control</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Control de equipos</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Tabla de equipos:</div>
                        <div class="panel-body">
                            <table id="equipment_table"
                                   data-toggle="table"
                                   data-url="/search/equipos/"
                                   data-show-refresh="true"
                                   data-show-toggle="true"
                                   data-show-columns="true"
                                   data-search="true"
                                   data-select-item-name="toolbar1"
                                   data-pagination="true"
                                   data-sort-name="name"
                                   data-sort-order="desc"
                                   data-click-to-select="true"
                                   data-maintain-selected="true">
                                <thead>
                                <tr>
                                    <th data-checkbox="true" >ID</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="Nombre"  data-sortable="true">Nombre</th>
                                    <th data-field="Marca" data-sortable="true">Marca</th>
                                    <th data-field="Modelo" data-sortable="true">Modelo</th>
                                    <th data-field="NumeroSerie" data-sortable="true">No. Serie</th>
                                    <th data-field="NumeroInventario" data-sortable="true">No. Inventario</th>
                                    <th data-field="Observaciones" data-sortable="true">Observaciones</th>
                                    {{--<th data-field="Estado" data-sortable="true">Estado</th>--}}
                                </tr>
                                </thead>
                            </table>

                            <button class="btn btn-primary btn-block btn-lg" type="button" ng-click="typeAction()">Asignar</button>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Equipos más utilizados</div>
                                        <div class="panel-body">
                                            <div class="canvas-wrapper">
                                                <canvas class="main-chart" id="most-bar-chart" height="200" width="600"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Equipos menos utilizados</div>
                                        <div class="panel-body">
                                            <div class="canvas-wrapper">
                                                <canvas class="main-chart" id="least-bar-chart" height="200" width="600"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal de mantenimiento de equipos --}}
        <div class="modal fade" id="maintenanceModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h2>Tabla de equipos en mantenimiento:</h2>
                                    </div>
                                    <div class="panel-body">

                                        <table id="equipment_maintenance_table"
                                               data-toggle="table"
                                               data-url="/search/equipos/"
                                               data-show-refresh="true"
                                               data-show-toggle="true"
                                               data-show-columns="true"
                                               data-show-export="true"
                                               data-detail-view="true"
                                               data-search="true"
                                               data-pagination="true"
                                               data-sort-name="name"
                                               data-sort-order="desc"
                                               data-page-list="[5, 6, 10, 25, 50, 100]"
                                               data-page-size="6"
                                               data-click-to-select="true"
                                               data-maintain-selected="true">
                                            <thead>
                                            <tr>
                                                <th data-checkbox="true" >ID</th>
                                                <th data-field="id" data-sortable="true">ID</th>
                                                <th data-field="Nombre"  data-sortable="true">Nombre</th>
                                                <th data-field="Marca" data-sortable="true">Marca</th>
                                                <th data-field="Modelo" data-sortable="true">Modelo</th>
                                                <th data-field="NumeroSerie" data-sortable="true">No. Serie</th>
                                                <th data-field="NumeroInventario" data-sortable="true">No. Inventario</th>
                                                {{--<th data-formatter="editFormatter" data-events="operateEvents">Editar</th>--}}
                                                {{--<th data-formatter="deleteFormatter" data-events="operateEvents">Eliminar</th>--}}
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="sendMaintenanceSource" class="btn btn-success">Enviar a mantenimiento</button>
                        <button id="watchMaintenanceSource" class="btn btn-primary">Ver equipos en mantenimiento</button>
                    </div>
                    <div class="modal-footer">
                        <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal ver mantenimiento de equipos pendientes --}}
        <div class="modal fade" id="watch_maintenanceModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h2>Tabla de equipos en mantenimiento:</h2>
                                    </div>
                                    <div class="panel-body">

                                        <table id="equipment_maintenance_watch_table"
                                               data-toggle="table"
                                               data-url="/search/equipos/maintenance"
                                               data-show-refresh="true"
                                               data-show-toggle="true"
                                               data-show-columns="true"
                                               data-show-export="true"
                                               data-detail-view="true"
                                               data-search="true"
                                               data-pagination="true"
                                               data-sort-name="name"
                                               data-sort-order="desc"
                                               data-page-list="[5, 6, 10, 25, 50, 100]"
                                               data-page-size="6"
                                               data-click-to-select="true"
                                               data-maintain-selected="true">
                                            <thead>
                                            <tr>
                                                <th data-field="id" data-sortable="true">ID</th>
                                                <th data-field="Nombre"  data-sortable="true">Nombre</th>
                                                <th data-field="Marca" data-sortable="true">Marca</th>
                                                <th data-field="Modelo" data-sortable="true">Modelo</th>
                                                <th data-field="NumeroSerie" data-sortable="true">No. Serie</th>
                                                <th data-field="NumeroInventario" data-sortable="true">No. Inventario</th>
                                                {{--<th data-formatter="editFormatter" data-events="operateEvents">Editar</th>--}}
                                                <th data-formatter="deleteMaintenanceFormatter" data-events="operateEvents">Remover</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
            <ul class="nav menu">
                <li>
                    <a href="/">
                        <svg class="glyph stroked table">
                            <use xlink:href="#stroked-table"></use>
                        </svg>
                        Control de equipos
                    </a>
                </li>
                <li>
                    <a id="equipment" class="modal-click" href="#">
                        <svg class="glyph stroked desktop computer and mobile"><use xlink:href="#stroked-desktop-computer-and-mobile"/></svg>
                        Administrador de equipos
                    </a>
                </li>
                {{--<li>--}}
                {{--<a id="persons" class="modal-click" href="#">--}}
                {{--<svg class="glyph stroked male user "><use xlink:href="#stroked-male-user"/></svg>--}}
                {{--Administrador de personas--}}
                {{--</a>--}}
                {{--</li>--}}
                <li>
                    <a id="maintenance" class="modal-click" href="#">
                        <svg class="glyph stroked hourglass"><use xlink:href="#stroked-hourglass"/></svg>
                        Mantenimiento de equipos
                    </a>
                </li>
                <li>
                    <a id="assignments" class="modal-click" href="#">
                        <svg class="glyph stroked clock"><use xlink:href="#stroked-clock"/></svg>
                        Asignaciones pendientes
                    </a>
                </li>
                <li>
                    <a id="assignments_historial" class="modal-click" href="#">
                        <svg class="glyph stroked eye"><use xlink:href="#stroked-eye"/></svg>
                        Historial de asignaciones
                    </a>
                </li>
            </ul>
        </div>
    </div>
@stop