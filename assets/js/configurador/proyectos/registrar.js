 $(document).ready(function() {
    $('#guardar').click(fguardar);
    $('#linea_accion').change(flinea_accion);
    $('.objetivos').change(faObjetivos);

    finicia_select2();
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
            let valor           = $(`#${input.nombre}`).val();
            datos[input.nombre] = valor;
            if( valor == '' || valor == null || valor == undefined )
                errores += `El campo <a href="#${input.nombre}">${input.texto}</a> es requerido.<br>`;            
        });
        if ( ! errores ){
            respuesta   = fu_json_query(
                url('Configurador/registra_proyecto', true, false),
                datos 
            );
            if ( respuesta.exito ){
                fu_notificacion('Se ha registrado el proyecto exitosamente.', 'success');
                window.location.replace( url('Configurador/proyectos') );
            } else
                fu_notificacion(respuesta.mensaje, 'danger');
        } else {
            fu_alerta(errores, 'danger');
            fu_notificacion('Existen campos pendientes por llenar.', 'danger');    
        }
    } catch(e) {
        fu_alerta('Ha ocurrido un error al guardar el proyecto, intentelo más tarde.', 'danger');
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
    $('#programados').show();
}

function faObjetivos(){
    var objetivo = $(this).val();
    if ( $.isNumeric(objetivo) ){
        if ( objetivo > 0 )
            $(this).closest('.card').find('.meses').attr({readonly: false});
    }
}