@section('cabecera')
Reportes
@endsection

@extends('layouts.app')

@section('content')

<div class="row justify-content-md-left">
    <h4>Reportes</h4>
</div>
<div class="row justify-content-md-left" id="contenedorReportes">

    <div class="col-md-12">
        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-reporte1-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reporte1" type="button" role="tab" aria-controls="v-pills-reporte1" aria-selected="true" style="text-align: left;">Información de usuarios</button>
                <button class="nav-link" id="v-pills-reporte2-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reporte2" type="button" role="tab" aria-controls="v-pills-reporte2" aria-selected="false" style="text-align: left;">Avance por usuario</button>
                <button class="nav-link" id="v-pills-reporte3-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reporte3" type="button" role="tab" aria-controls="v-pills-reporte3" aria-selected="false" style="text-align: left;">Preguntas por encuestas</button>
                <button class="nav-link" id="v-pills-reporte4-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reporte4" type="button" role="tab" aria-controls="v-pills-reporte4" aria-selected="false" style="text-align: left;">Resultados por encuesta</button>
            </div>
            <div class="tab-content" id="v-pills-tabContent" style="width:100%">
                <div class="tab-pane fade show active" id="v-pills-reporte1" role="tabpanel" aria-labelledby="v-pills-reporte1-tab">
                    @include('reportes.reporte_informacion_usuarios')
                </div>
                <div class="tab-pane fade" id="v-pills-reporte2" role="tabpanel" aria-labelledby="v-pills-reporte2-tab">
                    @include('reportes.reporte_avance_de_usuarios')
                </div>
                <div class="tab-pane fade" id="v-pills-reporte3" role="tabpanel" aria-labelledby="v-pills-reporte3-tab">
                    @include('reportes.reporte_preguntas_por_encuesta')
                </div>
                <div class="tab-pane fade" id="v-pills-reporte4" role="tabpanel" aria-labelledby="v-pills-reporte4-tab">
                    @include('reportes.reporte_resultados_por_encuesta')
                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@section('scripts')
<script src="{{ asset('js/reportes/reportes-model.js?v=1') }}"></script>
<script src="{{ asset('js/reportes/informacion_de_usuario-view.js?v=1') }}"></script>
<script src="{{ asset('js/reportes/avance_de_usuario-view.js?v=1') }}"></script>
<script src="{{ asset('js/reportes/preguntas_por_encuesta-view.js?v=1') }}"></script>
<script src="{{ asset('js/reportes/resultados_por_encuesta-view.js?v=1') }}"></script>
<script src="//cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<script>
    $(document).ready(function() {

        const informacionDeUsuarioView = new InformacionDeUsuarioView(new ReportesModel(csrf_token));
        informacionDeUsuarioView.listar();
        const avanceDeUsuarioView = new AvanceDeUsuarioView(new ReportesModel(csrf_token));
        avanceDeUsuarioView.listar();
        const preguntasPorEncuetaView = new PreguntasPorEncuetaView(new ReportesModel(csrf_token));
        preguntasPorEncuetaView.listar();
        const resultadosPorEncuestaView = new ResultadosPorEncuestaView(new ReportesModel(csrf_token));
        resultadosPorEncuestaView.eventos();
    });
</script>

@endsection