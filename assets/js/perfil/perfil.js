$(document).ready(function() {
    $('#actualizar_perfil').click(factualizar_perfil);
    $('#cambiar_password').click(fcambiar_password);

    loader(false);
});

function factualizar_perfil(e){
    e.preventDefault();
    var inputs  = [
            {
                name : 'nombres',
                value   : $('#nombres').val()
            },
            {
                name : 'primer_apellido',
                value   : $('#primer_apellido').val()
            },
            {
                name : 'segundo_apellido',
                value   : $('#segundo_apellido').val()
            },
            {
                name : 'sexo',
                value   : $('#sexo').val()
            },
            // 'correo'            : $('#correo').val(),
            // 'telefono'          : $('#telefono').val()
        ],
        error  = false, // Variable de validación
        datos  = {};    // Almacenamiento de datos para enviar al servidor

    // Validaciones
    inputs.forEach( function(element, index) {
        if ( element.value == '' || element.value == undefined || element.value == null ){
            error = true;
            $(`#${element.name}`).removeClass('is-valid').addClass('is-invalid');
        } else {
            datos[element.name] = element.value;
            $(`#${element.name}`).removeClass('is-invalid').addClass('is-valid');
        }
    });

    if ( ! error ){ // Exitoso
        var respuesta = fu_json_query( url('Perfil/guardar_datos_perfil',true,false), {datos: datos} );
        if ( respuesta ){ // Valorar respuesta del servidor
            if ( respuesta.exito ){
                fu_notificacion('Datos actualizados', 'success');
                inputs.forEach( function(element, index) {
                    $(`#${element.name}`).removeClass('is-valid');
                });
            }
            else
                fu_notificacion(respuesta.error, 'danger');
        }
    } else
        fu_notificacion('Los campos marcados no pueden estar vaciós.', 'danger');
}

function fcambiar_password(e){
    e.preventDefault();
    var actual      = $('#password_actual').val(),
        nueva       = $('#password_nueva').val(),
        confirmar   = $('#password_confirmar').val(),
        inputs = [
            {
                name : 'password_nueva',
                value   : $('#password_nueva').val()
            },
            {
                name : 'password_actual',
                value   : $('#password_actual').val()
            },
        ],
        error = false;

    inputs.forEach( function(element, index) {
        if ( element.value == '' || element.value == undefined || element.value == null ){
            error = true;
            $(`#${element.name}`).removeClass('is-valid').addClass('is-invalid');
        } else {
            $(`#${element.name}`).removeClass('is-invalid').addClass('is-valid');
        }
    });
    
    if ( nueva != confirmar ){
        error = true;
        $('#password_confirmar').removeClass('is-valid').addClass('is-invalid');
        fu_notificacion('Las contraseñas no coinciden', 'danger');
    } else
        $('#password_confirmar').removeClass('is-invalid').addClass('is-valid');

    if ( !error ){
        var respuesta = fu_json_query( 
            url('Perfil/cambiar_password',true,false), 
            { 'actual': actual, 'nueva' :  nueva }
        );
        if ( respuesta ){
            if ( respuesta.exito ){
                fu_notificacion('Contraseña actualizada', 'success');
                $('#password_actual').val('').removeClass('is-valid').removeClass('is-invalid');
                $('#password_nueva').val('').removeClass('is-valid').removeClass('is-invalid');
                $('#password_confirmar').val('').removeClass('is-valid').removeClass('is-invalid');
            }
            else{
                fu_notificacion(respuesta.error, 'danger');
            }
        }
    } else
        fu_notificacion('Los campos marcados no pueden estar vaciós.', 'danger');
}