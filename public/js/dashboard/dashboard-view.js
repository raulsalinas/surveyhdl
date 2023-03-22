
class DashboardView {

    constructor(model) {
        this.model = model;
    }

    obtenerCifrasTotales = () => {

        this.model.obtenerCifrasTotales().then((data) => {
            // console.log(data);
            document.querySelector("span[id='totalUsuariosActivos']").textContent = data.cantidad_usuarios;
            document.querySelector("span[id='totalEncuestasActivas']").textContent = data.cantidad_encuestas;
            document.querySelector("span[id='totalMuestrasActivas']").textContent = data.cantidad_muestra;

        });
    }

    obtenerCantidadUsuariosActivosYBajas = () => {
        this.model.obtenerCantidadUsuariosActivosYBajas().then((data) => {
            // console.log(data);
            document.querySelector("span[id='CantidadUsuariosActivos']").textContent = data.cantidad_usuarios_activos;
            document.querySelector("span[id='CantidadUsuariosDeBaja']").textContent = data.cantidad_usuarios_de_baja;

        });
    }

    listarInformacionPorUsuarios = () => {

        const $tablaUsuario = $('#tablaUsuarios').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            lengthChange: false,
            "info": false,
            buttons: [],
            pageLength: 20,
            "searching": false,

            language: idioma,
            serverSide: true,
            initComplete: function (settings, json) {

            },
            drawCallback: function (settings) {

            },
            order: [0, 'asc'],
            ajax: {
                url: route('dashboard.listar-informacion-usuarios'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                // {
                //     data: 'id', render: function (data, type, row, index) {
                //         return index.row + 1;
                //     }, orderable: true, searchable: false, className: 'text-center'
                // },
                {
                    data: 'email', className: 'text-center', render: function (data, type, row, index) {
                        return `<abbr class="text-capitalize" title="${row.nombre_completo}">${row.email}</abbr>`
                    }
                },
                { data: 'cantidad_inicios_de_sesion', className: 'text-center' },
                { data: 'nombre_muestras_activas', className: 'text-center' },
                { data: 'nombre_encuestas_activas', className: 'text-center' },
                { data: 'cantidad_encuestas_activas', className: 'text-center' },
                { data: 'cantidad_respuestas_registradas', className: 'text-center' }
            ],
            "autoWidth": false
        });
    }

    obtenerAvanceDeUsuarios = () => {

        const $tablaUsuario = $('#tablaAvanceDeUsuarios').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            lengthChange: false,
            "info": false,
            buttons: [],
            pageLength: 20,
            "searching": false,

            language: idioma,
            serverSide: true,
            initComplete: function (settings, json) {

            },
            drawCallback: function (settings) {

            },
            order: [0, 'asc'],
            ajax: {
                url: route('dashboard.obtener-avance-de-usuarios'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                { data: 'email', className: 'text-center' },
                { data: 'nombre_muestreo', className: 'text-center' },
                { data: 'nombre_encuesta', className: 'text-center' },
                { data: 'porcentaje_avance', className: 'text-center' }
            ],
            "autoWidth": false
        });
    }

    // llenarSelectPregunta = (idEncuesta) => {
    //     var select = document.getElementById('id_pregunta');
    //         select.innerHTML='';
    //     this.model.obtenerPreguntaList(idEncuesta).then((data) => {
    //         if(data.length>0){
    //             // var select = document.getElementById('id_pregunta');
    //             for (var i = 0; i < data.length; i++) {
    //                 var opt = document.createElement('option');
    //                 opt.value = data[i]['id'];
    //                 opt.innerHTML = data[i]['nombre'];
    //                 select.appendChild(opt);
    //             }
    //             this.InicializarListarResultadosPorPregunta();
    //         }
    //     });

    // }

    // InicializarListarResultadosPorPregunta = () => {
    //     let idPregunta = document.querySelector("select[id='id_pregunta']").value;
    //     this.model.obtenerResultadosPorUsuario(idPregunta).then((data) => {
    //         // console.log(data);
    //         this.contruirTablaResultadosPorPregunta(data);
    //     });

    // }


    contruirTablaResultadosPorPregunta(data) {
        console.log(data);
        if('data' in data && 'etiqueta' in data){

            // Obtener una referencia al elemento canvas del DOM
            const $grafica = document.querySelector("#grafica");
            // Las etiquetas son las que van en el eje X. 
            const etiquetas = data.etiqueta
            // Podemos tener varios conjuntos de datos. Comencemos con uno
            const datosVentas2020 = {
                label: "Respuestas",
                data: data.data, // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
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


    eventos = () => {

        $(document).on("change", "select.handleChangeEncuesta", (e) => {            
        
            
        });


        $(document).on("change", "select.handleChangeUsuario", (e) => {            
            // let idUsuario = (e.currentTarget.value);
            let idEncuesta = document.querySelector("select[id='id_encuesta']").value;
            if(idUsuario>0){
                if(idEncuesta >0){
                    this.model.obtenerResultadosPorUsuario(idEncuesta,idUsuario).then((data) => {
                        console.log(data);
                        this.contruirTablaResultadosPorPregunta(data);
                    });
                }else{
                    Util.mensaje('info', 'Debe seleccionar una encuesta');
                }
            }else{
                Util.mensaje('info', 'Debe seleccionar un usuario');
            }
            
        });
    }


}
