<div class="modal fade" id="modalEditarAgregarMuestreoFecha" tabindex="-1" aria-labelledby="modalEditarAgregarMuestreoFechaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarAgregarMuestreoFechaLabel"><span id="titulo_modal_muestreo_fecha"></span> fechas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formModalEditarAgregarMuestreoFecha" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="fechas" class="form-label">Fechas</label>

                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed table-hover" id="tablaFechas" width="100%">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha inicio</th>
                                            <th>Fecha fin</th>
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
            </div>
        </div>
    </div>
</div>