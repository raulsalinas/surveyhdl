class PreguntasPorEncuetaView {

    constructor(model) {
        this.model = model;
    }

    listar = () => {
        const $tablaPreguntasPorEncuesta = $('#tablaPreguntasPorEncuesta').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            lengthChange: false,
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 Linhas', '25 Linhas', '50 Linhas', 'Mostrar todas']
            ],
            buttons: [
                { extend: 'excel', text: 'Excel', title: 'Preguntas Por Encuesta' },
                {
                    extend: 'pdf', text: 'PDF', title: 'Preguntas Por Encuesta', orientation: 'portrait', pageSize: 'LEGAL', exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                }
            ],
            pageLength: 20,
            language: idioma,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaPreguntasPorEncuesta_filter');
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
                    $tablaPreguntasPorEncuesta.search($input.val()).draw();
                });
            },
            drawCallback: function (settings) {
                $('#tablaPreguntasPorEncuesta_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaPreguntasPorEncuesta_filter input').trigger('focus');
            },
            order: [0, 'asc'],
            ajax: {
                url: route('reportes.listar-preguntas-por-encuesta'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    data: 'id', render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: true, searchable: false, className: 'text-center'
                },
                { data: 'nombre', name: 'nombre', className: 'text-left', defaultContent: '' },
                { data: 'encuesta.nombre', name: 'encuesta.nombre', className: 'text-left', defaultContent: '' },
                { data: 'cantidad_respuestas', className: 'text-center', defaultContent: '' },
                { data: 'encuesta.muestreo.nombre', name: 'encuesta.muestreo.nombre', className: 'text-left', defaultContent: '' },
                { data: 'created_at', name: 'created_at', className: 'text-center', defaultContent: '' },
                { data: 'update_at', name: 'update_at', className: 'text-center', defaultContent: '' },
                { data: 'deleted_at', className: 'text-center', defaultContent: '' }
            ],
            "autoWidth": false
        });

        $tablaPreguntasPorEncuesta.buttons().container().appendTo('#tablaPreguntasPorEncuesta_wrapper .col-md-6:eq(0)');

    }

}
