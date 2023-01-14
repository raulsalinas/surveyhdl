<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="w-25 p-1" src="{{ url('images/logo_blue.png') }}" alt="HDL">

        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @guest
                @if (Route::has('login'))
                <li class="nav-item"><a class="nav-link" data-bs-toggle="modal" data-bs-target="#sobreHDLModal">Sobre HDL</a></li>
                @endif
                @else
                @if(Auth::user()->tieneAcceso(1))
                <li class="nav-item"><a class="nav-link" href="{{ route('principal.index') }}">Principal</a></li>
                @endif
                @if(Auth::user()->tieneAcceso(2))
                <li class="nav-item"><a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a></li>
                @endif
                @if(Auth::user()->tieneAcceso(3))
                <li class="nav-item"><a class="nav-link" href="{{ route('encuestas.muestreo.index') }}">Encuestas</a></li>
                @endif
                @if(Auth::user()->tieneAcceso(4))
                <li class="nav-item"><a class="nav-link" href="{{ route('reportes.index') }}">Reportes</a></li>
                @endif
                @if(Auth::user()->tieneAcceso(5))
                <li class="nav-item"><a class="nav-link" href="{{ route('configuracion.index') }}">Configuración</a></li>
                @endif
                <li class="nav-item"><a class="nav-link" data-bs-toggle="modal" href="#" data-bs-target="#sobreHDLModal">Sobre HDL</a></li>

                @endguest
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif

                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->personal->nombres }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Cerrar sesión') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>


<!-- Modal -->
<div class="modal fade" id="sobreHDLModal" tabindex="-1" aria-labelledby="sobreHDLModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="sobreHDLModalLabel"><i class="fa-solid fa-circle-info" style="color:cornflowerblue;"></i> DHL</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled">
                    <li class="font-monospace">Version: 1.0.0</li>
                    <li class="font-monospace">Fecha: 27-12-2022</li>
                    <li class="font-monospace">Php: 7.4.29</li>
                    <li class="font-monospace">Laravel: 8.83.25</li>
                    <li class="font-monospace">Postgres: 13.1</li>
                    <li class="font-monospace">Bootstrap: 5.1.3</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>