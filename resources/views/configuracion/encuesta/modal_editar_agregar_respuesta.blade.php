<div class="modal fade" id="modalEditarAgregarRespuesta" tabindex="-1" aria-labelledby="modalEditarAgregarRespuestaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarAgregarRespuestaLabel"><span id="titulo_modal_respuesta"></span> respuesta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formModalEditarAgregarRespuesta" enctype="multipart/form-data">
                @csrf
                    <input type="hidden" name="id">
                    <input type="hidden" name="pregunta_id">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control"  name="nombre" placeholder="">
                    </div>
    
                    <div class="form-check form-switch">
                    <input class="form-check-input handleSwitchEstadoRespuesta" type="checkbox" role="switch" name="estado" checked>
                    <label class="form-check-label" for="estado"  name="texto_estado">Habilitado</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary handleClickGuardarCambiosRespuesta" data-evento="" id="btnGuardarRespuesta">Editar</button>
            </div>
        </div>
    </div>
</div>