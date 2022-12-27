class ListadoMuestreoMenuModel {

    constructor(token) {
        this.token = token;
    }

    getMenuMuestreoList () {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: 'GET',
                url: 'menu-muestreo',
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
