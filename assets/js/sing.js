$(document).ready(function($) {
    $('#do_login').click(flogin);
});

function flogin(e){
    e.preventDefault();
    var usuario     = $('#usuario').val(),
        password    = $('#password').val();

    let validacion  = fu_valida_password(usuario, password);

    if ( validacion.exito ){
        // Intercambio
        $('#guardar').html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="ms-1">Enviando...</span>`);
        fu_alerta('');
        loader();
        setTimeout(function() {
            var respuesta = fu_json_query( url('Home/do_login', true, false), {
                usuario: usuario,
                password: codifica_utf8(password)
            });
            if ( respuesta ){
                if ( respuesta.exito ){
                    fu_notificacion('Accediendo al sistema', 'success');
                    window.location.replace( url() );
                } else {
                    fu_notificacion(respuesta.mensaje, 'danger');
                }
            }
            loader(false);
        }, 10);
    } else {
        let mensaje  = '';
        validacion.forEach( function(val, index) {
            if ( ! val.resultado )
                mensaje += `${val.mensaje}<br>`;
        });
        fu_alerta(mensaje);
    }
}