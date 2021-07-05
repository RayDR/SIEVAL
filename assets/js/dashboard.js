$(document).ready(function($) {
	loader(false);
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