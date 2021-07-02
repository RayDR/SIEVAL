$(document).ready(function() {
    $('#guardar').click(fguardar);
    $('#municipio').change(fget_localidades);
    $('#trimestre').change(fset_trimestre);
    $('#url').blur(fset_url);

    fcalcula_trimestre();
    finicia_select2();
});

function finicia_select2(){    
    $('#localidad').select2();
    // Cargar Select2 y establecer Centro como Opción por defecto
    $('#municipio').select2();
    // Autocargar alcance estatal
    if ( lastMunicipio ){
        $.when($("#municipio").val(lastMunicipio).change()).then(function() {
            $("#localidad").val(lastLocalidad).select2();
        });
    }
    if ( trimestre )
        $('#trimestre').val(trimestre).trigger('change');
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

        if ( ! errores ){
            datos['actividad_id'] = $('#actividad_id').val();
            respuesta   = fu_json_query(
                url('Preproyectos/edicion_actividad', true, false),
                datos 
            );
            if ( respuesta.exito ){
                fu_notificacion('Se ha actualizado la actividad exitosamente.', 'success');
                window.location.replace( url('Preproyectos') );
            } else
                fu_notificacion(respuesta.mensaje, 'danger');
        } else {
            fu_alerta(errores, 'danger');
            fu_notificacion('Existen campos pendientes por llenar.', 'danger');    
        }
    } catch(e) {
        fu_alerta('Ha ocurrido un error al guardar la actividad, intentelo más tarde.', 'danger');
    }

    $('#guardar').prop({disabled: false});
    $('#guardar').html(`Guardar`);
}

function fget_localidades(){
    var municipio = $(this).val();
    if ( municipio ){
        var respuesta = fu_json_query(url('Preproyectos/select_localidades', true, false), {municipio: municipio});
        if ( respuesta ){
            if ( respuesta.exito ){
                $('#localidad').html('<option selected disabled>Seleccione una opción</option>');
                respuesta.localidades.forEach( function(localidad, index) {
                    $('#localidad').append(`
                        <option value="${localidad.localidad_id}">${localidad.descripcion}</option>
                    `);
                });
                // Autocargar alcance estatal
                if ( $("#municipio").val() == 18 )
                    $("#localidad").val($("#localidad option:not([disabled]):first").val()).select2();
            }
            if ( respuesta.mensaje )
                fu_notificacion(respuesta.mensaje, (!respuesta.exito)? 'danger' : 'warning');
        } else 
            fu_notificacion('No se obtuvo respuesta del servidor.', 'danger');
    }
}