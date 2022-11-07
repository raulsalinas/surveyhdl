<div class="modal fade" id="modalEditarAgregarFecha" tabindex="-1" aria-labelledby="modalEditarAgregarFechaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarAgregarFechaLabel"><span id="titulo_modal_fecha"></span> fecha</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formModalEditarAgregarFecha" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="fecha_fin" class="form-label">Fecha fin</label>
                        <input type="date" class="form-control" name="fecha_fin" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="muestreo" class="form-label">Muestreo</label>
                        <input type="text" class="form-control" name="muestreo" placeholder="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="encuesta" class="form-label">Encuesta</label>
                        <input type="text" class="form-control" name="encuesta" placeholder="" readonly>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input handleSwitchEstadoFecha" type="checkbox" role="switch" name="estado" checked>
                        <label class="form-check-label" for="estado" name="texto_estado">Habilitado</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary handleClickGuardarCambios" data-evento="" id="btnGuardarFecha">Editar</button>
            </div>
        </div>
    </div>
</div>