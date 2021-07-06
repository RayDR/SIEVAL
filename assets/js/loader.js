$(document).ready(function() {
   if ( jQuery.active ) {
      $( document ).ajaxComplete(function( event, request, settings ) {
         loader(false);
      });
   } else {
      loader(false);
   }
});