function activar_menu_desplegable(){
    var opciones    = $('.sidebar-text'),
        desplegable;

    opciones.each(function(index, opcion) {
        if ( $(opcion).text() == 'Configurador' ){
            $(opcion).parents('.nav-item').addClass('active');
            $(opcion).trigger('click');
        }
    });
}