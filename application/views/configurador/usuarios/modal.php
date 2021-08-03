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

<form id="fceUsuario" class="container formulario">
    <input type="hidden" id="usuario_id" name="usuario_id" value="<?= $usuario->usuario_id ?>">
    <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-transparent">        
        <div class="row">
            <div class="col-12 mb-3">
                <?php $this->load->view(RUTA_TEMA_UTIL . '/alertas'); ?>
            </div>
        </div>
        <div class="row d-flex justify-content-between">
            <div class="col my-auto">
                <h3 class="h5 mb-4">Cuenta: <?= $usuario->cve_cuenta ?></h3>
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
                <div class="col-lg-4 mb-2">
                    <label for="nombres"><span class="text-danger">*</span> Nombre(s)</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" data-label="Nombre(s)" value="<?= $usuario->nombres ?>" required>
                </div>
                <div class="col-lg-4 mb-2">
                    <label for="primer_apellido"><span class="text-danger">*</span> Primer Apellido</label>
                    <input type="text" name="primer_apellido" id="primer_apellido" class="form-control" data-label="Primer Apellido" value="<?= $usuario->primer_apellido ?>" required>
                </div>
                <div class="col-lg-4 mb-2">
                    <label for="segundo_apellido">Segundo Apellido</label>
                    <input type="text" name="segundo_apellido" id="segundo_apellido" class="form-control" data-label="Segundo Apellido" value="<?= $usuario->segundo_apellido ?>">
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="sexo">Sexo</label>
                    <select id="sexo" name="sexo" class="form-control" data-label="Sexo" required>
                        <option disabled selected>Seleccione una opción</option>
                        <option value="H" <?= ($usuario->sexo == 'H')? 'selected' : '' ?>>HOMBRE</option>
                        <option value="M" <?= ($usuario->sexo == 'M')? 'selected' : '' ?>>MUJER</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="my-1 me-2" for="area_usuaria"><span class="text-danger">*</span> Área Usuaria</label>
                    <select class="form-select areas_select2" id="area_usuaria" name="area_usuaria" data-label="Área Usuaria" aria-label="Áreas" required>
                        <option selected disabled>Seleccione una opción</option>
                    </select>
                </div>
                <div class="col-lg-4 mb-2">
                    <label for="cuenta"><span class="text-danger">*</span> Cuenta</label>
                    <input type="text" id="cuenta" name="cuenta" class="form-control" data-label="Usuario" value="<?= $usuario->cve_cuenta ?>" required>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="categoria"><span class="text-danger">*</span> Categoría</label>
                    <select id="categoria" name="categoria" class="form-control" data-label="Categoría" required>
                        <option disabled selected>Seleccione una opción</option>
                        <?php foreach ($categorias as $key => $categoria): ?>
                        <option value="<?= $categoria->categoria_id ?>" <?= ($usuario->categoria_id == $categoria->categoria_id)? 'selected' : '' ?>><?= $categoria->descripcion ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-6 mb-2">
                    <label for="correo"><span class="text-danger">*</span> Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" class="form-control" data-label="Correo Electrónico" value="<?= $usuario->correo ?>" required>
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" name="telefono" id="telefono" class="form-control" data-label="Teléfono" value="<?= $usuario->telefono ?>">
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
    
    var datos   = $('#fceUsuario').serializeArray()
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
        $.post(url('Configurador/editar/usuario'), datos, function(data, textStatus, xhr) {
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
            $('.areas_select2').val(<?= $usuario->combinacion_area_usuario_id ?>).select2();
        }
    }
}
</script>