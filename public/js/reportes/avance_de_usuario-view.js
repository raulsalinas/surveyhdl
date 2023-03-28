class AvanceDeUsuarioView {

    constructor(model) {
        this.model = model;
    }


    listar = () => {
        const $tablaAvanceDeUsuarios = $('#tablaAvanceDeUsuarios').DataTable({
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
            serverSide: false,
            initComplete: function (settings, json) {
                const $filter = $('#tablaAvanceDeUsuarios_filter');
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
                    $tablaAvanceDeUsuarios.search($input.val()).draw();
                });
            },
            drawCallback: function (settings) {
                $('#tablaAvanceDeUsuarios_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaAvanceDeUsuarios_filter input').trigger('focus');
            },
            order: [0, 'asc'],
            ajax: {
                url: route('reportes.listar-avance-de-usuario'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    data: 'id', render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: true, searchable: false, className: 'text-center'
                },
                { data: 'email', name: 'email', className: 'text-center', defaultContent: '' },
                { data: 'nombre_muestreo', name: 'nombre_muestreo', className: 'text-center', defaultContent: '' },
                { data: 'nombre_encuesta', name: 'nombre_encuesta', className: 'text-center', defaultContent: '' },
                { data: 'cantidad_encuestas', className: 'text-center', defaultContent: '' },
                { data: 'cantidad_respuestas', className: 'text-center', defaultContent: '' },
                { data: 'cantidad_preguntas', className: 'text-center', defaultContent: '' },
                { data: 'porcentaje_avance', className: 'text-center', defaultContent: '0' ,render: function(data,type,row,index){
                    return ('%'+row.porcentaje_avance);
                } }
            ],
            "autoWidth": false
        });

        $tablaAvanceDeUsuarios.buttons().container().appendTo('#tablaAvanceDeUsuarios_wrapper .col-md-6:eq(0)');

    }

}
