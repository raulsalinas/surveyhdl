<div class="modal fade" id="modalEditarAgregarMuestreo" tabindex="-1" aria-labelledby="modalEditarAgregarMuestreoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarAgregarMuestreoLabel"><span id="titulo_modal_muestreo"></span> muestreo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formModalEditarAgregarMuestreo" enctype="multipart/form-data">
                @csrf
                    <input type="hidden" name="id">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control"  name="nombre" placeholder="">
                    </div>
    
                    <div class="form-check form-switch">
                    <input class="form-check-input handleSwitchEstadoMuestreo" type="checkbox" role="switch" name="estado" checked>
                    <label class="form-check-label" for="estado"  name="texto_estado">Habilitado</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary handleClickGuardarCambios" data-evento="" id="btnGuardarMuestreo">Editar</button>
            </div>
        </div>
    </div>
</div>