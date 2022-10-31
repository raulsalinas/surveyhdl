class ListadoEncuestaModel {

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

    registrarEncuesta = (data, route) => {
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
