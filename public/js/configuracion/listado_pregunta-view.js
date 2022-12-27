class ListadoPreguntaView {

    constructor(model,preguntaRespuesta) {
        this.model = model;
        this.preguntaRespuesta = preguntaRespuesta;
        this.preguntaRespuesta.eventos();

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
                { extend: 'pdf', text: 'PDF',title: 'Lista de Preguntas',  orientation: 'portrait' ,pageSize: 'LEGAL',      exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6]
                }  },
                {
                    text: '<i class="fas fa-plus"></i> Agregar',
                    action: ()=> {
                        // $('#tablaPregunta    ').dataTable().clear();
                        this.limpiarTabla('tablaRespuesta');
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
                { data: 'respuesta_unica', className: 'text-left' },
                { data: 'cantidad_respuestas', className: 'text-center',render:function(data, type, row){
                    return `<span class="badge text-bg-light handleVistaRapidaRespuestas" data-id-pregunta="${row.id}" style="cursor:pointer;">${row.cantidad_respuestas}</span>`;
                } },
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

        $("#tablaPregunta").on("click", "span.handleVistaRapidaRespuestas", (e) => {
            $("#modalVistaRapidaRespuestas").modal("show");
            document.querySelector("div[id='modalVistaRapidaRespuestas'] input[name='id']").value=e.currentTarget.dataset.idPregunta;
            this.limpiarModalEditarPregunta();
            this.model.obtenerListaRespuestas(e.currentTarget.dataset.idPregunta).then((respuesta) => {
                if (respuesta.status == "info") {
                    console.log(respuesta);
                    let html='';
                    (respuesta.data).forEach((element,index) => {
                        html += `<tr>
                        <td>${index+1}</td>
                        <td>${element.nombre}</td>
                        </tr>`;
                    });
        
                    document.querySelector("table[id='tablaRespuestas'] tbody").insertAdjacentHTML('beforeend', html)
        
                }
            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
                // $("#btnGuardarPregunta").html($mensaje);
            });
        });

        $("#modalVistaRapidaRespuestas").on("click", "button.handleClicAplicarParaTodasLasPreguntas", (e) => {

            let idPregunta= document.querySelector("form[id='formModalVistaRapidaRespuestas'] input[name='id']").value;
            this.model.AplicarRespuestasParaTodasLasPreguntas(idPregunta).then((respuesta) => {
                if (respuesta.status == "info") {
                    console.log(respuesta);
                    $("#modalVistaRapidaRespuestas").modal("hide");
                    $('#tablaPregunta').DataTable().ajax.reload(null, false);

                }
            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
                // $("#btnGuardarPregunta").html($mensaje);
            });

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

 

    }

    actualizarEstadoInputSwitchModalPregunta(estado) {
        if (estado == true) {
            document.querySelector("div[id='modalEditarAgregarPregunta'] label[name='texto_estado']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='modalEditarAgregarPregunta'] label[name='texto_estado']").textContent = "Anulado";
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
                document.querySelector("div[id='modalEditarAgregarPregunta'] input[name='respuesta_unica']").value = respuesta.data.respuesta_unica;

                document.querySelector("div[id='modalEditarAgregarPregunta'] input[name='estado']").checked = respuesta.data.deleted_at != null ? false : true;
                this.actualizarEstadoInputSwitchModalPregunta(respuesta.data.deleted_at != null ? false : true);
                // this.llenarTablaRespuesta(respuesta.data.respuesta);
                // this.llenarTablaRespuesta(respuesta.data.id);
                // const listadoPreguntaRespuestaView = new ListadoPreguntaRespuestaView(new ListadoPreguntaModel(csrf_token));
                // listadoPreguntaRespuestaView.llenarTablaRespuesta(respuesta.data.id);
                // listadoPreguntaRespuestaView.eventos();

                this.preguntaRespuesta.llenarTablaRespuesta(respuesta.data.id);


            }
        }).fail(() => {
            Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
        }).always(() => {
            // $("#btnGuardarPregunta").html($mensaje);
        });
    }

    limpiarModalEditarPregunta() {
        document.getElementById('formModalEditarAgregarPregunta').reset();
        document.querySelector("div[id='modalEditarAgregarPregunta'] input[name='id']").value='';
        this.actualizarEstadoInputSwitchModalPregunta(false);

    }


    limpiarTabla(idElement){
        let nodeTbody = document.querySelector("table[id='" + idElement + "'] tbody");
        if(nodeTbody!=null){
            while (nodeTbody.children.length > 0) {
                nodeTbody.removeChild(nodeTbody.lastChild);
            }

        }
    }

}
