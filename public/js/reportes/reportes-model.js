class ReportesModel {

    constructor(token) {
        this.token = token;
    }

    obtenerEncuestas = (id) => {
        return $.ajax({
            url: route("configuracion.encuesta.obtener", {id: id}),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }

    obtenerPreguntasDeEncuesta (id) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: 'GET',
                url: 'obtener-preguntas-de-encuesta/'+id,
                datatype: "JSON",
                success: function (response) {
                    resolve(response)
                },
                error: function (err) {
                    reject(err) // Reject the promise and go to catch()
                }
            });

        });
    }
    obtenerInformacionDeAvance (id) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: 'GET',
                url: 'obtener-informacion-de-avance/'+id,
                datatype: "JSON",
                success: function (response) {
                    resolve(response)
                },
                error: function (err) {
                    reject(err) // Reject the promise and go to catch()
                }
            });

        });
    }
    
    guardarRespuesta  (payload) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: 'POST',
                url: 'guardar-respuesta',
                dataType: 'JSON',
                data:payload,
                
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function (data) {

                    $("#contenedorEncuesta").LoadingOverlay("show", {
                        imageAutoResize: true,
                        progress: true,
                        imageColor: "#3c8dbc"
                    });
                },
                success(response) {
                    resolve(response);
                    $("#contenedorEncuesta").LoadingOverlay("hide", true);

                },
                fail: function (jqXHR, textStatus, errorThrown) {
                    $("#contenedorEncuesta").LoadingOverlay("hide", true);
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        });
    }

    obtenerReporteGrafico (idEncuesta) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: 'GET',
                url: 'obtener-reporte-grafico/'+idEncuesta,
                datatype: "JSON",
                success: function (response) {
                    resolve(response)
                },
                error: function (err) {
                    reject(err) // Reject the promise and go to catch()
                }
            });

        });
    }
}
