class ListadoMuestreoModel {

    constructor(token) {
        this.token = token;
    }

    obtenerMuestreo = (id) => {
        return $.ajax({
            url: route("configuracion.muestreo.obtener_muestreo", {id: id}),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }
    obtenerFecha = (id) => {
        return $.ajax({
            url: route("configuracion.muestreo.obtener_fecha", {id: id}),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }
 

    registrarMuestreo = (data, route) => {
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
