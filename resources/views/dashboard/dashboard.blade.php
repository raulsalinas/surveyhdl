@section('cabecera')
Dashboard
@endsection

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm bg-body rounded">
                        <div class="card-body">
                            <h6 class="card-title text-center link-secondary">Total Usuarios Activos</h6>
                            <p class="card-text text-center link-success"><i class="fas fa-chevron-up"></i> <span id="totalUsuariosActivos">0</span> </p>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm bg-body rounded">
                        <div class="card-body">
                            <h6 class="card-title text-center link-secondary">Encuestas Activas</h6>
                            <p class="card-text text-center link-success"><i class="fas fa-chevron-up"></i> <span id="totalEncuestasActivas">0</span> </p>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm bg-body rounded">
                        <div class="card-body">
                            <h6 class="card-title text-center link-secondary">Muestras Activas</h6>
                            <p class="card-text text-center link-success"><i class="fas fa-chevron-up"></i> <span id="totalMuestrasActivas">0</span> </p>

                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card shadow-sm bg-body rounded">
                        <div class="card-body">
                            <h6 class="card-title text-center link-secondary"><strong>Básica por Usuario</strong></h6>

                            <div class="row justify-content-center">
                                <div class="col-md-4">
                                    <div class="card shadow bg-body rounded">
                                        <div class="card-body">
                                            <h6 class="card-title text-center link-secondary">Usuarios activos</h6>
                                            <p class="card-text text-center link-success"><i class="fas fa-chevron-up"></i> <span id="CantidadUsuariosActivos">0</span> </p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card shadow bg-body rounded">
                                        <div class="card-body">
                                            <h6 class="card-title text-center link-secondary">Usuarios dados de baja</h6>
                                            <p class="card-text text-center link-danger"><i class="fas fa-chevron-down"></i> <span id="CantidadUsuariosDeBaja">0</span> </p>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed table-hover table-sm" id="tablaUsuarios" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Usuario</th>
                                                <th>Cant. ingresos</th>
                                                <th>Nombre muestras</th>
                                                <th>Nombre encuestas</th>
                                                <th>Cant. encuestas</th>
                                                <th>Cant. respuestas</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm bg-body rounded">
                        <div class="card-body">
                            <h6 class="card-title text-center link-secondary"><strong>Porcentaje de Avance</strong></h6>

                            <table class="table table-bordered table-condensed table-hover table-sm" id="tablaAvanceDeUsuarios" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nombre usuario</th>
                                        <th>Muestreo</th>
                                        <th>Encuesta</th>
                                        <th>%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="card shadow-sm bg-body rounded">
                <div class="card-body">
                    <h6 class="card-title text-center link-secondary"><strong>Resultados por Usuario</strong></h6>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Encuesta</label>
                                <select class="form-control handleChangeEncuesta" id="id_encuesta">
                                    <option value="">Seleccionar una opción</option>
                                    @foreach ($encuestas as $encuesta)
                                    <option value="{{$encuesta->id}}">{{$encuesta->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Usuario</label>
                                <select class="form-control handleChangeUsuario select2" id="id_usuario">
                                    <option value="">Seleccionar una opción</option>
                                    @foreach ($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->personal->nombres}} {{$usuario->personal->apellido_paterno}} {{$usuario->personal->apellido_materno}}</option>
                                    @endforeach
                                </select>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <canvas id="grafica"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div>






    </div>
</div>
@endsection
@section('scripts')
<script src="//cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<script src="{{ asset('js/dashboard/dashboard-view.js?v=1') }}"></script>
<script src="{{ asset('js/dashboard/dashboard-model.js?v=1') }}"></script>

<script>
    $(document).ready(function() {


        const dashboardView = new DashboardView(new DashboardModel(csrf_token));
        dashboardView.obtenerCifrasTotales();
        dashboardView.obtenerCantidadUsuariosActivosYBajas();
        dashboardView.listarInformacionPorUsuarios();
        dashboardView.obtenerAvanceDeUsuarios();
        // dashboardView.llenarSelectPregunta(document.querySelector("select[id='id_encuesta']").value);
        // dashboardView.actualizarlistarResultadosPorPregunta();
        dashboardView.eventos();

    });
</script>

@endsection