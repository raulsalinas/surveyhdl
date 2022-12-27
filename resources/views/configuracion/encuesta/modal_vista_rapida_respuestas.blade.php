<div class="modal fade" id="modalVistaRapidaRespuestas" tabindex="-1" aria-labelledby="modalVistaRapidaRespuestasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalVistaRapidaRespuestasLabel"> Respuestas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formModalVistaRapidaRespuestas">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed table-hover table-sm" id="tablaRespuestas" width="100%">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>#</th>
                                            <th width="50%">Respuesta</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning handleClicAplicarParaTodasLasPreguntas" data-evento="" id="btnGuardarPregunta">Aplicar mismas respuestas para todas las preguntas</button>
            </div>
        </div>
    </div>
</div>