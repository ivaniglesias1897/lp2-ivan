<x-laravel-ui-adminlte::adminlte-layout>

    <head>
        <title>LP2</title>
        <link rel="icon"
            href="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Laravel.svg/1200px-Laravel.svg.png"
            type="image/x-icon">
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Main Header -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img src="https://assets.infyom.com/logo/blue_logo_150x150.png"
                                class="user-image img-circle elevation-2" alt="User Image">
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <!-- User image -->
                            <li class="user-header bg-primary">
                                <img src="https://assets.infyom.com/logo/blue_logo_150x150.png"
                                    class="img-circle elevation-2" alt="User Image">
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <a href="#" class="btn btn-default btn-flat float-right"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Left side column. contains the logo and sidebar -->
            @include('layouts.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>

            <!-- Main Footer -->
            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                    <b>Version</b> 3.1.0
                </div>
                <strong>Copyright &copy; 2014-2023 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
                reserved.
            </footer>
        </div>

        <!-- REQUIRED SCRIPTS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- CARGAR CODIGO JAVA SCRIPTS DESDE LOS BLADES -->
        @stack('scripts')
        <!-- CUSTOM SCRIPTS -->
        <script>
            //formato de numeros separador de miles
            function format(input) {
                // Eliminar puntos previos para evitar problemas con el replace
                var num = input.value.replace(/\./g, '');

                // Verificar si el valor es un número válido
                if (!isNaN(num)) {
                    // Invertir el string y aplicar la lógica del separador de miles
                    num = num.split('').reverse().join('') // Invertir el número
                        .replace(/(\d{3})(?=\d)/g, '$1.') // Agregar el punto cada 3 dígitos
                        .split('').reverse().join(''); // Volver a invertir

                    // Asignar el valor formateado al campo de entrada
                    input.value = num;
                } else {
                    // Mostrar alerta y limpiar caracteres no numéricos
                    alert("Por favor, introduce un número válido");
                    input.value = input.value.replace(/[^\d]/g, ''); // Limpiar cualquier carácter no numérico
                }
            }
        </script>
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
