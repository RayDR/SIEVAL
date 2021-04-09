$(document).ready(function() {
    $('#guardar').click(fguardar);

    var datos_select2 = fu_json_query(url('Configurador/get_areas_select2'));
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
});

function fguardar(e){
    e.preventDefault();
    $('#guardar').prop({disabled: true});
    $('#guardar').html(`
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="ms-1">Finalizando...</span>`);

    var respuesta,
        errores = '',
        datos   = {},
        inputs  = [
        {
            'nombre': 'acuerdo_id'
        },
        {
            'nombre': 'area_destino',
            'texto' : 'Área de Destino'
        },
        {
            'nombre': 'acuerdos',
            'texto' : 'Acuerdos'
        }
    ];

    try {
        // Validar valores
        inputs.forEach( function(input, index) {
            let valor           = $(`#${input.nombre}`).val();
            datos[input.nombre] = valor;
            if (  valor == '' ){
                if ( input.nombre == 'acuerdo_id' )
                    errores += 'No se recibió el número de acuerdo, por favor recargue la página';
                else
                    errores += `El campo <a href="#${input.nombre}">${input.texto}</a> es requerido.`;
            }
        });

        if ( ! errores ){
            respuesta   = fu_json_query(
                url('Acuerdos/registrar_seguimiento', true, false),
                datos 
            );
            if ( respuesta.exito ){
                if ( respuesta.acuerdo_id ) $('#acuerdo_id').val(respuesta.acuerdo_id);
                if ( respuesta.seguimiento_id ) $('#seguimiento_id').val(respuesta.seguimiento_id);
                
                fu_notificacion('Se ha registrado el acuerdo exitosamente.', 'success');
                if ( carga_doctos ){
                    $('#guardar').prop({disabled: true});
                    var documentos = Dropzone.forElement("div#cargar_documento");
                    if ( documentos.processQueue() ) {
                        setTimeout(function() {
                            window.location.replace( url('Acuerdos') ); 
                        }, 3000);
                    }
                } else{
                    $('#guardar').prop({disabled: true});
                    window.location.replace( url('Acuerdos') ); 
                }
            } else
                fu_notificacion(respuesta.mensaje, 'danger');
        } else {
            fu_alerta(errores, 'danger');
            fu_notificacion('Existen campos pendientes por llenar.', 'success');    
        }
    } catch(e) {
        fu_alerta('Ha ocurrido un error al guardar el acuerdo, intentelo más tarde.', 'danger');
    }

    $('#guardar').prop({disabled: false});
    $('#guardar').html(`Guardar`);
}