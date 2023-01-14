class InformacionDeUsuarioView {

    constructor(model) {
        this.model = model;
    }

    listar = () => {
        const $tablaInformacionDeUsuarios = $('#tablaInformacionDeUsuarios').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            lengthChange: false,
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 Linhas', '25 Linhas', '50 Linhas', 'Mostrar todas']
            ],
            buttons: [
                { extend: 'excel', text: 'Excel', title: 'Información de Usuarios' },
                {
                    extend: 'pdf', text: 'PDF', title: 'Información de Usuarios', orientation: 'portrait', pageSize: 'LEGAL', exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6,7]
                    }
                }
            ],
            pageLength: 20,
            language: idioma,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaInformacionDeUsuarios_filter');
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
                    $tablaInformacionDeUsuarios.search($input.val()).draw();
                });
            },
            drawCallback: function (settings) {
                $('#tablaInformacionDeUsuarios_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaInformacionDeUsuarios_filter input').trigger('focus');
            },
            order: [0, 'asc'],
            ajax: {
                url: route('reportes.listar-informacion-de-usuario'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    data: 'id', render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: true, searchable: false, className: 'text-center'
                },
                { data: 'nombre_completo', name: 'nombre_completo', className: 'text-center', defaultContent: '' },
                { data: 'email', name: 'email', className: 'text-center', defaultContent: '' },
                { data: 'nro_documento', name: 'nro_documento', className: 'text-center', defaultContent: '' },
                { data: 'tipo_usuario', name: 'tipo_usuario', className: 'text-center', defaultContent: '' },
                { data: 'fecha_alta_usuario', className: 'text-center' },
                { data: 'fecha_baja_usuario', className: 'text-center' },
                { data: 'cantidad_inicios_de_sesion', name: 'cantidad_inicios_de_sesion', className: 'text-center', defaultContent: '' }
            ],
            "autoWidth": false
        });

        $tablaInformacionDeUsuarios.buttons().container().appendTo('#tablaInformacionDeUsuarios_wrapper .col-md-6:eq(0)');

    }


}
