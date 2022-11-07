@section('links')
@endsection

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-condensed table-hover" id="tablaMuestra" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nombre muestra</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Autor</th>
                        <th>Fecha creación</th>
                        <th>Fecha actualización</th>
                        <th>Fecha anulación</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>


@include('configuracion.encuesta.modal_editar_agregar_muestra')
