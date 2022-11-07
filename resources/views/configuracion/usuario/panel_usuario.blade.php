@section('cabecera')
Gestión de Usuarios
@endsection

@extends('layouts.app')

@section('content')
<div class="container-md pt-4 p-3 border bg-light">

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-condensed table-hover" id="tablaUsuario" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Tipo</th>
                        <th>Nombres</th>
                        <th>Apellido paterno</th>
                        <th>Apellido materno</th>
                        <th>Email</th>
                        <th>Nro documento</th>
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


@include('configuracion.usuario.modal_editar_agregar_usuario')
@include('configuracion.usuario.modal_acceso_usuario')

</div>




@endsection

@section('scripts')
<script src="{{ asset('js/configuracion/listado_usuario-view.js?v=1') }}"></script>
<script src="{{ asset('js/configuracion/listado_usuario-model.js?v=1') }}"></script>
<script>
    $(document).ready(function() {
        const listadoUsuarioView = new ListadoUsuarioView(new ListadoUsuarioModel(csrf_token));
        listadoUsuarioView.listar(null);
        listadoUsuarioView.eventos();


    });
</script>

@endsection