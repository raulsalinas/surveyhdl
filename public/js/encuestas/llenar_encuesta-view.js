class LlenarEncuestaView {

    constructor(model) {
        this.model = model;
        this.indice = 0;
        this.encuesta = [];
        this.idMuestreo = parseInt(location.search.split('id_muestreo=')[1]);
        this.idEncuesta = parseInt(location.search.split('id_encuesta=')[1]);
    }

    listarPreguntas = () => {

        this.model.obtenerPreguntasDeEncuesta(this.idEncuesta).then((data) => {
            console.log(data);
            this.encuesta = data;
            this.construirContenidoContenedorPreguntaYRespuestas(data[this.indice].encuesta.nombre, parseInt(this.indice) + 1, data.length, data[this.indice].nombre, data);
            // (respuesta).forEach(element => {
            //     html += `<div class="col-md-3 p-2">
            //     <div class="card" style="width: 20rem;">
            //         <h5 class="card-header">${element.nombre_encuesta}</h5>
            //         <div class="card-body">
            //             <h5 class="card-title"></h5>
            //             <h6 class="card-subtitle mb-2 text-muted">Total de preguntas: ${element.total_preguntas}</h6>
            //             <h6 class="card-subtitle mb-2 text-muted">Completadas: ${element.cantidad_preguntas_completadas}</h6>
            //             <h6 class="card-subtitle mb-2 text-muted">Por completar: ${element.cantidad_preguntas_por_completar}</h6>
            //             <a href="llenar-encuesta/${element.id_encuesta}" class="card-link">Continuar <i class="fa-solid fa-hand-point-right"></i></a>
            //         </div>
            //     </div>
            // </div>`;
            // });

            // document.querySelector("div[id='contenedorEncuestas']").insertAdjacentHTML('beforeend', html)

            // }).catch(function (err) {
            //     console.log(err)
            // });
        });


    }

    mostrarInformacionDeAvance = () => {

        this.model.obtenerInformacionDeAvance(this.idEncuesta).then((data) => {
            let cantidadTotalDePreguntas= parseInt(data[0]['total_preguntas'])??0;
            let cantidadPreguntasPorContestar= parseInt(data[0]['cantidad_preguntas_por_completar'])??0;
            let cantidadPreguntasContestadas= parseInt(data[0]['cantidad_preguntas_completadas'])??0;
            let porcentajePreguntasContestadas= '%'+ (cantidadPreguntasContestadas*100/cantidadTotalDePreguntas).toFixed(2);
            document.querySelector("span[id='porcentajeAvance']").innerHTML= porcentajePreguntasContestadas ;
            document.querySelector("span[id='cantidadPreguntasSinContestar']").innerHTML= cantidadPreguntasPorContestar;
            document.querySelector("span[id='cantidadPreguntasContestadas']").innerHTML= cantidadPreguntasContestadas;
        });
    }

    construirContenidoContenedorPreguntaYRespuestas(nombreTipoEncuesta, numeroPreguntaActual, numeroTotalPreguntas, nombrePreguntaActual, data) {
        document.querySelector("span[id='nombre_tipo_encuesta']").textContent = nombreTipoEncuesta;
        document.querySelector("span[id='pregunta_actual']").textContent = numeroPreguntaActual;
        document.querySelector("span[id='total_preguntas']").textContent = numeroTotalPreguntas;
        document.querySelector("h4[id='contenedorNombrePregunta']").textContent = nombrePreguntaActual;
        let htmlRespuestas = '';
        document.querySelector("div[id='contenedorRespuestas']").innerHTML = htmlRespuestas;

        (data).forEach((pregunta, indexPregunta) => {
            if (indexPregunta == this.indice) {
                (pregunta.respuestas).forEach(respuesta => {
                    htmlRespuestas += ` 
                    <div class="custom-control-input">
                    <input class="custom-control-input-input handleRadioButtonRespuesta" type="radio" name="exampleRadios" id="exampleRadios1" value="${respuesta.id}" ${(((respuesta.muestra_pregunta_respuesta != null) && (respuesta.muestra_pregunta_respuesta).hasOwnProperty('id')) ? 'checked' : '')} >
                    <label class="custom-control-input-label" for="exampleRadios1">
                    ${respuesta.nombre}
                    </label>
                    </div>
                    `;
                });
            }
        });
        document.querySelector("div[id='contenedorRespuestas']").insertAdjacentHTML('beforeend', htmlRespuestas);

    }

    makeId() {
        let ID = "";
        let characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for (var i = 0; i < 12; i++) {
            ID += characters.charAt(Math.floor(Math.random() * 36));
        }
        return ID;
    }

    eventos = () => {

        // $("#tablaEncuesta").on("click", "button.editar", (e) => {
        //     $("#modalEditarAgregarEncuesta").modal("show");
        //     this.obtenerEncuestas(e.currentTarget.dataset.id);
        //     $("#btnGuardar").attr("data-evento", "editar");
        //     $("#btnGuardar").prop("disabled", false);

        // });

        $("#contenedorRespuestas").on("click", "input.handleRadioButtonRespuesta", (e) => {
            let that = this;
            (this.encuesta[this.indice]['respuestas']).forEach((resp, index) => {
                if (resp.id == e.currentTarget.value) {

                    resp.muestra_pregunta_respuesta = {
                        'id': this.makeId(),
                        'muestreo_id': this.idMuestreo,
                        'personal_id': ((auth_user.personal != null && auth_user.personal.hasOwnProperty('id')) ? auth_user.personal.id : ''),
                        'respuesta_id': parseInt(e.currentTarget.value),
                        'created_at': '',
                        'updated_at': '',
                        'deleted_at': '',
                    };

                    // console.log(resp.muestra_pregunta_respuesta);
                    // guardar respuesta 
 

                    this.model.guardarRespuesta(resp.muestra_pregunta_respuesta).then(function (response) {
                        if (response.estado == 'success') {
                            Lobibox.notify('success', {
                                title: false,
                                size: 'mini',
                                rounded: true,
                                sound: false,
                                delayIndicator: false,
                                msg: response.mensaje
                            });

                            that.mostrarInformacionDeAvance();

                        } else {
                            Swal.fire(
                                'Error en el servidor',
                                response.mensaje,
                                response.estado
                            );
                        }

                        }).catch(function (err) {
                            console.log(err)
                        });

                }

            });
        });

        $("#contenedorEncuesta").on("click", "button.handlePreviousPage", (e) => {
            if (this.indice > 0) {
                this.indice = this.indice - 1;
            }
            // document.querySelector("span[id='pregunta_actual']").textContent=(parseInt(this.indice)+1);
            // document.querySelector("h4[id='contenedorNombrePregunta']").textContent=this.encuesta[this.indice].nombre;
            this.construirContenidoContenedorPreguntaYRespuestas(this.encuesta[this.indice].encuesta.nombre, parseInt(this.indice) + 1, this.encuesta.length, this.encuesta[this.indice].nombre, this.encuesta);

        });
        $("#contenedorEncuesta").on("click", "button.handleNextPage", (e) => {

            if (this.indice < this.encuesta.length) {
                this.indice = this.indice + 1;
            }
            // document.querySelector("span[id='pregunta_actual']").textContent=(parseInt(this.indice)+1);
            // document.querySelector("h4[id='contenedorNombrePregunta']").textContent=this.encuesta[this.indice].nombre;
            this.construirContenidoContenedorPreguntaYRespuestas(this.encuesta[this.indice].encuesta.nombre, parseInt(this.indice) + 1, this.encuesta.length, this.encuesta[this.indice].nombre, this.encuesta);

        });
    }


}
