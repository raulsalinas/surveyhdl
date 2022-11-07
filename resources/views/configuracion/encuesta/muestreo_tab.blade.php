@section('links')
@endsection

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-condensed table-hover" id="tablaMuestreo" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th width="20%">Nombre nuestreo</th>
                        <th width="20%">Nombre encuesta</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
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

@include('configuracion.encuesta.modal_editar_agregar_muestreo')
@include('configuracion.encuesta.modal_editar_agregar_muestreo_fecha')
@include('configuracion.encuesta.modal_editar_agregar_fecha')