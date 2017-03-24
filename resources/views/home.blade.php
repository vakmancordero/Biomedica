@extends('layouts.template')

@section('javascript')
    <script src="lib/sweet/sweetalert2.min.js"></script>
    <script src="js/home.js"></script>
@stop

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/sweet/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}">
@stop

@section('content')
    <div ng-app="biomedicalApp" ng-controller="biomedicalController">
        <div class="modal fade bd-example-modal-lg" id="assignmentsModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Asignaciones</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h2 style="color: darkslategrey">Lista de asignaciones pendientes de entrega:</h2>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead class="thead-inverse">
                                            <tr>
                                                <th>ID</th>
                                                <th>Equipo</th>
                                                <th>Persona</th>
                                                <th>Responsable</th>
                                                <th>Estado</th>
                                                <th>Eliminar</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="assignment in assignments track by $index">
                                                <td>@{{assignment.id}}</td>
                                                <td>@{{assignment.equipo}}</td>
                                                <td>@{{assignment.persona}}</td>
                                                <td>@{{assignment.responsable}}</td>
                                                <td>@{{assignment.estado}}</td>
                                                <td ng-if="assignment.estado == 'activo'"><input type="button" ng-click="delete($index)" class="btn btn-danger btn-sm" value="Eliminar"></td>
                                                <td ng-if="assignment.estado != 'activo'"><input ng-disabled="true" type="button" ng-click="ver($index)" class="btn btn-danger btn-sm" value="Ver"></td>
                                            </tr>
                                            </tbody>
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
        <div class="modal fade" id="typeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
        <div class="modal fade" id="equipmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
                            <form>
                                <table id="bootstrap_table" data-toggle="table" data-url="/search/equipos/"  data-show-refresh="true"data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-click-to-select="true" >
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
                                        <th data-field="Estado" data-sortable="true">Estado</th>
                                    </tr>
                                    </thead>
                                </table>
                                <button class="btn btn-primary" type="button" ng-click="typeAction()">Asignar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
            <ul class="nav menu">
                <li class="">
                    <a href="/">
                        <svg class="glyph stroked table">
                            <use xlink:href="#stroked-table"></use>
                        </svg>
                        Control de equipos
                    </a>
                </li>
                <li class="">
                    <a id="assignments" href="/">
                        <svg class="glyph stroked clock"><use xlink:href="#stroked-clock"/></svg>
                        Registro de asignaciones
                    </a>
                </li>
            </ul>
        </div>
    </div>
@stop