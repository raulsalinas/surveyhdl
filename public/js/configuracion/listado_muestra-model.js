class ListadoMuestraModel {

    constructor(token) {
        this.token = token;
    }

    obtenerMuestra = (id) => {
        return $.ajax({
            url: route("configuracion.muestra.obtener", {id: id}),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }

    registrarMuestra = (data, route) => {
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
