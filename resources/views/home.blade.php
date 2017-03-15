@extends('layouts.template')

@section('javascript')
    <script src="js/home.js"></script>
@stop

@section('content')

    <div ng-app="biomedicalApp" ng-controller="biomedicalController">
        <div class="modal fade" id="mostrarmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Asignar a:</h3>
                    </div>
                    <div class="modal-body">
                        <button class="button alumnoButton">Alumno</button>
                        <button class="button docenteButton">Docente</button>
                    </div>
                    <div class="modal-footer">
                        <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

            <ul class="nav menu">
                <li class="active">
                    <a href="/">
                        <svg class="glyph stroked table">
                            <use xlink:href="#stroked-table"></use>
                        </svg>
                        Control
                    </a>
                </li>
            </ul>
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
                        <div class="panel-heading">Tabla de equipos</div>
                        <div class="panel-body">
                            <table id="table" data-toggle="table" data-url="/search/equipos/"  data-show-refresh="true"data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-click-to-select="true" >
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
                            <button class="button asignar2">Asignar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop