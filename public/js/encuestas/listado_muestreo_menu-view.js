class ListadoMuestreoMenuView {

    constructor(model) {
        this.model = model;
    }

    listar = () => {

        console.log("listar");
        this.model.getMenuMuestreoList().then((respuesta) => {
            console.log(respuesta);
            let html='';
            (respuesta).forEach(element => {
                html += `<div class="col-md-3 p-2">
                <div class="card" style="width: 20rem;">
                    <h5 class="card-header">Muestreo: ${element.nombre}</h5>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Encuesta: <strong>${element.nombre_encuesta}</strong></h6>
                        <h6 class="card-subtitle mb-2 text-muted">Fecha creación: ${moment(element.created_at).format("DD-MM-YYYY")}</h6>
                        <a href="/encuestas/encuesta/index?id_muestreo=${element.id}&id_encuesta=${element.id}" class="card-link">Ingresar <i class="fa-solid fa-hand-point-right"></i></a>
                    </div>
                </div>
            </div>`;
            });

            document.querySelector("div[id='contenedorMuestreo']").insertAdjacentHTML('beforeend', html)

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
