<div class="modal fade" id="modalEditarAgregarUsuario" tabindex="-1" aria-labelledby="modalEditarAgregarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarAgregarUsuarioLabel"> <span id="titulo_modal_usuario"></span> usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formModalEditarAgregarUsuario" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" name="email" placeholder="">
                        </div>
                        <div class="col mb-3">
                            <label for="tipo_id" class="form-label">Tipo *</label>
                            <select class="form-control" name="tipo_id">
                                <option value="">Seleccione una opción</option>
                                @foreach ($tipoList as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="contraseña" class="form-label">Contraseña *</label>
                        <input type="password" class="form-control" name="contraseña" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" name="nombres" placeholder="">
                    </div>
                    <div class="row">

                        <div class="col mb-3">
                            <label for="apellido_paterno" class="form-label">Apellido paterno</label>
                            <input type="text" class="form-control" name="apellido_paterno" placeholder="">
                        </div>
                        <div class="col mb-3">
                            <label for="apellido_materno" class="form-label">Apellido materno</label>
                            <input type="text" class="form-control" name="apellido_materno" placeholder="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nro_documento" class="form-label">Nro documento</label>
                        <input type="text" class="form-control" name="nro_documento" placeholder="">
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input handleSwitchEstadoUsuario" type="checkbox" role="switch" name="estado" checked>
                        <label class="form-check-label" for="estado" name="texto_estado">Habilitado</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary handleClickGuardarCambios" data-evento="" id="btnGuardarUsuario">Editar</button>
            </div>
        </div>
    </div>
</div>