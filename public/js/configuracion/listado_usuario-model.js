class ListadoUsuarioModel {

    constructor(token) {
        this.token = token;
    }

    obtenerUsuario = (id) => {
        return $.ajax({
            url: route("configuracion.usuario.obtener", {id: id}),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }
    obtenerAccesoUsuario = (id) => {
        return $.ajax({
            url: route("configuracion.usuario.obtener_acceso", {id: id}),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }

    registrarUsuario = (data, route) => {
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
    registrarAccesoUsuario = (data, route) => {
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
