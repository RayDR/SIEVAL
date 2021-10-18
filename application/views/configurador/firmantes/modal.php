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

<form id="fcFirmante" class="container formulario">
    <input type="hidden" id="firmante_id" name="firmante_id" value="<?= $firmante->firmante_id ?>">
    <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-transparent">
        <div class="row d-flex justify-content-between">
            <div class="col my-auto">
                <h2 class="h5 mb-4">Firmante <?= $firmante->firmante_id ?></h2>
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
                <div class="mb-3 col-12">
                    <label class="my-1 me-2" for="area_firma">Área Firma</label>
                    <select class="form-select areas_select2" id="area_firma" aria-label="Área de Firma">
                        <option selected disabled>Seleccione una opción</option>
                    </select>
                </div>
                <div class="mb-3 col-12">
                    <label class="my-1 me-2" for="usuario_firma">Usuario Responsable</label>
                    <select class="form-select usuarios_select2" id="usuario_firma" aria-label="Usuario que Firma">
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
}

function finicia_select2(){
    // Estilizar Select2
    $('.form-select').select2();
    // Configurar Select2 de Áreas
    $.get(url('Configurador/get_areas_select2')).then(function(data){
        return JSON.parse(data);
    }).then(function(data){
        if ( data.exito ){
            $('.areas_select2').select2({
                data: data.result,
                pagination: {
                    'more': true
                }
            });
        } else{
            fu_notificacion((data.error)? data.error: 'No se pudo obtener el resultado.', 'danger');
        }
    }).catch(function(error){
        fu_notificacion('Falló al obtener respuesta del servidor.<br>'+ error.message, 'danger');
    });

    $.get(url('Configurador/get_usuarios_select2')).then(function(data){
        return JSON.parse(data);
    }).then(function(data){
        if ( data.exito ){
            $('.usuarios_select2').select2({
                data: data.result,
                pagination: {
                    'more': true
                }
            });
        } else{
            fu_notificacion((data.error)? data.error: 'No se pudo obtener el resultado.', 'danger');
        }
    }).catch(function(error){
        fu_notificacion('Falló al obtener respuesta del servidor.<br>'+ error.message, 'danger');
    });
}
</script>