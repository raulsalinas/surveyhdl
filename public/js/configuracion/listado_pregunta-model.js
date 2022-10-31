class ListadoPreguntaModel {

    constructor(token) {
        this.token = token;
    }

    obtenerPreguntas = (id) => {
        return $.ajax({
            url: route("configuracion.pregunta.obtener", {id: id}),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }
    obtenerRespuestas = (id) => {
        return $.ajax({
            url: route("configuracion.pregunta.respuesta.obtener", {id: id}),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }

    registrarPregunta = (data, route) => {
        return $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
    registrarRespuesta = (data, route) => {
        return $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
}
