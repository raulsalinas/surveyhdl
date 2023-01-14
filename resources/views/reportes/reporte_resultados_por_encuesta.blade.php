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