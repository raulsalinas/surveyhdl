<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ url('images/favicon.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('cabecera') - {{ config('app.name', 'HDL') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.2.0-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lobibox/dist/css/lobibox.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('layouts.navigation')

        <main class="p-4">
            @yield('content')
        </main>
    </div>

        <script src="{{ asset('assets/fontawesome-free-6.2.0-web/js/all.min.js') }}"></script>
        <script src="{{ asset('assets/jQuery-3.6.0/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/moment/moment.min.js') }}"></script>
        <script src="{{ asset('assets/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/loadingoverlay/loadingoverlay.min.js') }}"></script>
        <script src="{{ asset('assets/lobibox/dist/js/lobibox.min.js') }}"></script>
        <script src="{{ asset('js/event.js') }}"></script>

        <script>
            var auth_user = <?= $auth_user ?>;
            let csrf_token = '{{ csrf_token() }}';
            const idioma = {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate":
                {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria":
                {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            };
        </script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> -->
        <script src="{{ asset('js/app.js') }}"></script>

        @routes
        @yield("scripts")

</body>
</html>
