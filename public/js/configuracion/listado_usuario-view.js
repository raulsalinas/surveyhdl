class ListadoUsuarioView {

    constructor(model) {
        this.model = model;
    }

    listar = () => {

        const $tablaUsuario = $('#tablaUsuario').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            lengthChange: false,
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 Linhas', '25 Linhas', '50 Linhas', 'Mostrar todas']
            ],
            buttons: [
                { extend: 'excel', text: 'Excel' },
                { extend: 'pdf', text: 'PDF', title: 'Lista de Usuarios',  orientation: 'landscape' ,pageSize: 'LEGAL',      exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6,7,8,9 ]
                } },
        
                // {extend:'print', text:'Imprimir'},
                {
                    text: '<i class="fas fa-plus"></i> Agregar',
                    action: () => {
                        this.limpiarModalEditarUsuario();
                        this.actualizarEstadoInputSwitch('modalEditarAgregarUsuario',true);
                        $("#modalEditarAgregarUsuario").modal("show");
                        $("#btnGuardarUsuario").attr("data-evento", "registrar");
                        $("#btnGuardarUsuario").html("Registrar");
                        $("#btnGuardarUsuario").prop("disabled", false);
                        $("#titulo_modal_usuario").html("Registrar");
                    },
                    className: 'btn btn-sm btn-success nuevo',
                },
                {
                    text: '<i class="fa-solid fa-user-gear"></i> Acceso por tipo de usuario',
                    action: () => {
                        this.limpiarModalAccesoUsuario();
                        // this.actualizarEstadoInputSwitch('modalEditarAgregarUsuario',true);
                        $("#modalAccesoUsuario").modal("show");
                        // document.querySelector("div[id='modalEditarAgregarUsuario'] select[name='tipo_id']").value="";

                        // $("#btnGuardarUsuario").attr("data-evento", "registrar");
                        // $("#btnGuardarUsuario").html("Registrar");
                        $("#group-tipo").prop("hidden", false);
                        $("#titulo_modal_acceso_usuario").html("Actualizar");
                    },
                    className: 'btn btn-sm btn-info acceso-por-tipo',
                }
            ],
            pageLength: 20,

            language: idioma,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaUsuario_filter');
                const $input = $filter.find('input');
                $input.addClass("border border-secondary");
                $filter.append('<button id="btnBuscar" class="btn btn-default border border-secondary btn-sm pull-right" type="button"><i class="fas fa-search"></i></button>');
                $input.off();
                $input.on('keyup', (e) => {
                    if (e.key == 'Enter') {
                        $('#btnBuscar').trigger('click');
                    }
                });
                $('#btnBuscar').on('click', (e) => {
                    $tablaUsuario.search($input.val()).draw();
                });
            },
            drawCallback: function (settings) {
                $('#tablaUsuario_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaUsuario_filter input').trigger('focus');
            },
            order: [0, 'asc'],
            ajax: {
                url: route('configuracion.usuario.listar'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    data: 'id', render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: true, searchable: false, className: 'text-center'
                },
                { data: 'personal.tipo.nombre', name: 'personal.tipo.nombre', className: 'text-center', defaultContent: '' },
                { data: 'personal.nombres', name: 'personal.nombres', className: 'text-center', defaultContent: '' },
                { data: 'personal.apellido_paterno', name: 'personal.apellido_paterno', className: 'text-center', defaultContent: '' },
                { data: 'personal.apellido_materno', name: 'personal.apellido_materno', className: 'text-center', defaultContent: '' },
                { data: 'email', name: 'email', className: 'text-center', defaultContent: '' },
                { data: 'personal.nro_documento', name: 'personal.nro_documento', className: 'text-center', defaultContent: '' },
                { data: 'created_at', className: 'text-center' },
                { data: 'updated_at', className: 'text-center' },
                { data: 'deleted_at', orderable: false, searchable: false, className: 'text-center' },
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
            ],
            "autoWidth": false
        });

        $tablaUsuario.buttons().container().appendTo('#tablaUsuario_wrapper .col-md-6:eq(0)');


    }

    eventos = () => {

        $("#tablaUsuario").on("click", "button.editar-usuario", (e) => {
            $("#modalEditarAgregarUsuario").modal("show");
            this.obtenerUsuario(e.currentTarget.dataset.id);
            $("#btnGuardarUsuario").attr("data-evento", "editar");
            $("#btnGuardarUsuario").prop("disabled", false);
            $("#titulo_modal_usuario").html("Editar");
            $("#btnGuardarUsuario").html("Editar");
        });
        $("#tablaUsuario").on("click", "button.acceso-usuario", (e) => {
            $("#modalAccesoUsuario").modal("show");
            this.obtenerAccesoUsuario(e.currentTarget.dataset.id);
            $("#titulo_modal_acceso_usuario").html("Actualizar");
            $("#group-tipo").prop("hidden", true);

            // $("#btnGuardarAccesoUsuario").attr("data-evento", "editar");
            // $("#btnGuardarAccesoUsuario").prop("disabled", false);
            // $("#btnGuardarAccesoUsuario").html("Editar");
        });
        $("#modalAccesoUsuario").on("click", "input.handleSwitchAccesoPrincipal", (e) => {
            this.actualizarAccesoPrincipalInputSwitch(e.currentTarget.checked);

            if (e.currentTarget.checked === true) {
                e.currentTarget.closest("div").querySelector("input").value = true;
            } else {
                e.currentTarget.closest("div").querySelector("input").value = false;

            }
        });
        $("#modalAccesoUsuario").on("click", "input.handleSwitchAccesoDashboard", (e) => {
            this.actualizarAccesoDashboardInputSwitch(e.currentTarget.checked);
            if (e.currentTarget.checked === true) {
                e.currentTarget.closest("div").querySelector("input").value = true;
            } else {
                e.currentTarget.closest("div").querySelector("input").value = false;

            }
        });
        $("#modalAccesoUsuario").on("click", "input.handleSwitchAccesoEncuesta", (e) => {
            this.actualizarAccesoEncuestaInputSwitch(e.currentTarget.checked);
            if (e.currentTarget.checked === true) {
                e.currentTarget.closest("div").querySelector("input").value = true;
            } else {
                e.currentTarget.closest("div").querySelector("input").value = false;

            }
        });
        $("#modalAccesoUsuario").on("click", "input.handleSwitchAccesoReportes", (e) => {
            this.actualizarAccesoReportesInputSwitch(e.currentTarget.checked);
            if (e.currentTarget.checked === true) {
                e.currentTarget.closest("div").querySelector("input").value = true;
            } else {
                e.currentTarget.closest("div").querySelector("input").value = false;
            }
        });

        $("#modalAccesoUsuario").on("click", "input.handleSwitchAccesoConfiguracion", (e) => {
            this.actualizarAccesoConfiguracionInputSwitch(e.currentTarget.checked);
            if (e.currentTarget.checked === true) {
                e.currentTarget.value = 1;
            } else {
                e.currentTarget.value = 0;

            }
        });


        $("#modalEditarAgregarUsuario").on("click", "input.handleSwitchEstadoUsuario", (e) => {
            this.actualizarEstadoInputSwitch('modalEditarAgregarUsuario',e.currentTarget.checked);
            if (e.currentTarget.checked === true) {
                e.currentTarget.value = 1;
            } else {
                e.currentTarget.value = 0;

            }
        });


        $("#modalEditarAgregarUsuario").on("click", "button.handleClickGuardarCambios", (e) => {

            let formData = new FormData($('#formModalEditarAgregarUsuario')[0]);
            // validar campos
            let inputEmail = document.querySelector("div[id='modalEditarAgregarUsuario'] input[name='email']").value;
            let inputTipoUsuario = document.querySelector("div[id='modalEditarAgregarUsuario'] select[name='tipo_id']").value;
            let inputContraseña = document.querySelector("div[id='modalEditarAgregarUsuario'] input[name='contraseña']").value;
            let $inputEmailValido = true;
            let $inputTipoUsuario = true;
            let $inputContraseña = true;

            if (inputEmail == null || inputEmail.trim().length == 0) {
                Util.mensaje('warning', 'Debe ingresar un email');
                $inputEmailValido = false;
            }
            if (inputTipoUsuario == null || inputTipoUsuario.trim().length == 0) {
                Util.mensaje('warning', 'Debe seleccionar un tipo');
                $inputTipoUsuario = false;
            }
            if (inputContraseña == null || inputContraseña.trim().length == 0) {
                Util.mensaje('warning', 'Debe ingresar una contraseña');
                $inputContraseña = false;
            }

            if ($inputEmailValido, $inputContraseña, $inputTipoUsuario == true) {
                const $route = route("configuracion.usuario.guardar");
                let $mensaje = ($(e.currentTarget).data("evento") == "registrar") ? "Registrar" : "Editar";
                let $btnNombre = ($(e.currentTarget).data("evento") == "registrar") ? "Registrando" : "Editando";

                $("#btnGuardarUsuario").attr("disabled", true);
                $("#btnGuardarUsuario").html(Util.generarPuntosSvg() + $mensaje);

                this.model.registrarUsuario(formData, $route).then((respuesta) => {
                    Util.mensaje(respuesta.alerta, respuesta.mensaje);
                    if (respuesta.respuesta == "ok") {
                        $('#tablaUsuario').DataTable().ajax.reload(null, false);
                        $("#modalEditarAgregarUsuario").modal("hide");
                    } else if (respuesta.respuesta == "duplicado") {
                        $("#btnGuardarUsuario").html($btnNombre);
                        $("#btnGuardarUsuario").prop("disabled", false);
                    }
                }).fail(() => {
                    console.log("error");
                    Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
                }).always(() => {
                    $("#btnGuardarUsuario").html($mensaje);
                });
            }

        });

        $("#modalAccesoUsuario").on("click", "button.handleClickGuardarCambios", (e) => {
            let formData = new FormData($('#formModalAccesoUsuario')[0]);

            const $route = route("configuracion.usuario.actualizar_acceso");

            $("#btnGuardarUsuario").attr("disabled", true);
            $("#btnGuardarUsuario").html(Util.generarPuntosSvg() + 'Actualizando');

            this.model.registrarAccesoUsuario(formData, $route).then((respuesta) => {
                Util.mensaje(respuesta.alerta, 'Actualizar');
                if (respuesta.respuesta == "ok") {
                    $("#modalEditarAgregarUsuario").modal("hide");
                } else {
                    $("#btnGuardarUsuario").html($btnNombre);
                    $("#btnGuardarUsuario").prop("disabled", false);
                }
            }).fail(() => {
                console.log("error");
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
                $("#btnGuardarUsuario").html('Actualizar');
            });

        });
    }

    actualizarAccesoPrincipalInputSwitch(estado) {
        if (estado == true) {
            document.querySelector("div[id='modalAccesoUsuario'] label[name='texto_estado_acceso_principal']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='modalAccesoUsuario'] label[name='texto_estado_acceso_principal']").textContent = "Deshabilitado";
        }
    }
    actualizarAccesoDashboardInputSwitch(estado) {
        if (estado == true) {
            document.querySelector("div[id='modalAccesoUsuario'] label[name='texto_estado_acceso_dashboard']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='modalAccesoUsuario'] label[name='texto_estado_acceso_dashboard']").textContent = "Deshabilitado";
        }
    }
    actualizarAccesoEncuestaInputSwitch(estado) {
        if (estado == true) {
            document.querySelector("div[id='modalAccesoUsuario'] label[name='texto_estado_acceso_encuesta']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='modalAccesoUsuario'] label[name='texto_estado_acceso_encuesta']").textContent = "Deshabilitado";
        }
    }
    actualizarAccesoReportesInputSwitch(estado) {
        if (estado == true) {
            document.querySelector("div[id='modalAccesoUsuario'] label[name='texto_estado_acceso_reportes']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='modalAccesoUsuario'] label[name='texto_estado_acceso_reportes']").textContent = "Deshabilitado";
        }
    }
    actualizarAccesoConfiguracionInputSwitch(estado) {
        if (estado == true) {
            document.querySelector("div[id='modalAccesoUsuario'] label[name='texto_estado_acceso_configuracion']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='modalAccesoUsuario'] label[name='texto_estado_acceso_configuracion']").textContent = "Deshabilitado";
        }
    }

    actualizarEstadoInputSwitch(modal,estado) {
        if (estado == true) {
            document.querySelector("div[id='"+modal+"'] label[name='texto_estado']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='"+modal+"'] label[name='texto_estado']").textContent = "Anulado";
        }
    }
 

    obtenerUsuario(id) {
        this.limpiarModalEditarUsuario();
        this.model.obtenerUsuario(id).then((respuesta) => {
            console.log(respuesta);
            // Util.mensaje(respuesta.status, respuesta.mensaje);
            if (respuesta.status == "info") {
                document.querySelector("div[id='modalEditarAgregarUsuario'] input[name='id']").value = respuesta.data.id;
                document.querySelector("div[id='modalEditarAgregarUsuario'] select[name='tipo_id']").value = respuesta.data.personal.tipo_id;
                document.querySelector("div[id='modalEditarAgregarUsuario'] input[name='nombres']").value = respuesta.data.personal.nombres;
                document.querySelector("div[id='modalEditarAgregarUsuario'] input[name='apellido_paterno']").value = respuesta.data.personal.apellido_paterno;
                document.querySelector("div[id='modalEditarAgregarUsuario'] input[name='apellido_materno']").value = respuesta.data.personal.apellido_materno;
                document.querySelector("div[id='modalEditarAgregarUsuario'] input[name='nro_documento']").value = respuesta.data.personal.nro_documento;
                document.querySelector("div[id='modalEditarAgregarUsuario'] input[name='email']").value = respuesta.data.email;
                document.querySelector("div[id='modalEditarAgregarUsuario'] input[name='estado']").checked = respuesta.data.deleted_at != null ? false : true;
                this.actualizarEstadoInputSwitch('modalEditarAgregarUsuario',respuesta.data.deleted_at != null ? false : true);
            }
        }).fail(() => {
            Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
        }).always(() => {
            // $("#btnGuardar").html($mensaje);
        });
    }
    obtenerAccesoUsuario(id) {
        this.limpiarModalAccesoUsuario();
        this.model.obtenerAccesoUsuario(id).then((respuesta) => {
            console.log(respuesta);
            // Util.mensaje(respuesta.status, respuesta.mensaje);
            if (respuesta.status == "info") {
                document.querySelector("div[id='modalAccesoUsuario'] input[name='id']").value =id;
                respuesta.data.forEach(element => {
                    if(document.querySelector("div[id='modalAccesoUsuario'] input[name='acceso["+element.acceso_id+"]']") !=undefined){
                        let estaActivo =(element.deleted_at ==null)?true:false;
                        document.querySelector("div[id='modalAccesoUsuario'] input[name='acceso["+element.acceso_id+"]']").value =estaActivo;
                        document.querySelector("div[id='modalAccesoUsuario'] input[data-id-acceso='"+element.acceso_id+"']").checked=estaActivo;
                    }

                });
            }
        }).fail(() => {
            Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
        }).always(() => {
            // $("#btnGuardar").html($mensaje);
        });
    }

    limpiarModalEditarUsuario() {
        document.getElementById('formModalEditarAgregarUsuario').reset();
        document.querySelector("div[id='modalEditarAgregarUsuario'] input[name='id']").value = '';
        this.actualizarEstadoInputSwitch('modalEditarAgregarUsuario',false);
    }
    limpiarModalAccesoUsuario() {
        document.getElementById('formModalAccesoUsuario').reset();
        document.querySelector("div[id='modalAccesoUsuario'] input[name='id']").value = '';
        document.querySelector("div[id='modalAccesoUsuario'] input[name='acceso[1]']").value = 'false';
        document.querySelector("div[id='modalAccesoUsuario'] input[name='acceso[2]']").value = 'false';
        document.querySelector("div[id='modalAccesoUsuario'] input[name='acceso[3]']").value = 'false';
        document.querySelector("div[id='modalAccesoUsuario'] input[name='acceso[4]']").value = 'false';
        document.querySelector("div[id='modalAccesoUsuario'] input[name='acceso[5]']").value = 'false';
    }
}
