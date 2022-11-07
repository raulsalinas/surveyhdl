<div class="modal fade" id="modalAccesoUsuario" tabindex="-1" aria-labelledby="modalAccesoUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalAccesoUsuarioLabel"> <span id="titulo_modal_acceso_usuario"></span> acceso usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formModalAccesoUsuario" enctype="multipart/form-data">
                    @csrf

                    <div class="col mb-3" id="group-tipo" hidden>
                            <label for="tipo_id" class="form-label">Tipo *</label>
                            <select class="form-control" name="tipo_id">
                                <option value="">Seleccione una opción</option>
                                @foreach ($tipoList as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                @endforeach
                            </select>
                        </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Accesos de menú</h5>
                            <div class="card-text">
                                <input type="hidden" name="id">

                                <div class="mb-3">
                                    <label for="nro_documento" class="form-label">Principal</label>
                                    <div class="form-check form-switch">
                                        <input type="hidden"   name="acceso[1]" value="false" />
                                        <input class="form-check-input handleSwitchAccesoPrincipal" type="checkbox" role="switch" data-id-acceso="1">
                                        <label class="form-check-label" name="texto_estado_acceso_principal">Habilitado</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nro_documento" class="form-label">Dashboard</label>
                                    <div class="form-check form-switch">
                                        <input type="hidden"   name="acceso[2]" value="false" />
                                        <input class="form-check-input handleSwitchAccesoDashboard" type="checkbox" role="switch" data-id-acceso="2">
                                        <label class="form-check-label" name="texto_estado_acceso_dashboard">Habilitado</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nro_documento" class="form-label">Encuesta</label>
                                    <div class="form-check form-switch">
                                    <input type="hidden"   name="acceso[3]" value="false" />
                                        <input class="form-check-input handleSwitchAccesoEncuesta" type="checkbox" role="switch" data-id-acceso="3">
                                        <label class="form-check-label" name="texto_estado_acceso_encuesta">Habilitado</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nro_documento" class="form-label">Reportes</label>
                                    <div class="form-check form-switch">
                                        <input type="hidden"   name="acceso[4]" value="false" />
                                        <input class="form-check-input handleSwitchAccesoReportes" type="checkbox" role="switch" data-id-acceso="4">
                                        <label class="form-check-label" name="texto_estado_acceso_reportes">Habilitado</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nro_documento" class="form-label">Configuración</label>
                                    <div class="form-check form-switch">
                                    <input type="hidden"   name="acceso[5]" value="false" />
                                        <input class="form-check-input handleSwitchAccesoConfiguracion" type="checkbox" role="switch" data-id-acceso="5">
                                        <label class="form-check-label" name="texto_estado_acceso_configuracion">Habilitado</label>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>


                </form>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary handleClickGuardarCambios" data-evento="" id="btnGuardarUsuario">Actualizar</button>
            </div>
        </div>
    </div>
</div>