class ListadoEncuestaMenuView {

    constructor(model) {
        this.model = model;
    }

    listar = () => {


        this.model.getMenuEncuestaList().then((respuesta) => {
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
                        <a href="llenar-encuesta/${element.id_encuesta}" class="card-link">Continuar <i class="fa-solid fa-hand-point-right"></i></a>
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
