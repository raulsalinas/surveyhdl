class ListadoMuestreoView {

    constructor(model) {
        this.model = model;

    }

    listar = () => {

        const $tablaMuestreo = $('#tablaMuestreo').DataTable({
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
                { extend: 'pdf', text: 'PDF',title: 'Lista de Muestreo',  orientation: 'portrait' ,pageSize: 'LEGAL',      exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6,7]
                } },
                {
                    text: '<i class="fas fa-plus"></i> Agregar',
                    action: ()=> {
                        this.limpiarModalEditarMuestreo();
                        this.actualizarEstadoInputSwitchModalMuestreo(true);
                        $("#modalEditarAgregarMuestreo").modal("show");
                        $("#btnGuardarMuestreo").attr("data-evento", "registrar");
                        $("#btnGuardarMuestreo").html("Registrar");
                        $("#titulo_modal_muestreo").html("Registrar");

                        $("#btnGuardarMuestreo").prop("disabled", false);
                    },
                    className: 'btn btn-sm btn-success nuevo',
                },
            ],
            pageLength: 20,
            language: idioma,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaMuestreo_filter');
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
                    $tablaMuestreo.search($input.val()).draw();
                });
            },
            drawCallback: function (settings) {
                $('#tablaMuestreo_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaMuestreo_filter input').trigger('focus');
            },
            order: [0, 'asc'],
            ajax: {
                url: route('configuracion.muestreo.listar'),
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
                { data: 'nombre_encuesta',name: 'encuesta.nombre', className: 'text-left' },
                { data: 'fecha[, ].fecha_inicio', className: 'text-left' },
                { data: 'fecha[, ].fecha_fin', className: 'text-left' },
 
                { data: 'created_at', className: 'text-center' },
                { data: 'updated_at', className: 'text-center' },
                { data: 'deleted_at', orderable: false, searchable: false, className: 'text-center' },
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
            ],
            "autoWidth": false

        });

        $tablaMuestreo.buttons().container().appendTo('#tablaMuestreo_wrapper .col-md-6:eq(0)');
 
    }

    eventos = () => {

        $("#tablaMuestreo").on("click", "button.editar-muestreo", (e) => {
            $("#modalEditarAgregarMuestreo").modal("show");
            this.obtenerMuestreo(e.currentTarget.dataset.id);
            $("#btnGuardarMuestreo").attr("data-evento", "editar");
            $("#btnGuardarMuestreo").html("Editar");
            $("#btnGuardarMuestreo").prop("disabled", false);
            $("#titulo_modal_muestreo").html("Editar");

        });
        $("#tablaMuestreo").on("click", "button.muestreo-fecha", (e) => {
            $("#modalEditarAgregarMuestreoFecha").modal("show");
            this.obtenerMuestreoFecha(e.currentTarget.dataset.id);
            $("#btnGuardarMuestreoFecha").attr("data-evento", "editar");
            $("#btnGuardarMuestreoFecha").html("Editar");
            $("#btnGuardarMuestreoFecha").prop("disabled", false);
            $("#titulo_modal_muestreo_fecha").html("Gestionar");

        });

        $("#tablaFechas").on("click", "button.fecha", (e) => {
            $("#modalEditarAgregarFecha").modal("show");
            this.obtenerFecha(e.currentTarget.dataset.id);
            $("#btnGuardarFecha").attr("data-evento", "editar");
            $("#btnGuardarFecha").html("Editar");
            $("#btnGuardarFecha").prop("disabled", false);
            $("#titulo_modal_fecha").html("Editar");

        });


        $("#modalEditarAgregarMuestreo").on("click", "input.handleSwitchEstadoMuestreo", (e) => {
            this.actualizarEstadoInputSwitchModalMuestreo(e.currentTarget.checked);
        });

        $("#modalEditarAgregarFecha").on("click", "input.handleSwitchEstadoFecha", (e) => {
            this.actualizarEstadoInputSwitchModalFecha(e.currentTarget.checked);
        });

        $("#modalEditarAgregarMuestreo").on("click", "button.handleClickGuardarCambios", (e) => {
            let formData = new FormData($('#formModalEditarAgregarMuestreo')[0]);

            const $route = route("configuracion.muestreo.guardar");
            let $mensaje = ($(e.currentTarget).data("evento") == "registrar") ? "Registrar" : "Editar";
            let $btnNombre = ($(e.currentTarget).data("evento") == "registrar") ? "Registrando" : "Editando";

            $("#btnGuardarMuestreo").attr("disabled", true);
            $("#btnGuardarMuestreo").html(Util.generarPuntosSvg() + $mensaje);

            this.model.registrarMuestreo(formData, $route).then((respuesta) => {
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    $('#tablaMuestreo').DataTable().ajax.reload(null, false);
                    $("#modalEditarAgregarMuestreo").modal("hide");
                } else if (respuesta.respuesta == "duplicado") {
                    $("#btnGuardarMuestreo").html($btnNombre);
                    $("#btnGuardarMuestreo").prop("disabled", false);
                }
            }).fail(() => {
                console.log("error");
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
                $("#btnGuardarMuestreo").html($mensaje);
            });
        });

        $("#modalEditarAgregarFecha").on("click", "button.handleClickGuardarCambios", (e) => {
            let formData = new FormData($('#formModalEditarAgregarFecha')[0]);

            const $route = route("configuracion.muestreo.respuesta.guardar");
            let $mensaje = ($(e.currentTarget).data("evento") == "registrar") ? "Registrar" : "Editar";
            let $btnNombre = ($(e.currentTarget).data("evento") == "registrar") ? "Registrando" : "Editando";

            $("#btnGuardarMuestreo").attr("disabled", true);
            $("#btnGuardarMuestreo").html(Util.generarPuntosSvg() + $mensaje);

            this.model.registrarRespuesta(formData, $route).then((respuesta) => {
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    console.log(respuesta);
                    $('#tablaRespuesta').DataTable().ajax.reload(null, false);
                    $("#modalEditarAgregarRespuesta").modal("hide");
                // } else if (respuesta.respuesta == "duplicado") {
                //     $("#btnGuardarMuestreo").html($btnNombre);
                //     $("#btnGuardarMuestreo").prop("disabled", false);
                }
            }).fail(() => {
                console.log("error");
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
                $("#btnGuardarMuestreo").html($mensaje);
            });
        });

 

    }

    actualizarEstadoInputSwitchModalMuestreo(estado) {
        if (estado == true) {
            document.querySelector("div[id='modalEditarAgregarMuestreo'] label[name='texto_estado']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='modalEditarAgregarMuestreo'] label[name='texto_estado']").textContent = "Anulado";
        }
    }
 
    actualizarEstadoInputSwitchModalFecha(estado) {
        if (estado == true) {
            document.querySelector("div[id='modalEditarAgregarFecha'] label[name='texto_estado']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='modalEditarAgregarFecha'] label[name='texto_estado']").textContent = "Anulado";
        }
    }

    obtenerMuestreo(id) {
        this.limpiarModalEditarMuestreo();
        this.model.obtenerMuestreo(id).then((respuesta) => {
            // console.log(respuesta);
            // Util.mensaje(respuesta.status, respuesta.mensaje);
            if (respuesta.status == "info") {
                document.querySelector("div[id='modalEditarAgregarMuestreo'] input[name='id']").value = respuesta.data.id;
                document.querySelector("div[id='modalEditarAgregarMuestreo'] input[name='nombre']").value = respuesta.data.nombre;

                document.querySelector("div[id='modalEditarAgregarMuestreo'] input[name='estado']").checked = respuesta.data.deleted_at != null ? false : true;
                this.actualizarEstadoInputSwitchModalMuestreo(respuesta.data.deleted_at != null ? false : true);


                // this.preguntaRespuesta.llenarTablaRespuesta(respuesta.data.id);


            }
        }).fail(() => {
            Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
        }).always(() => {
            // $("#btnGuardarMuestreo").html($mensaje);
        });
    }
    obtenerMuestreoFecha(id) {
        const $tablaFechas = $('#tablaFechas').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            lengthChange: false,
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 Linhas', '25 Linhas', '50 Linhas', 'Mostrar todas']
            ],
            buttons: [ ],
            pageLength: 5,
            language: idioma,
            serverSide: true,
            destroy: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaFechas_filter');
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
                    $tablaFechas.search($input.val()).draw();
                });
            },
            drawCallback: function (settings) {
                $('#tablaFechas_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaFechas_filter input').trigger('focus');
            },
            order: [0, 'asc'],
            ajax: {
                url: route('configuracion.muestreo.obtener_fechas'),
                data:{id},
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    data: 'id', render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: true, searchable: false, className: 'text-center'
                },
                { data: 'fecha_inicio', className: 'text-left' },
                { data: 'fecha_fin', className: 'text-left' },
                { data: 'deleted_at', orderable: false, searchable: false, className: 'text-center' },
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
            ],
            "autoWidth": false

        });

        $tablaFechas.buttons().container().appendTo('#tablaFechas_wrapper .col-md-6:eq(0)');
    }

    obtenerFecha(id) {
        this.limpiarModalEditarAgregarFecha();
        this.model.obtenerFecha(id).then((respuesta) => {
            if (respuesta.status == "info") {
                document.querySelector("div[id='modalEditarAgregarFecha'] input[name='id']").value = respuesta.data.id;
                document.querySelector("div[id='modalEditarAgregarFecha'] input[name='fecha_inicio']").value = moment(respuesta.data.fecha_inicio, "DD-MM-YYYY").format("YYYY-MM-DD").toString();
                document.querySelector("div[id='modalEditarAgregarFecha'] input[name='fecha_fin']").value = moment(respuesta.data.fecha_fin, "DD-MM-YYYY").format("YYYY-MM-DD").toString();
                document.querySelector("div[id='modalEditarAgregarFecha'] input[name='muestreo']").value =respuesta.data.muestreo.nombre;
                document.querySelector("div[id='modalEditarAgregarFecha'] input[name='encuesta']").value =respuesta.data.muestreo.nombre_encuesta;
                document.querySelector("div[id='modalEditarAgregarFecha'] input[name='estado']").checked = respuesta.data.deleted_at != null ? false : true;
                this.actualizarEstadoInputSwitchModalMuestreo(respuesta.data.deleted_at != null ? false : true);

            }
        }).fail(() => {
            Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
        }).always(() => {
            // $("#btnGuardarMuestreo").html($mensaje);
        });
    }

    limpiarModalEditarMuestreo() {
        document.getElementById('formModalEditarAgregarMuestreo').reset();
        document.querySelector("div[id='modalEditarAgregarMuestreo'] input[name='id']").value='';

        this.actualizarEstadoInputSwitchModalMuestreo(false);

    }
    limpiarModalEditarAgregarFecha() {
        document.getElementById('formModalEditarAgregarFecha').reset();
        document.querySelector("div[id='modalEditarAgregarFecha'] input[name='id']").value='';
        this.actualizarEstadoInputSwitchModalFecha(false);

    }



}
