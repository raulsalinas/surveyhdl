@section('cabecera')
Encuesta
@endsection
@extends('layouts.app')

@section('content')
<div class="row justify-content-md-left" id="contenedorEncuesta">
    <row class="col-md-12">

        <div class="card">
            <div class="card-header text-center">
                <div class="row justify-content-md-center" style="align-items: baseline;align-items: baseline;text-transform: uppercase;">
                    <div class="col col-lg-2">
                        <button type="button" class="btn btn-outline-primary handlePreviousPage"><i class="fas fa-angle-left"></i> Previo</button>
                    </div>
                    <div class="col-md-auto bold">
                        <h6><span id="nombre_tipo_encuesta"></span> (<span id="pregunta_actual">0</span>/<span id="total_preguntas">0</span>)</h6>
                    </div>
                    <div class="col col-lg-2">
                        <button type="button" class="btn btn-outline-primary handleNextPage">Siguiente <i class="fas fa-angle-right"></i></button>

                    </div>
                </div>


            </div>
            <div class="card-body">
                <h4 class="card-title text-center" id="contenedorNombrePregunta"></h4>

                <div class="row justify-content-md-center">
                    <div class="col col-lg-2">

                    </div>
                    <div class="col-md-auto" id="contenedorRespuestas">
                        <!-- <div class="custom-control-input">
                            <input class="custom-control-input-input handleRadioButtonRespuesta" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                            <label class="custom-control-input-label" for="exampleRadios1">
                                Nunca
                            </label>
                        </div>
                        <div class="custom-control-input">
                            <input class="custom-control-input-input handleRadioButtonRespuesta" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                            <label class="custom-control-input-label" for="exampleRadios2">
                                Rara vez
                            </label>
                        </div>
                        <div class="custom-control-input">
                            <input class="custom-control-input-input handleRadioButtonRespuesta" type="radio" name="exampleRadios" id="exampleRadios3" value="option3">
                            <label class="custom-control-input-label" for="exampleRadios3">
                                A Veces
                            </label>
                        </div>
                        <div class="custom-control-input">
                            <input class="custom-control-input-input handleRadioButtonRespuesta" type="radio" name="exampleRadios" id="exampleRadios4" value="option4">
                            <label class="custom-control-input-label" for="exampleRadios4">
                                A menudo
                            </label>
                        </div>
                        <div class="custom-control-input">
                            <input class="custom-control-input-input handleRadioButtonRespuesta" type="radio" name="exampleRadios" id="exampleRadios5" value="option5">
                            <label class="custom-control-input-label" for="exampleRadios5">
                                Siempre
                            </label>
                        </div> -->

                    </div>
                    <div class="col col-lg-2">

                    </div>
                </div>
            </div>

        </div>
    </row>
</div>
<br>
<div class="row justify-content-md-center" id="infoAvanceEncuesta">
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-center link-secondary">Porcentaje de Avance</h6>
                <p class="card-text text-center link-success"><i class="fas fa-chevron-up"></i> <span id="porcentajeAvance">%0</span> </p>

            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-center link-secondary">Preguntas sin contestar</h6>
                <p class="card-text text-center link-danger"><i class="fa-solid fa-chevron-down"></i> <span id="cantidadPreguntasSinContestar">0</span> </p>

            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-center link-secondary">Preguntas contestadas</h6>
                <p class="card-text text-center link-success"><i class="fas fa-chevron-up"></i> <span id="cantidadPreguntasContestadas">0</span> </p>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/encuestas/llenar_encuesta-view.js?v=1') }}"></script>
<script src="{{ asset('js/encuestas/llenar_encuesta-model.js?v=1') }}"></script>

<script>
    $(document).ready(function() {
        const llenarEncuestaView = new LlenarEncuestaView(new LlenarEncuestaModel(csrf_token));
        llenarEncuestaView.listarPreguntas();
        llenarEncuestaView.mostrarInformacionDeAvance();
        llenarEncuestaView.eventos();
    });
</script>

@endsection