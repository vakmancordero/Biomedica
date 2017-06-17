<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">

    <!-- StyleSheet -->
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/bootstrap-3.3.7/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">

    <script src="{{ asset('lib/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('lib/angular.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lib/lumino.glyphs.js') }}"></script>
    <script src="{{ asset('lib/chart.min.js') }}"></script>

    @yield('stylesheets')

    @yield('javascript-before')

    <title>@yield('title')</title>

    <script>
        window.Laravel = <?php echo json_encode([
			'csrfToken' => csrf_token(),
		]); ?>
    </script>

</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Plataforma normada para equipamiento de laboratorio de ingeniería <span>Biomédica</span></a>
            <ul class="user-menu">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <svg class="glyph stroked male-user">
                            <use xlink:href="#stroked-male-user"></use>
                        </svg>
                        {{ Auth::user()->name }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        {{--<li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Perfil</a></li>--}}
                        {{--<li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Configuración</a></li>--}}
                        {{--<li><a href="#"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Salir</a></li>--}}
                        <li><a href="{{ url('/register') }}">
                                {{--<svg class="glyph stroked cancel">--}}
                                    {{--<use xlink:href="#stroked-cancel"></use>--}}
                                {{--</svg>--}}
                                <svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"/></svg>
                                Registrar
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg>
                                Cerrar sesión
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>


@yield('content')

<!-- JavaScript -->
<script src="lib/bootstrap-3.3.7/js/bootstrap-datepicker.js"></script>
<script src="lib/bootstrap-3.3.7/js/bootstrap-table.js"></script>

@yield('javascript')

</body>
</html>