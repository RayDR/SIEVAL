$(document).ready(function() {
    $('#guardar').click(fguardar);    
    $('#linea_accion').change(flinea_accion);
    $('#url').blur(fset_url);

    finicia_edicion();
});

function finicia_edicion(){
    $('#linea_accion').val(linea_accion).trigger('change');
}

function fguardar(e){
    e.preventDefault();
    $('#guardar').html(`
        <button class="btn btn-primary" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="ms-1">Registrando...</span>
        </button>`);

    var respuesta,
        errores = '',
        datos   = {};

    try {
        // Validar valores
        inputs.forEach( function(input, index) {
            // Asignación de valores
            let valor           = $(`#${input.nombre}`).val();
            datos[input.nombre] = valor;
            // Validación de campos
            if(  (valor == '' || valor == null || valor == undefined) && $(`#${input.nombre}`).attr('required') )
                errores += `El campo <a href="#${input.nombre}">${input.texto}</a> es requerido.<br>`;
            else if ( input.nombre == 'inversion' || input.nombre == 'cantidad_beneficiada'  ){
                if ( valor < 0 )
                    errores += `El campo <a href="#${input.nombre}">${input.texto}</a> no puede ser menor 0.<br>`;
            } else if ( input.nombre == 'incluido' )
                datos[input.nombre] = $(`#${input.nombre}`).is(':checked')? true : false;
        });
        datos['preproyecto'] = $('#preproyecto').val();
        if ( ! errores ){
            respuesta   = fu_json_query(
                url('Preproyectos/guardar_edicion', true, false),
                datos 
            );
            if ( respuesta.exito ){
                fu_notificacion('Se ha registrado la preproyecto exitosamente.', 'success');
                window.location.replace( url('Preproyectos') );
            } else
                fu_notificacion(respuesta.error, 'danger');
        } else {
            fu_alerta(errores, 'danger');
            fu_notificacion('Existen campos pendientes por llenar.', 'danger');    
        }
    } catch(e) {
        fu_alerta('Ha ocurrido un error al guardar la preproyecto, intentelo más tarde.', 'danger');
    }

    $('#guardar').prop({disabled: false});
    $('#guardar').html(`Guardar`);
}

function flinea_accion(){
    var seleccion = $(this).find(':selected');
    if ( seleccion ){
        $('#datos_linea_accion').html(`
            <label class="h6"><span class="text-secondary">Objetivo:</span> <small class="font-weight-bold">${seleccion.data('objetivo')}</small></label>
            <br>
            <label class="h6"><span class="text-secondary">Estrategia:</span> <small class="font-weight-bold">${seleccion.data('estrategia')}</small></label>
        `);
    }
}