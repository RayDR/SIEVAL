$(document).ready(function($) {
   finicia_select2();
   
   $('#guardar').click(fcu_guardar);
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

function fcu_guardar(e){
   if ( inputs ){
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
            if( (valor == '' || valor == null || valor == undefined) && $(`#${input.nombre}`).prop('required') )
                errores += `El campo <a href="#${input.nombre}">${input.texto}</a> es requerido.<br>`;            
         });
         if ( ! errores ){
            respuesta = $.post( url('Configurador/registra_usuario'), datos, function(data, textStatus, xhr) {
               loader();
            }).then(function(data){
               return JSON.parse(data);
            }).then(function(data){
               if ( data.exito ){
                  fu_notificacion('Se ha registrado el proyecto exitosamente.', 'success');
                  window.location.replace( url('Configurador/usuarios') );
               } else
                  fu_notificacion((data.error)? data.error: 'Operación fallida.', 'danger');
               loader(false);
            }).catch(function(error){
               loader(false);
               fu_notificacion('No se pudo obtener respueta del servidor. Por favor comuniquelo al administrador.<br>' + `<b>${error}</b>`, 'danger');
            });
         } else {
            fu_alerta(errores, 'danger');
            fu_notificacion('Existen campos pendientes por llenar.', 'danger');    
        }
      } catch(e) {
        fu_alerta('Ha ocurrido un error al guardar el proyecto, intentelo más tarde.', 'danger');
      }

      $('#guardar').prop({disabled: false});
      $('#guardar').html(`Guardar`);
   } else {
      fu_notificacion('No se han recibido correctamente los campos a guardar', 'danger');
   }
}