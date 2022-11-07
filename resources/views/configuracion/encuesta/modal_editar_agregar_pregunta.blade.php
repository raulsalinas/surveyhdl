<div class="modal fade" id="modalEditarAgregarPregunta" tabindex="-1" aria-labelledby="modalEditarAgregarPreguntaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarAgregarPreguntaLabel"><span id="titulo_modal_pregunta"></span> pregunta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formModalEditarAgregarPregunta" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" placeholder="">
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input handleSwitchEstadoPregunta" type="checkbox" role="switch" name="estado" checked>
                        <label class="form-check-label" for="estado" name="texto_estado">Habilitado</label>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="respuesta_unica" class="form-label">Respuesta única</label>
                                <input type="text" class="form-control" name="respuesta_unica" placeholder="">
                            </div>

                            <label for="nombre" class="form-label">Respuestas</label>

                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed table-hover" id="tablaRespuesta" width="100%">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>#</th>
                                            <th width="50%">Respuesta</th>
                                            <th>Fecha anulación</th>
                                            <th>Acción</th>
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
                <button type="button" class="btn btn-primary handleClickGuardarCambios" data-evento="" id="btnGuardarPregunta">Editar</button>
            </div>
        </div>
    </div>
</div>