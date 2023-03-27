class ResultadosPorEncuestaView {

    constructor(model) {
        this.model = model;
    }

    listar = (id_encuesta=null) => {

        $('#tablaResultadosPorEncuesta').DataTable().destroy();

        if(id_encuesta !=null){
            const $tablaResultadosPorEncuesta = $('#tablaResultadosPorEncuesta').DataTable({
                dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                lengthChange: false,
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 Linhas', '25 Linhas', '50 Linhas', 'Mostrar todas']
                ],
                buttons: [
                    { extend: 'excel', text: 'Excel', title: 'Resultados Por Encuesta' },
                    {
                        extend: 'pdf', text: 'PDF', title: 'Resultados Por Encuesta', orientation: 'portrait', pageSize: 'LEGAL', exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    }
                ],
                pageLength: 20,
                language: idioma,
                serverSide: true,
                initComplete: function (settings, json) {
                    const $filter = $('#tablaResultadosPorEncuesta_filter');
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
                        $tablaResultadosPorEncuesta.search($input.val()).draw();
                    });
                },
                drawCallback: function (settings) {
                    $('#tablaResultadosPorEncuesta_filter input').prop('disabled', false);
                    $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                    $('#tablaResultadosPorEncuesta_filter input').trigger('focus');
                },
                order: [0, 'asc'],
                ajax: {
                    url: route('reportes.listar-resultados-por-encuesta'),
                    method: 'POST',
                    data:{'id_encuesta':id_encuesta??null},
                    headers: { 'X-CSRF-TOKEN': csrf_token }
                },
                columns: [
                    {
                        data: 'id', render: function (data, type, row, index) {
                            return index.row + 1;
                        }, orderable: true, searchable: false, className: 'text-center'
                    },
                    { data: 'personal.usuario.email', name: 'email', className: 'text-left', defaultContent: '' },
                    { data: 'respuesta.pregunta.nombre', name: 'nombre', className: 'text-left', defaultContent: '' },
                    { data: 'respuesta.nombre',name:'nombre', className: 'text-center', defaultContent: '' },
                    { data: 'respuesta.created_at', name: 'respuesta.created_at', className: 'text-left', defaultContent: '' },
                    { data: 'respuesta.pregunta.encuesta.nombre', name: 'nombre', className: 'text-center', defaultContent: '' },
                    { data: 'muestreo.nombre', name: 'nombre', className: 'text-center', defaultContent: '' },
                    { data: 'muestreo.created_at', name: 'created_at', className: 'text-center', defaultContent: '' },
                    { data: 'personal.muestra.nombre', name: 'nombre', className: 'text-center', defaultContent: '' },
                    { data: 'personal.muestra.fecha.fecha_inicio', name: 'fecha_inicio', className: 'text-center', defaultContent: '' },
                    { data: 'personal.muestra.fecha.fecha_fin', name: 'fecha_fin', className: 'text-center', defaultContent: '' }
                ],
                "autoWidth": false
            });
            $tablaResultadosPorEncuesta.buttons().container().appendTo('#tablaResultadosPorEncuesta_wrapper .col-md-6:eq(0)');
        }
    }

    eventos = () => {
        $("#contenedorReportes").on("change", "select.handleChangeEncuesta", (e) => {
            this.listar(e.currentTarget.value);
            if(e.currentTarget.value == 2){ // si es encuensta de liderazgo
                document.querySelector("div[id='graficas_encuesta_liderazgo']").removeAttribute("hidden");
            }else{
                document.querySelector("div[id='graficas_encuesta_liderazgo']").setAttribute("hidden",true);

            }
            this.contruirReporteGrafico(e.currentTarget.value);

        });
    }

    contruirReporteGrafico(idEncuesta){
        
        if(idEncuesta >0){
            this.model.obtenerReporteGrafico(idEncuesta).then((data) => {
                console.log(data);
                this.contruirGrafica(data.etiqueta, data.dataRecompensaContigente, 'grafica_recompensa_contingente');
                this.contruirGrafica(data.etiqueta, data.dataDireccionPorExcepcion, 'grafica_direccion_por_excepcion');
                this.contruirGrafica(data.etiqueta, data.dataCarisma, 'grafica_carisma');
                this.contruirGrafica(data.etiqueta, data.dataEstimulacionIntelectual, 'grafica_estimulacion_intelectual');
                this.contruirGrafica(data.etiqueta, data.dataInspiracion, 'grafica_inspiracion');
                this.contruirGrafica(data.etiqueta, data.dataConsideracionIndividualizada, 'grafica_consideracion_individualizada');
                this.contruirGrafica(data.etiqueta, data.dataAusenciaLiderazgo, 'grafica_ausencia_de_liderazgo');
            });
        }else{
            Util.mensaje('info', 'Debe seleccionar una encuesta');
        }
    }

    contruirGrafica(etiqueta,data,tabla) {
        if(data.length > 0 && etiqueta.length>0){

            // Obtener una referencia al elemento canvas del DOM
            const $grafica = document.querySelector("#"+tabla);
            // Las etiquetas son las que van en el eje X. 
            const etiquetas = etiqueta
            // Podemos tener varios conjuntos de datos. Comencemos con uno
            const datosVentas2020 = {
                label: "Respuestas",
                data: data, // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
                borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
                borderWidth: 1, // Ancho del borde
            };
            new Chart($grafica, {
                type: 'bar', // Tipo de gráfica
                data: {
                    labels: etiquetas,
                    datasets: [
                        datosVentas2020,
                        // Aquí más datos...
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                    },
                }
            });
        }
    }
    

}
