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
                    <label for="nombre_proyecto">Nombre del Proyecto</label>
                    <input type="text" name="nombre_proyecto" id="nombre_proyecto" class="form-control" value="<?= $proyecto->proyecto_nombre ?>">
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

function finicia_select2(){
    // Estilizar Select2
    $('.form-select').select2();
    // Configurar Select2 de Áreas
    var datos_select2 = fu_json_query(url('Configurador/get_areas_select2', true, false));
    if ( datos_select2 ){
        if ( datos_select2.exito ){
            $('.areas_select2').select2({
                data: datos_select2.result,
                pagination: {
                    'more': true
                }
            });
        }
    }
}

function fmConfEditar(){
    
}
</script>