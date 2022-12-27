class ResumenUsuarioModel {

    constructor(token) {
        this.token = token;
    }

    obtenerInformacionDeResumen () {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: 'POST',
                url: 'obtener-informacion-de-resumen',
                datatype: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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
