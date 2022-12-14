class ListadoEncuestaMenuView {

    constructor(model) {
        this.model = model;
    }

    listar = () => {

        let idMuestreoByURL = parseInt(location.search.split('id_muestreo=')[1]);
        let idEncuestaByURL = parseInt(location.search.split('id_encuesta=')[1]);

        this.model.getMenuEncuestaList(idMuestreoByURL,idEncuestaByURL).then((respuesta) => {
            // console.log(respuesta);
            let html='';
            (respuesta).forEach(element => {
                html += `<div class="col-md-3 p-2">
                <div class="card" style="width: 20rem;">
                    <h5 class="card-header">${element.nombre_encuesta}</h5>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Total de preguntas: ${element.total_preguntas}</h6>
                        <h6 class="card-subtitle mb-2 text-muted">Completadas: ${element.cantidad_preguntas_completadas}</h6>
                        <h6 class="card-subtitle mb-2 text-muted">Por completar: ${element.cantidad_preguntas_por_completar}</h6>
                        <a href="llenar-encuesta?id_encuesta=${element.id_encuesta}&id_muestreo=${idMuestreoByURL}" class="card-link">Continuar <i class="fa-solid fa-hand-point-right"></i></a>
                    </div>
                </div>
            </div>`;
            });

            document.querySelector("div[id='contenedorEncuestas']").insertAdjacentHTML('beforeend', html)

        }).catch(function (err) {
            console.log(err)
        });




    }

    eventos = () => {

        // $("#tablaEncuesta").on("click", "button.editar", (e) => {
        //     $("#modalEditarAgregarEncuesta").modal("show");
        //     this.obtenerEncuestas(e.currentTarget.dataset.id);
        //     $("#btnGuardar").attr("data-evento", "editar");
        //     $("#btnGuardar").prop("disabled", false);

        // });

        // $("#modalEditarAgregarEncuesta").on("click", "input.handleSwitchEstadoEncuesta", (e) => {
        //     this.actualizarEstadoInputSwitch(e.currentTarget.checked);
        // });

    }
}
