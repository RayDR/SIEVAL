$(document).off('change','.meses').on('change','.meses',fcalcular_total);

$(document).ready(function() {
    $('#guardar').click(fguardar);
    $('#area_origen').change(fget_ums);
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
            if ( input.nombre == 'financiero_objetivo_anual' || input.nombre == 'fisico_objetivo_anual'){
                if ( valor < 0 ){
                    errores += `El <a href="#${input.nombre}">${input.texto}</a> no puede ser menor de 0.<br>`;
                }
            } else if ( input.nombre == 'programado-fisico' ){
                if ( !fejecuta_calculo_total('fisico') )
                    errores += `El <a href="#${input.nombre}">${input.texto}</a> no es correcto.<br>`;
                else{
                    pFisico = $(`#${input.nombre} .meses`);
                    dFisico = [];
                    pFisico.each(function(index, mes) {
                        dFisico.push($(mes).val());
                    });
                    datos[input.nombre] = dFisico;
                }
            } else if ( input.nombre == 'programado-financiero' ){
                if ( !fejecuta_calculo_total('financiero') )
                    errores += `El <a href="#${input.nombre}">${input.texto}</a> no es correcto.<br>`;
                else{
                    pFinanciero = $(`#${input.nombre} .meses`);
                    dFinanciero = [];
                    pFinanciero.each(function(index, mes) {
                        dFinanciero.push($(mes).val());
                    });
                    datos[input.nombre] = dFinanciero;
                }
            } else if( valor == '' || valor == null || valor == undefined )
                errores += `El campo <a href="#${input.nombre}">${input.texto}</a> es requerido.<br>`;
            
        });
        if ( ! errores ){
            respuesta   = fu_json_query(
                url('Actividades/guardar', true, false),
                datos 
            );
            if ( respuesta.exito ){
                fu_notificacion('Se ha registrado la actividad exitosamente.', 'success');
                window.location.replace( url('Actividades') );
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

function fget_ums(){
    var combinacion_area = $(this).val();
    if ( combinacion_area ){
        var select2 = fu_json_query(url('Configurador/get_ums_select2', true, false), {combinacion_area: combinacion_area});
        if ( select2 ){
            if ( select2.exito ){
                $('#unidad_medida').html('<option selected disabled>Seleccione una opción</option>');
                select2.result.forEach( function(unidad_medida, index) {
                    $('#unidad_medida').append(`
                        <option value="${unidad_medida.id}">${unidad_medida.text}</option>
                    `);
                });
            }
            if ( select2.mensaje )
                fu_notificacion(select2.mensaje, (!select2.exito)? 'danger' : 'warning');
        } else 
            fu_notificacion('No se obtuvo respuesta del servidor.', 'danger');
    }
}

function fcalcular_total(){
    var tipo    = $(this).data('tipo'); // Tipo de programado

    fejecuta_calculo_total(tipo);
}

function fejecuta_calculo_total(tipo){
    var meses   = $(`#programado-${tipo} .meses`),      // Lista de meses
        totalA  = $(`#${tipo}_objetivo_anual`).val(),   // Total Anual
        totalP  = 0         // Total Ponderado
        exito   = false;    // Respuesta de resultado

    $(`#${tipo}_rebase`).html('');  // Limpiar errores

    meses.each(function(index, mes) { // Obtener total ponderado
        $(mes).removeClass('is-valid');
        totalP += parseFloat($(mes).val());
    });
    if ( parseFloat(totalA) != parseFloat(totalP) ){
        $(this).addClass('is-invalid');
        if ( parseFloat(totalA) < parseFloat(totalP) )
            $(`#${tipo}_rebase`).html(`
                El ponderado mensual es <b>mayor</b> que el <b>Objetivo Anual</b>. 
                <span class="font-weight-bold text-primary">Excedente: ${ parseFloat(totalP) - parseFloat(totalA) }</span>
            `);
        else if ( parseFloat(totalA) > parseFloat(totalP) )
            $(`#${tipo}_rebase`).html(`
                El ponderado mensual es <b>menor</b> que el <b>Objetivo Anual</b>. 
                <span class="font-weight-bold text-primary">Restante: ${ parseFloat(totalA) - parseFloat(totalP) }</span>
            `);
        else
            $(`#${tipo}_rebase`).html(`Ajuste el <b>Objetivo Anual</b> o redistribuya el <b>Mensual Ponderado</b> según sea necesario.`);
    } else {
        meses.each(function(index, mes) { $(mes).removeClass('is-invalid').addClass('is-valid'); });
        exito = true;
    }
    return exito; 
}

function faObjetivos(){
    var objetivo = $(this).val();
    if ( $.isNumeric(objetivo) ){
        if ( objetivo > 0 )
            $(this).closest('.card').find('.meses').attr({readonly: false});
    }
}