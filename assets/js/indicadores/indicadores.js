// Variables globales
var dt, 
    dtNombre     = '#dtIndicadores', 
    dtAjaxUrl    = 'Indicadores/datatable_indicadores',
    vRegistro    = 'Indicadores/registrar',
    vAsignacion  = 'Indicadores/asignacion';

$(document).off('click.detalle', 'tbody tr')
           .on('click.detalle' , 'tbody tr', fi_detalle);
$(document).ready(function() {
    $('#nuevo_indicador').click( fi_registrar );
    fCargar_DataTable();
});

function fCargar_DataTable(){
    if ( $.fn.dataTable.isDataTable( dtNombre ) ) 
        dt = $(dtNombre).DataTable();
    else {
        dt = $(dtNombre).DataTable({
            bStateSave: true,
            sPaginationType: "full_numbers",
            scrollX: true,
            scrollCollapse: true,
            dom: '<"row text-center mb-3"<"col-12"B>><"row d-flex justify-content-between"<"col-6"l><"col-6"f>>t<"mb-3"i>p',
            buttons: [
                {
                    text: 'Actualizar',
                    action: function (e, dt, node, config) {                    
                        $(this).prop({ disabled: true });
                        factualiza_datatable();
                        $(this).prop({ disabled: false });
                    }
                },
                { 
                    extend : 'excel',
                    text   : 'Exportar' 
                },
                {
                    extend: 'colvis',
                    text: 'Columnas',
                    columns: ':gt(0)',
                }
            ],
            ajax: {
                url: url(dtAjaxUrl, true, false),
                type: "POST",
                dataSrc: ''
            },
            columns: [
                { data: 'indicadores_ejercicio_id' },
                { data: 'indicador_nombre' },
                { data: 'descripcion' },
                { data: 'definicion' },
                { data: 'proposito' },
                { data: 'nivel_id' },
                { data: 'formula' },
                { data: 'metodo_calculo' },
                { data: 'tipo_medicion_frecuencia' },
                { data: 'ejercicio' }
            ],
            drawCallback: function (settings) {
                $('[data-toggle="tooltip"]').tooltip({ boundary: 'window' });
            },
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
            }
        });
    }
}


function fi_registrar(){
   loader();
   setTimeout(function() {
      $.get(url(vRegistro)).then(function(data){
         return JSON.parse(data);
      }).then(function(data){
         if ( data.exito ){
            $('#ajax-html').html(data.html);
         } else
            fu_notificacion((data.error)? data.error : 'No se pudo cargar la opción solicitada', 'danger'); 
      }).catch(function(error){
         fu_notificacion('Ha ocurrido un error al cargar la solicitud. <br>' + error);
      });
   }, 100);
}

function fi_detalle(){

}