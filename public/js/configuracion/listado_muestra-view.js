class ListadoMuestraView {

    constructor(model) {
        this.model = model;
    }

    listar = () => {

        const $tablaMuestra = $('#tablaMuestra').DataTable({
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
                { extend: 'pdf', text: 'PDF',title: 'Lista de Muestra',  orientation: 'portrait' ,pageSize: 'LEGAL',      exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6,7]
                } },
                // {extend:'print', text:'Imprimir'},
                {
                    text: '<i class="fas fa-plus"></i> Agregar',
                    action: ()=> {
                        this.limpiarModalEditarMuestra();
                        this.actualizarEstadoInputSwitch(true);
                        $("#modalEditarAgregarMuestra").modal("show");
                        $("#btnGuardarMuestra").attr("data-evento", "registrar");
                        $("#btnGuardarMuestra").html("Registrar");
                        $("#btnGuardarMuestra").prop("disabled", false);
                        $("#titulo_modal_muestra").html("Registrar");
                    },
                    className: 'btn btn-sm btn-success nuevo',
                },
            ],
            pageLength: 20,

            language: idioma,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaMuestra_filter');
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
                    $tablaMuestra.search($input.val()).draw();
                });
            },
            drawCallback: function (settings) {
                $('#tablaMuestra_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaMuestra_filter input').trigger('focus');
            },
            order: [0, 'asc'],
            ajax: {
                url: route('configuracion.muestra.listar'),
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
                { data: 'fecha.fecha_inicio',name:'fecha.fecha_inicio', className: 'text-center', defaultContent:'' },
                { data: 'fecha.fecha_fin',name:'fecha.fecha_fin', className: 'text-center', defaultContent:'' },
                { data: 'personal.nombres',name:'personal.nombres', className: 'text-center', defaultContent:'' },
                { data: 'created_at', className: 'text-center' },
                { data: 'updated_at', className: 'text-center' },
                { data: 'deleted_at', orderable: false, searchable: false, className: 'text-center' },
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
            ],
            "autoWidth": false
        });

        $tablaMuestra.buttons().container().appendTo('#tablaMuestra_wrapper .col-md-6:eq(0)');
 

    }

    eventos = () => {

        $("#tablaMuestra").on("click", "button.editar-muestra", (e) => {
            $("#modalEditarAgregarMuestra").modal("show");
            this.obtenerMuestra(e.currentTarget.dataset.id);
            $("#btnGuardarMuestra").attr("data-evento", "editar");
            $("#btnGuardarMuestra").prop("disabled", false);
            $("#titulo_modal_muestra").html("Editar");
            $("#btnGuardarMuestra").prop("disabled", false);

        });

        $("#modalEditarAgregarMuestra").on("click", "input.handleSwitchEstadoMuestra", (e) => {
            this.actualizarEstadoInputSwitch(e.currentTarget.checked);
        });


        $("#modalEditarAgregarMuestra").on("click", "button.handleClickGuardarCambios", (e) => {
            let formData = new FormData($('#formModalEditarAgregarMuestra')[0]);

            const $route = route("configuracion.muestra.guardar");
            let $mensaje = ($(e.currentTarget).data("evento") == "registrar") ? "Registrar" : "Editar";
            let $btnNombre = ($(e.currentTarget).data("evento") == "registrar") ? "Registrando" : "Editando";

            $("#btnGuardarMuestra").attr("disabled", true);
            $("#btnGuardarMuestra").html(Util.generarPuntosSvg() + $mensaje);

            this.model.registrarMuestra(formData, $route).then((respuesta) => {
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    $('#tablaMuestra').DataTable().ajax.reload(null, false);
                    $("#modalEditarAgregarMuestra").modal("hide");
                } else if (respuesta.respuesta == "duplicado") {
                    $("#btnGuardarMuestra").html($btnNombre);
                    $("#btnGuardarMuestra").prop("disabled", false);
                }
            }).fail(() => {
                console.log("error");
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
                $("#btnGuardarMuestra").html($mensaje);
            });
        });

    }

    actualizarEstadoInputSwitch(estado) {
        if (estado == true) {
            document.querySelector("div[id='modalEditarAgregarMuestra'] label[name='texto_estado']").textContent = "Habilitado";
        } else if (estado == false) {
            document.querySelector("div[id='modalEditarAgregarMuestra'] label[name='texto_estado']").textContent = "Anulado";
        }
    }

    obtenerMuestra(id) {
        this.limpiarModalEditarMuestra();
        this.model.obtenerMuestra(id).then((respuesta) => {
            // console.log(respuesta);
            // Util.mensaje(respuesta.status, respuesta.mensaje);
            if (respuesta.status == "info") {
                document.querySelector("div[id='modalEditarAgregarMuestra'] input[name='id']").value = respuesta.data.id;
                document.querySelector("div[id='modalEditarAgregarMuestra'] input[name='nombre']").value = respuesta.data.nombre;
                document.querySelector("div[id='modalEditarAgregarMuestra'] select[name='fecha_id']").value = respuesta.data.fecha_id;
                document.querySelector("div[id='modalEditarAgregarMuestra'] select[name='personal_id']").value = respuesta.data.personal_id;
                document.querySelector("div[id='modalEditarAgregarMuestra'] input[name='estado']").checked = respuesta.data.deleted_at != null ? false : true;
                this.actualizarEstadoInputSwitch(respuesta.data.deleted_at != null ? false : true);
            }
        }).fail(() => {
            Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
        }).always(() => {
            // $("#btnGuardar").html($mensaje);
        });
    }

    limpiarModalEditarMuestra() {
        document.getElementById('formModalEditarAgregarMuestra').reset();
        document.querySelector("div[id='modalEditarAgregarMuestra'] input[name='id']").value='';
        this.actualizarEstadoInputSwitch(false);
    }
}
