class ListadoEncuestaView {

    constructor(model) {
        this.model = model;
    }

    listar = () => {

        const $tablaEncuesta = $('#tablaEncuesta').DataTable({
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
                // {extend:'print', text:'Imprimir'},
                {
                    text: '<i class="fas fa-plus"></i> Agregar',
                    action: ()=> {
                        this.limpiarModalEditarEncuesta();
                        this.actualizarEstadoInputSwitch(true);
                        $("#modalEditarAgregarEncuesta").modal("show");
                        $("#btnGuardar").attr("data-evento", "registrar");
                        $("#btnGuardar").html("Registrar");
                        $("#btnGuardar").prop("disabled", false);
                    },
                    className: 'btn btn-sm btn-success nuevo',
                },
            ],
            pageLength: 20,

            language: idioma,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaEncuesta_filter');
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
                    $tablaEncuesta.search($input.val()).draw();
                });
            },
            drawCallback: function (settings) {
                $('#tablaEncuesta_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaEncuesta_filter input').trigger('focus');
            },
            order: [0, 'asc'],
            ajax: {
                url: route('configuracion.encuesta.listar'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    data: 'id', render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: true, searchable: false, className: 'text-center'
                },
                { data: 'nombre', className: 'text-center' },
                { data: 'created_at', className: 'text-center' },
                { data: 'updated_at', className: 'text-center' },
                { data: 'deleted_at', orderable: false, searchable: false, className: 'text-center' },
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
            ],
            "autoWidth": false
            // buttons: [
            //     {
            //         text: '<i class="fas fa-plus"></i> Agregar',
            //         action: function () {
            //             $("#formulario")[0].reset();
            //             $("[name=id]").val(0);
            //             $("#modalPersona").find(".modal-title").text("Agregar nombre de encuesta");
            //             $("#btnGuardar").html("Registrar");
            //             $("#btnGuardar").data("evento", "registrar");
            //             $("#modalPersona").modal("show");
            //         },
            //         className: 'btn btn-sm btn-success nuevo',
            //     },
            // ]
        });

        $tablaEncuesta.buttons().container().appendTo('#tablaEncuesta_wrapper .col-md-6:eq(0)');
 

    }

    eventos = () => {

        $("#tablaEncuesta").on("click", "button.editar", (e) => {
            $("#modalEditarAgregarEncuesta").modal("show");
            this.obtenerEncuestas(e.currentTarget.dataset.id);
            $("#btnGuardar").attr("data-evento", "editar");
            $("#btnGuardar").prop("disabled", false);

        });

        $("#modalEditarAgregarEncuesta").on("click", "input.handleSwitchEstadoEncuesta", (e) => {
            this.actualizarEstadoInputSwitch(e.currentTarget.checked);
        });


        // $("#tablaEncuesta").on("click", "button.editar", (e) => {
        //     this.model.cargarDatosPersona($(e.currentTarget).data('año'), $(e.currentTarget).data('libro'), $(e.currentTarget).data('folio')).then((respuesta) => {
        //         $("#btnGuardar").html("Editar");
        //         $("#btnGuardar").data("evento", "registrar");

        //         $('[name=id]').val(respuesta.id);
        //         $('[name=documento_identidad_id]').val(respuesta.documento_identidad_id);
        //         $('[name=documento]').val(respuesta.documento);
        //         $('[name=nombres]').val(respuesta.nombres);
        //         $('[name=apellido_paterno]').val(respuesta.apellido_paterno);
        //         $('[name=apellido_materno]').val(respuesta.apellido_materno);
        //         $('[name=sexo]').val(respuesta.sexo);
        //         $('[name=fecha_nacimiento]').val(respuesta.fecha_nacimiento);
        //         $('[name=estado_civil_id]').val(respuesta.estado_civil_id);

        //         $modal.find(".modal-title").text('Editar persona [' + respuesta.nombres + ' ' + respuesta.apellido_paterno + ']');
        //         $modal.modal('show');
        //     }).fail(() => {
        //         Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
        //     });
        // });

        /**
         * filtrar - Filtrar de listado de nacimientos
         */
        // $("#modal-filtro_nacimientos").on("click", "button.filtrar", (e) => {
        //     const $modal=$("#modal-filtro_nacimientos");

        //     let anioEjeFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='anio_eje_filtro']").value;
        //     let nroLibFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='nro_lib_filtro']").value;
        //     let nroFolFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='nro_fol_filtro']").value;
        //     let apellidoPaternoFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='apellido_paterno_filtro']").value;
        //     let apellidoMaternoFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='apellido_materno_filtro']").value;
        //     let nombresFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='nombres_filtro']").value;
        //     let fechaDesdeFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='fecha_desde_filtro']").value;
        //     let fechaHastaFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='fecha_hasta_filtro']").value;

        //     let condicionFiltro;
        //     let condicion= document.querySelectorAll("div[id='modal-filtro_nacimientos'] input[name='condicionActaRadioOptions']");
        //     condicion.forEach(element => {
        //         if(element.checked){
        //             condicionFiltro=element.value;
        //         }
        //     });


        //     this.listar(anioEjeFiltro,nroLibFiltro,nroFolFiltro,apellidoPaternoFiltro,apellidoMaternoFiltro,nombresFiltro,fechaDesdeFiltro,fechaHastaFiltro,condicionFiltro);   
        //     $modal.modal("hide");

        // });

        $("#modalEditarAgregarEncuesta").on("click", "button.handleClickGuardarCambios", (e) => {
            let formData = new FormData($('#formModalEditarAgregarEncuesta')[0]);

            const $route = route("configuracion.encuesta.guardar");
            let $mensaje = ($(e.currentTarget).data("evento") == "registrar") ? "Registrar" : "Editar";
            let $btnNombre = ($(e.currentTarget).data("evento") == "registrar") ? "Registrando" : "Editando";

            $("#btnGuardar").attr("disabled", true);
            $("#btnGuardar").html(Util.generarPuntosSvg() + $mensaje);

            this.model.registrarEncuesta(formData, $route).then((respuesta) => {
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    $('#tablaEncuesta').DataTable().ajax.reload(null, false);
                    $("#modalEditarAgregarEncuesta").modal("hide");
                } else if (respuesta.respuesta == "duplicado") {
                    $("#btnGuardar").html($btnNombre);
                    $("#btnGuardar").prop("disabled", false);
                }
            }).fail(() => {
                console.log("error");
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
                $("#btnGuardar").html($mensaje);
            });
        });

    }

    actualizarEstadoInputSwitch(estado) {
        if (estado == true) {
            document.querySelector("div[id='modalEditarAgregarEncuesta'] label[name='texto_estado']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='modalEditarAgregarEncuesta'] label[name='texto_estado']").textContent = "Anulado";
        }
    }

    obtenerEncuestas(id) {
        this.limpiarModalEditarEncuesta();
        this.model.obtenerEncuestas(id).then((respuesta) => {
            // console.log(respuesta);
            // Util.mensaje(respuesta.status, respuesta.mensaje);
            if (respuesta.status == "info") {
                document.querySelector("div[id='modalEditarAgregarEncuesta'] input[name='id']").value = respuesta.data.id;
                document.querySelector("div[id='modalEditarAgregarEncuesta'] input[name='nombre']").value = respuesta.data.nombre;
                document.querySelector("div[id='modalEditarAgregarEncuesta'] input[name='estado']").checked = respuesta.data.deleted_at != null ? false : true;
                this.actualizarEstadoInputSwitch(respuesta.data.deleted_at != null ? false : true);
            }
        }).fail(() => {
            Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
        }).always(() => {
            // $("#btnGuardar").html($mensaje);
        });
    }

    limpiarModalEditarEncuesta() {
        document.getElementById('formModalEditarAgregarEncuesta').reset();
        this.actualizarEstadoInputSwitch(false);

    }
}
