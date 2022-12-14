class ListadoPreguntaRespuestaView {

    constructor(model) {
        this.model = model;
        
    }

    eventos = () => {

        $("#modalEditarAgregarRespuesta").on("click", "button.handleClickGuardarCambiosRespuesta", (e) => {
            let formData = new FormData($('#formModalEditarAgregarRespuesta')[0]);

            const $route = route("configuracion.pregunta.respuesta.guardar");
            let $mensaje = ($(e.currentTarget).data("evento") == "registrar") ? "Registrar" : "Editar";
            let $btnNombre = ($(e.currentTarget).data("evento") == "registrar") ? "Registrando" : "Editando";

            $("#btnGuardarRespuesta").attr("disabled", true);
            $("#btnGuardarRespuesta").html(Util.generarPuntosSvg() + $mensaje);

            this.model.registrarRespuesta(formData, $route).then((respuesta) => {
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    console.log(respuesta);
                    $('#tablaRespuesta').DataTable().ajax.reload(null, false);
                    $("#modalEditarAgregarRespuesta").modal("hide");
                    $("#btnGuardarRespuesta").prop("disabled", false);
                // } else if (respuesta.respuesta == "duplicado") {
                //     $("#btnGuardarPregunta").html($btnNombre);
                }
            }).fail(() => {
                console.log("error");
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
                $("#btnGuardarRespuesta").html($mensaje);
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

        $("#modalEditarAgregarRespuesta").on("click", "input.handleSwitchEstadoRespuesta", (e) => {
            this.actualizarEstadoInputSwitchModalRespuesta(e.currentTarget.checked);
        });


    }

    actualizarEstadoInputSwitchModalRespuesta(estado) {
        if (estado == true) {
            document.querySelector("div[id='modalEditarAgregarRespuesta'] label[name='texto_estado']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='modalEditarAgregarRespuesta'] label[name='texto_estado']").textContent = "Anulado";
        }
    }

    obtenerRespuesta(id) {
        this.limpiarModalEditarRespuesta();
        this.model.obtenerRespuestas(id).then((respuesta) => {
            // console.log(respuesta);
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

        document.querySelector("div[id='modalEditarAgregarRespuesta'] input[name='pregunta_id']").value = id;
        document.querySelector("div[id='modalEditarAgregarRespuesta'] input[name='id']").value = '';

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
                        this.actualizarEstadoInputSwitchModalRespuesta(true);

                    
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
                { data: 'deleted_at', className: 'text-center' },
                // {  render: (data, type, row)=>{
                //     return '<div class="btn-group" role="group"><button type="button" class="btn btn-xs btn-warning editar-respuesta" data-id="'+row.id+'" ><i class="fa-solid fa-pencil"></i></button>';
                // }
                // },
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }

            ],
            "autoWidth": false

        });
    }

    limpiarModalEditarRespuesta() {
        document.getElementById('formModalEditarAgregarRespuesta').reset();
        this.actualizarEstadoInputSwitchModalRespuesta(false);

    }
}
