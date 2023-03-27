<div class="card shadow-sm bg-body rounded">
    <div class="card-body">
        <h6 class="card-title text-center link-secondary"><strong>Resultados por encuesta</strong></h6>

        <div class="row">
            <div class="col-4">
                <label class="form-label">Encuesta por encuesta</label>
                <select class="form-control handleChangeEncuesta" name="encuesta_id" id="encuesta_id">
                    <option value="">Seleccione una opción</option>
                    @foreach ($encuestas as $encuesta)
                    <option value="{{$encuesta->id}}">De {{$encuesta->nombre}}</option>

                    @endforeach
                </select>
            </div>
        </div>
        <br>

        <div class="row" id="graficas_encuesta_liderazgo" hidden>

            <div class="col-md-4">
                <div class="card shadow-sm bg-body rounded">
                    <div class="card-body">
                        <h6 class="card-title text-center link-secondary"><strong>Recompensa contigente</strong></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="grafica_recompensa_contingente"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm bg-body rounded">
                    <div class="card-body">
                        <h6 class="card-title text-center link-secondary"><strong>Dirección por excepción</strong></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="grafica_direccion_por_excepcion"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card shadow-sm bg-body rounded">
                    <div class="card-body">
                        <h6 class="card-title text-center link-secondary"><strong>Carisma</strong></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="grafica_carisma"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm bg-body rounded">
                    <div class="card-body">
                        <h6 class="card-title text-center link-secondary"><strong>Estimulación intelectual</strong></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="grafica_estimulacion_intelectual"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm bg-body rounded">
                    <div class="card-body">
                        <h6 class="card-title text-center link-secondary"><strong>Inspiración</strong></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="grafica_inspiracion"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm bg-body rounded">
                    <div class="card-body">
                        <h6 class="card-title text-center link-secondary"><strong>Consideración individualizada</strong></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="grafica_consideracion_individualizada"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm bg-body rounded">
                    <div class="card-body">
                        <h6 class="card-title text-center link-secondary"><strong>Ausencia de liderazgo</strong></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="grafica_ausencia_de_liderazgo"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>










        </div>

        <br>
        <div class="table-responsive">
            <table class="table table-bordered table-condensed table-hover table-sm" id="tablaResultadosPorEncuesta" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Pregunta</th>
                        <th>Respuesta</th>
                        <th>Fecha respuesta</th>
                        <th>Encuesta</th>
                        <th>Muestreo</th>
                        <th>Fecha muestreo</th>
                        <th>Muestra</th>
                        <th>Muestra fecha inicio</th>
                        <th>Muestra fecha fin</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>