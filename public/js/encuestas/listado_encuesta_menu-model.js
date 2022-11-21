class ListadoEncuestaMenuModel {

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

    getMenuEncuestaList () {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: 'GET',
                url: 'menu-encuesta',
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
