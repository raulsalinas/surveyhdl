class ResumenUsuarioView {

    constructor(model) {
        this.model = model;
        this.indice = 0;
        this.encuesta = [];
        // this.idMuestreo = parseInt(location.search.split('id_muestreo=')[1]);
        // this.idEncuesta = parseInt(location.search.split('id_encuesta=')[1]);
    }

    obtenerInformacionDeResumen = () => {

        this.model.obtenerInformacionDeResumen().then((data) => {
            console.log(data);
            let cardEncuesta='';
            document.querySelector("span[id='totalIngresosAlSistema']").textContent=data.cantidad_inicios_sesion;
            document.querySelector("span[id='TotalDePreguntasContestadas']").textContent=data.cantidad_preguntas_contestadas;
            (data.encuestas).forEach(encuesta => {
                cardEncuesta +=`<div class="col-md-6 p-4" >
                <div class="card" style="width: auto">
                    <img src="/images/principal/${encuesta.pregunta!=null && encuesta.pregunta.length>0?'ready.svg':'no_data.svg'}" style="height: 90px;" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">${encuesta.nombre}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">${encuesta.pregunta!=null && encuesta.pregunta.length>0?'<span class="link-success">Encuesta Lista!</span>':'Aun no disponible'}</h6>
                        <p class="card-text">
                        <ul>
                            <li>Muestreo: ${encuesta.muestreo!=null?encuesta.muestreo.nombre:'Sin configurar'}</li>
                            <li>Preguntas: ${encuesta.pregunta!=null?encuesta.pregunta.length:0}</li>
                            <li>Fecha creacion:${ moment(encuesta.created_at, "DD-MM-YYYY").format("YYYY-MM-DD").toString()}</li>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>`;
            });

            document.querySelector("div[id='contenedorResumenEncuestas']").insertAdjacentHTML('beforeend', cardEncuesta);

        });
    }

    eventos = () => {

        // $("#contenedorRespuestas").on("click", "input.handleRadioButtonRespuesta", (e) => {
        //     let that = this;
        //     (this.encuesta[this.indice]['respuestas']).forEach((resp, index) => {
        //         if (resp.id == e.currentTarget.value) {

        //             resp.muestra_pregunta_respuesta = {
        //                 'id': this.makeId(),
        //                 'muestreo_id': this.idMuestreo,
        //                 'personal_id': ((auth_user.personal != null && auth_user.personal.hasOwnProperty('id')) ? auth_user.personal.id : ''),
        //                 'respuesta_id': parseInt(e.currentTarget.value),
        //                 'created_at': '',
        //                 'updated_at': '',
        //                 'deleted_at': '',
        //             };
    }


}
