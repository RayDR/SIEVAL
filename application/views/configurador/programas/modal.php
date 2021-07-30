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

<?php $programa = $programa[0]; ?>
<form id="fcePrograma" class="container formulario">
    <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-transparent">
        <div class="row d-flex justify-content-between">
            <div class="col my-auto">
                <h2 class="h5 mb-4">Programa Presupuestario: <?= $programa->programa_presupuestario_id ?></h2>
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
                <div class="col-md-4 col-lg-2 mb-2">
                    <label for="clave">Clave</label>
                    <input type="text" name="clave" id="clave" class="form-control" value="<?= $programa->cve_programa ?>">
                </div>
                <div class="col-md-8 col-lg-10 mb-2">
                    <label for="nombre">Nombre de Programa Presupuestario</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?= $programa->nombre ?>">
                </div>
                <div class="col-12 mb-2">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="5"><?= $programa->descripcion ?></textarea>
                </div>
                <div class="col-12 mb-2">
                    <label for="objetivo">Objetivo</label>
                    <textarea class="form-control" name="objetivo" id="objetivo" cols="30" rows="3"><?= $programa->objetivo ?></textarea>
                </div>            
                <div class="col-lg-6 mb-2">
                    <label for="techo_financiero">Techo Financiero</label>
                    <input type="text" name="techo_financiero" id="techo_financiero" class="form-control" value="<?= $programa->techo_financiero ?>">
                </div>

                <input id="guardar" type="submit" value="Editar" class="btn btn-primary my-3" style="display: none;">
            </div>
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

function fmConfEditar(e){
    e.preventDefault();
    $('#guardar').attr({disabled: true});
    $('#guardar').html(`
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="ms-1">Registrando...</span>
    `);
    datos = {
        
    }
    $.post(url('Configurador/editar/usuario'), datos, function(data, textStatus, xhr) {
        loader();
    }).then(function(data){
        return JSON.parse(data);
    }).then(function(data){
        if ( data.exito ){
           fu_notificacion('Registro exitoso.', 'success');
           window.location.replace( url('Configurador/proyectos') );
           $('#guardar').html('');
           $('#guardar').attr({disabled: true});
        } else{
            $('#guardar').attr({disabled: false});
           fu_notificacion(data.mensaje, 'danger');
           $('#guardar').html(`Guardar`);
        }
        loader(false);
    }).catch(function(error){
        loader(false);
        $('#guardar').attr({disabled: false});
        $('#guardar').html(`Reintentar`);
        fu_notificacion('Falló al obtener la respuesta del servidor. Contacte al administrador.', 'danger');
    });
}
</script>