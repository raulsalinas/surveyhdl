class DashboardModel {

    constructor(token) {
        this.token = token;
    }

    obtenerCifrasTotales () {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: 'GET',
                url: 'obtener-cifras-totales',
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
    obtenerCantidadUsuariosActivosYBajas () {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: 'GET',
                url: 'obtener-usuarios-activos-y-bajas',
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
    obtenerAvanceDeUsuarios() {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: 'GET',
                url: 'obtener-avance-de-usuarios',
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
    obtenerPreguntaList(id) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: 'GET',
                url: 'obtener-preguntas/'+id,
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
    obtenerResultadosPorPregnta(id) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: 'GET',
                url: 'obtener-resultado-por-pregunta/'+id,
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
