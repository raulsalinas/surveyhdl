<div class="modal fade" id="modalEditarAgregarMuestra" tabindex="-1" aria-labelledby="modalEditarAgregarMuestraLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarAgregarMuestraLabel"><span id="titulo_modal_muestra"></span> muestra</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formModalEditarAgregarMuestra" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="fecha_id" class="form-label">Fecha</label>
                        <select class="form-control" name="fecha_id">
                            <option value="">Seleccione una opción</option>
                            @foreach ($fechaList as $fecha)
                            <option value="{{$fecha->id}}">De {{$fecha->fecha_inicio}} Hasta {{$fecha->fecha_fin}}</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="personal_id" class="form-label">Personal</label>
                        <select class="form-control" name="personal_id">
                            <option value="">Seleccione una opción</option>
                            @foreach ($personalList as $personal)
                            <option value="{{$personal->id}}">{{$personal->nombre}} {{$personal->apellido_paterno}} {{$personal->apellido_materno}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input handleSwitchEstadoMuestra" type="checkbox" role="switch" name="estado" checked>
                        <label class="form-check-label" for="estado" name="texto_estado">Habilitado</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary handleClickGuardarCambios" data-evento="" id="btnGuardarMuestra">Editar</button>
            </div>
        </div>
    </div>
</div>