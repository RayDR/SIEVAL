<style type="text/css" media="screen">
    .nav-link:hover, .nav-link:focus {
        background-color: #D1D5DB;
    } 
    .nav-pills .nav-link:hover{
        background-color: #D1D5DB;
    }
    .accordion-button{
        color: white;
    }
    .accordion-button:hover{
        color: #262B40;
    }
</style>

<form id="fceProyecto" class="container formulario">
    <input type="hidden" id="proyecto_actividad_id" name="proyecto_actividad_id" value="<?= $proyecto->proyecto_actividad_id ?>">
    <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-transparent">
        <div class="row d-flex justify-content-between">
            <div class="col my-auto">
                <h2 class="h5 mb-4">Proyecto <?= $proyecto->proyecto_actividad_id ?></h2>
            </div>
            <div class="col">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-center justify-content-end px-0 bg-transparent">
                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-pill-circle flex-column flex-md-row">
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-white" style="color: #000 !important;">
            <div class="row mb-3">
                <div class="col-lg-6 mb-2">
                    <label for="proyecto_nombre">Nombre del Proyecto</label>
                    <input type="text" name="proyecto_nombre" id="proyecto_nombre" class="form-control" value="<?= $proyecto->proyecto_nombre ?>">
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="techo_financiero">Techo Financiero</label>
                    <input type="text" name="techo_financiero" id="techo_financiero" class="form-control" value="<?= $proyecto->techo_financiero ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="my-1 me-2" for="area_usuaria">Área Responsable</label>
                    <select class="form-select areas_select2" id="area_usuaria" aria-label="Áreas">
                        <option selected disabled>Seleccione una opción</option>
                    </select>
                </div>
            </div>

            <input id="guardar" type="submit" value="Editar" class="btn btn-primary my-3" style="display: none;">
        </div>
    </div>
</form>

<script type="text/javascript">
$(document).ready(function($) {
    finicia_select2();
    $('.formulario').change(function(event) {
       $('#guardar').fadeIn('slow');
    });
    $('#guardar').click(fmConfEditar);
});

function fmConfEditar(e){
    e.preventDefault();
    
    var datos   = $('#fceProyecto').serializeArray()
        errores = '';

    datos.forEach( function(input, index) {
        if ( input.length == 0 && $(`#${input.name}`).attr('required') ){
            errores += `El campo <a href="#${input.name}">${ $(`#${input.name}`).data('label') }</a> es requerido.<br>`;
        }
    });

    if ( errores.length > 0 ){
        fu_notificacion('Por favor, complete los campos correctamente', 'danger');
        alert(errores, 'warning');
    } else { // GO
        $.post(url('Configurador/editar/proyecto'), datos, function(data, textStatus, xhr) {
            loader();
        }).then(function(data){
            return JSON.parse(data);
        }).then(function(data){
            if ( data.exito ){
                fu_notificacion('Datos actualizados', 'success');
            } else 
                fu_notificacion((data.error)? data.error : 'Falló la operación','danger');
            loader(false);
        }).catch(function(error){
            loader(false);
            fu_notificacion('Falló al obtener la respuesta del servidor. Contacte al administrador.', 'danger');
        });
    }
}
</script>