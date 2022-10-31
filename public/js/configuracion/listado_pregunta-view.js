class ListadoPreguntaView {

    constructor(model) {
        this.model = model;
    }

    listar = () => {

        const $tablaPregunta = $('#tablaPregunta').DataTable({
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
                { extend: 'pdf', text: 'PDF' },
                {
                    text: '<i class="fas fa-plus"></i> Agregar',
                    action: ()=> {
                        this.limpiarModalEditarPregunta();
                        this.actualizarEstadoInputSwitchModalPregunta(true);
                        $("#modalEditarAgregarPregunta").modal("show");
                        $("#btnGuardarPregunta").attr("data-evento", "registrar");
                        $("#btnGuardarPregunta").html("Registrar");
                        $("#titulo_modal_pregunta").html("Registrar");

                        $("#btnGuardarPregunta").prop("disabled", false);
                    },
                    className: 'btn btn-sm btn-success nuevo',
                },
            ],
            pageLength: 20,
            language: idioma,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaPregunta_filter');
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
                    $tablaPregunta.search($input.val()).draw();
                });
            },
            drawCallback: function (settings) {
                $('#tablaPregunta_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaPregunta_filter input').trigger('focus');
            },
            order: [0, 'asc'],
            ajax: {
                url: route('configuracion.pregunta.listar'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    data: 'id', render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: true, searchable: false, className: 'text-center'
                },
                { data: 'nombre', className: 'text-left' },
                { data: 'created_at', className: 'text-center' },
                { data: 'updated_at', className: 'text-center' },
                { data: 'deleted_at', orderable: false, searchable: false, className: 'text-center' },
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
            ],
            "autoWidth": false

        });

        $tablaPregunta.buttons().container().appendTo('#tablaPregunta_wrapper .col-md-6:eq(0)');
 
    }

    eventos = () => {

        $("#tablaPregunta").on("click", "button.editar", (e) => {
            $("#modalEditarAgregarPregunta").modal("show");
            this.obtenerPreguntas(e.currentTarget.dataset.id);
            $("#btnGuardarPregunta").attr("data-evento", "editar");
            $("#btnGuardarPregunta").html("Editar");
            $("#btnGuardarPregunta").prop("disabled", false);
            $("#titulo_modal_pregunta").html("Editar");

        });


        $("#modalEditarAgregarPregunta").on("click", "input.handleSwitchEstadoPregunta", (e) => {
            this.actualizarEstadoInputSwitchModalPregunta(e.currentTarget.checked);
        });


        $("#modalEditarAgregarPregunta").on("click", "button.handleClickGuardarCambios", (e) => {
            let formData = new FormData($('#formModalEditarAgregarPregunta')[0]);

            const $route = route("configuracion.pregunta.guardar");
            let $mensaje = ($(e.currentTarget).data("evento") == "registrar") ? "Registrar" : "Editar";
            let $btnNombre = ($(e.currentTarget).data("evento") == "registrar") ? "Registrando" : "Editando";

            $("#btnGuardarPregunta").attr("disabled", true);
            $("#btnGuardarPregunta").html(Util.generarPuntosSvg() + $mensaje);

            this.model.registrarPregunta(formData, $route).then((respuesta) => {
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    $('#tablaPregunta').DataTable().ajax.reload(null, false);
                    $("#modalEditarAgregarPregunta").modal("hide");
                } else if (respuesta.respuesta == "duplicado") {
                    $("#btnGuardarPregunta").html($btnNombre);
                    $("#btnGuardarPregunta").prop("disabled", false);
                }
            }).fail(() => {
                console.log("error");
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
                $("#btnGuardarPregunta").html($mensaje);
            });
        });

        $("#modalEditarAgregarRespuesta").on("click", "button.handleClickGuardarCambios", (e) => {
            let formData = new FormData($('#formModalEditarAgregarRespuesta')[0]);

            const $route = route("configuracion.pregunta.respuesta.guardar");
            let $mensaje = ($(e.currentTarget).data("evento") == "registrar") ? "Registrar" : "Editar";
            let $btnNombre = ($(e.currentTarget).data("evento") == "registrar") ? "Registrando" : "Editando";

            $("#btnGuardarPregunta").attr("disabled", true);
            $("#btnGuardarPregunta").html(Util.generarPuntosSvg() + $mensaje);

            this.model.registrarRespuesta(formData, $route).then((respuesta) => {
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    console.log(respuesta);
                    $('#tablaRespuesta').DataTable().ajax.reload(null, false);
                    $("#modalEditarAgregarRespuesta").modal("hide");
                // } else if (respuesta.respuesta == "duplicado") {
                //     $("#btnGuardarPregunta").html($btnNombre);
                //     $("#btnGuardarPregunta").prop("disabled", false);
                }
            }).fail(() => {
                console.log("error");
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
                $("#btnGuardarPregunta").html($mensaje);
            });
        });

        $("#modalEditarAgregarPregunta").on("click", "button.editar-respuesta", (e) => {
            $("#modalEditarAgregarRespuesta").modal("show");
            this.obtenerRespuesta(e.currentTarget.dataset.id);
            $("#btnGuardarPregunta").attr("data-evento", "editar");
            $("#btnGuardarPregunta").prop("disabled", false);
            $("#btnGuardarRespuesta").html("Editar");
            $("#titulo_modal_respuesta").html("Editar");

        });

    }

    actualizarEstadoInputSwitchModalPregunta(estado) {
        if (estado == true) {
            document.querySelector("div[id='modalEditarAgregarPregunta'] label[name='texto_estado']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='modalEditarAgregarPregunta'] label[name='texto_estado']").textContent = "Anulado";
        }
    }
    actualizarEstadoInputSwitchModalRespuesta(estado) {
        if (estado == true) {
            document.querySelector("div[id='modalEditarAgregarRespuesta'] label[name='texto_estado']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='modalEditarAgregarRespuesta'] label[name='texto_estado']").textContent = "Anulado";
        }
    }

    obtenerPreguntas(id) {
        this.limpiarModalEditarPregunta();
        this.model.obtenerPreguntas(id).then((respuesta) => {
            // console.log(respuesta);
            // Util.mensaje(respuesta.status, respuesta.mensaje);
            if (respuesta.status == "info") {
                document.querySelector("div[id='modalEditarAgregarPregunta'] input[name='id']").value = respuesta.data.id;
                document.querySelector("div[id='modalEditarAgregarPregunta'] input[name='nombre']").value = respuesta.data.nombre;
                document.querySelector("div[id='modalEditarAgregarPregunta'] input[name='estado']").checked = respuesta.data.deleted_at != null ? false : true;
                this.actualizarEstadoInputSwitchModalPregunta(respuesta.data.deleted_at != null ? false : true);
                // this.llenarTablaRespuesta(respuesta.data.respuesta);
                this.llenarTablaRespuesta(respuesta.data.id);


            }
        }).fail(() => {
            Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
        }).always(() => {
            // $("#btnGuardarPregunta").html($mensaje);
        });
    }
    obtenerRespuesta(id) {
        this.limpiarModalEditarRespuesta();
        this.model.obtenerRespuestas(id).then((respuesta) => {
            console.log(respuesta);
            // Util.mensaje(respuesta.status, respuesta.mensaje);
            if (respuesta.status == "info") {
                document.querySelector("div[id='modalEditarAgregarRespuesta'] input[name='id']").value = respuesta.data.id;
                document.querySelector("div[id='modalEditarAgregarRespuesta'] input[name='pregunta_id']").value = respuesta.data.pregunta_id;

                document.querySelector("div[id='modalEditarAgregarRespuesta'] input[name='nombre']").value = respuesta.data.nombre;
                document.querySelector("div[id='modalEditarAgregarRespuesta'] input[name='estado']").checked = respuesta.data.deleted_at != null ? false : true;
                this.actualizarEstadoInputSwitchModalRespuesta(respuesta.data.deleted_at != null ? false : true);
                // this.llenarTablaRespuesta(respuesta.data.respuesta);
            }
        }).fail(() => {
            Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
        }).always(() => {
            // $("#btnGuardarPregunta").html($mensaje);
        });
    }

    llenarTablaRespuesta(id){
        console.log(id);
        const $tablaRespuesta = $('#tablaRespuesta').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            lengthChange: false,
    
            buttons: [],
            pageLength: 5,
            language: idioma,
            order: [0, 'asc'],
            destroy: true,
            serverSide: true,
            info: false,
            // data:data,
            buttons:[
                {
                    text: '<i class="fas fa-plus"></i> Agregar',
                    action: ()=> {
                        this.limpiarModalEditarRespuesta();
                        $("#modalEditarAgregarRespuesta").modal("show");
                        $("#btnGuardarRespuesta").attr("data-evento", "registrar");
                        $("#btnGuardarRespuesta").html("Registrar");
                        $("#titulo_modal_respuesta").html("Registrar");

                    
                    },
                    className: 'btn btn-sm btn-success nuevo',
                },
            ],
            
            ajax: {
                url: route('configuracion.pregunta.respuesta.listar'),
                method: 'POST',
                data:{id},
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    data: 'id', render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: true, searchable: false, className: 'text-center'
                },
                { data: 'nombre', className: 'text-left' },
                // {  render: (data, type, row)=>{
                //     return '<div class="btn-group" role="group"><button type="button" class="btn btn-xs btn-warning editar-respuesta" data-id="'+row.id+'" ><i class="fa-solid fa-pencil"></i></button>';
                // }
                // },
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }

            ],
            "autoWidth": false

        });
    }

    limpiarModalEditarPregunta() {
        document.getElementById('formModalEditarAgregarPregunta').reset();
        this.actualizarEstadoInputSwitchModalPregunta(false);

    }
    limpiarModalEditarRespuesta() {
        document.getElementById('formModalEditarAgregarRespuesta').reset();
        this.actualizarEstadoInputSwitchModalRespuesta(false);

    }
}
