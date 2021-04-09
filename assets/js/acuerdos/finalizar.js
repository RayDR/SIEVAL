$(document).ready(function() {
    $('#guardar').click(fguardar);
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
            'nombre': 'destino'
        },
        {
            'nombre': 'acuerdos',
            'texto' : 'Resumen'
        }
    ];

    try {
        // Validar valores
        inputs.forEach( function(input, index) {
            let valor           = $(`#${input.nombre}`).val();
            datos[input.nombre] = valor;

            if (  valor == '' )
                errores += `El campo <a href="#${input.nombre}">${input.texto}</a> es requerido.`;
        });

        if ( ! errores ){
            respuesta   = fu_json_query(
                url('Acuerdos/finalizar_acuerdo', true, false),
                datos 
            );
            if ( respuesta.exito ){
                if ( respuesta.acuerdo_id ) $('#acuerdo_id').val(respuesta.acuerdo_id);
                if ( respuesta.seguimiento_id ) $('#seguimiento_id').val(respuesta.seguimiento_id);
                
                fu_notificacion('Acuerdo Finalizado.', 'primary');
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
        fu_alerta('Ha ocurrido un error al actualizar el estatus del acuerdo, intentelo más tarde.', 'danger');
    }
    
    $('#guardar').prop({disabled: false});
    $('#guardar').html(`Guardar`);
}