<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ url('images/favicon.png') }}">

    <title>HDL</title>

    <!-- Fonts -->
    <link href="//fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="{{ asset('css/GalleryOnGrids.css') }}" rel="stylesheet">

</head>

<body class="antialiased">



    <div class="container py-4">


        <div class="row">
            <div class="col-8">
                <div class="p-5 mb-4 bg-light rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 fw-bold">HDL</h1>
                        <p class="col-md-8 fs-4">Le presentamos el servicio para evaluación del personal de salud en un determinado periodo de tiempo, con preguntas sencillas que nos ayudarán a implementar mejoras, cambios que harán sentirse más cómodo en su lugar de trabajo..</p>
                        @if (Route::has('login'))
                        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                            @auth
                            <a href="{{ url('/principal/index') }}" class="btn btn-primary btn-lg">Ir a página principal</a>
                            @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Iniciar sesión</a>
                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 btn btn-primary btn-lg">Registrarse</a>
                            @endif
                            @endauth
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="wrapper">
                    <img src="//fitls.com/wp-content/uploads/2019/08/satisfaccion-laboral-beneficios.jpg" alt="">
                    <img src="//www.sesamehr.mx/wp-content/uploads/2021/07/como-medir-la-satisfaccion-laboral.jpg" alt="">
                    <img src="//cuidatusaludcondiane.com/wp-content/uploads/2011/11/empleado-feliz.jpg" alt="">
                    <img src="//www.techtitute.com/techtitute/cursos/011221538/recursos/banner/liderazgo-gestion-servicios-enfermeria-portada.jpg" alt="">
                    <img src="//www.unir.net/wp-content/uploads/sites/22/2021/07/shutterstock_400845949.jpg" alt="">
                    <img src="//newmedicalleaders.com/wp-content/uploads/2020/09/40-new-medical-leaders.jpg" alt="">
                    <img src="//www.feminiza.com/imagenes/contenidos/1/4/4/8/1448.jpg" alt="">
                    <img src="//static.theceomagazine.net/wp-content/uploads/2018/10/23145603/2018.09.27_CEO-Magazine-byline_Happiness-at-work-%E2%80%93-is-it-natural-or-necessary_subbed-700x467.jpg" alt="">
                    <img src="//www.hubgets.com/blog/wp-content/uploads/happiness_at_work.png" alt="">
                    <img src="//as2.ftcdn.net/v2/jpg/03/35/82/27/1000_F_335822779_FdvdknOoWPF3oSJfUs18VAPBQyuiO98U.jpg" alt="">
                </div>
            </div>
        </div>


        <div class="row align-items-md-stretch">
            <div class="col-md-6">
                <div class="h-100 p-5 text-white bg-dark rounded-3">
                    <h2>Todo listo!</h2>
                    <p>Ten confianza que alcanzaremos esos objetivos y mejoras que buscas</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="h-100 p-5 bg-light border rounded-3">
                    <h2>Contamos con un gran servicio</h2>
                    <p>Estamos listo para trabajar juntos y brindarle un servicio donde se sienta seguro que tomaremos en cuenta todo lo que nos tenga que decir. Estamos para evolucionar juntos</p>
                </div>
            </div>
        </div>

        <footer class="pt-3 mt-4 text-muted border-top">
            &copy; 2023 v1.0.0
        </footer>
    </div>
</body>

</html>