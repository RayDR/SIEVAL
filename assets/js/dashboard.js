$(document).ready(function($) {
	loader(false);
	$('#filtro-area').change(freload_stadistics);
});

function fnueva_actividad(){
	loader();
	setTimeout(function() {
		var vista = fu_muestra_vista(url('Actividades/registrar'));
		$('#ajax-html').html(vista);
		loader(false);
	}, 10);
}

function fnuevo_acuerdo(){
	loader();
	setTimeout(function() {
		var vista = fu_muestra_vista(url('Acuerdos/registrar'));
		$('#ajax-html').html(vista);
		loader(false);
	}, 10);
}

function freload_stadistics(){
	$.post(url('Home/estadisticas'), {filtro: $(this).val()}, function(data, textStatus, xhr) {
	  loader();
	}).then(function(data){
		return JSON.parse(data);
	}).then(function(data){
		if ( data.exito ){
			if ( data.estadisticas ){
				data.estadisticas.forEach( function(estadistica, index) {
					if ( estadisticas.totales ){
						estadisticas.totales.forEach( function(totales, index) {
							$(`#${totales.id}`).val(totales.total);
						});
					}
				});
			}
		} else 
			fu_notificacion((data.error)? data.error: (data.mensaje)? data.mensaje : 'No hay estadísticas para mostrar', 'danger');
	}).catch(function(e){
		fu_notificacion('No se pudo cargar las estadísticas.', 'danger');
	});
	
}