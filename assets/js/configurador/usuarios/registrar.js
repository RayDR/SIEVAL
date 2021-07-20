$(document).ready(function($) {
   $('#guardar').click(fcu_guardar);
});

function fcu_guardar(){
   if ( inputs ){
      inputs.forEach( function(input, index) {
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
               respuesta   = fu_json_query(
                  url('Configurador/registra_usuario', true, false),
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
      });
   } else {
      fu_notificacion('No se han recibido correctamente los campos a guardar', 'danger');
   }
}