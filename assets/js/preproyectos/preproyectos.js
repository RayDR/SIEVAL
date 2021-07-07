// Variables globales
var dt, 
    dtNombre     = '#dtPreproyectos', 
    dtAjaxUrl    = 'Preproyectos/datatable_preproyectos'
    vRegistro    = 'Preproyectos/registrar',
    vSeguimiento = 'Preproyectos/seguimiento';

$(document).off('click.detalle', `${dtNombre} tbody tr`)
           .on('click.detalle' , `${dtNombre} tbody tr`, fmostrar_detalle);
$(document).ready(function() {
    $('#nuevo_preproyecto').click( fnuevo_preproyecto );
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
                { data: 'preproyecto_id' },
                { data: 'actividad' },
                { data: 'linea_accion' },
                { data: 'objetivo' },
                { data: 'estrategia' },
                { data: 'ejercicio' },
                { data: 'estatus' }
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

function factualiza_datatable(mensaje = '', tipo = ''){
    if ( $.fn.dataTable.isDataTable(dtNombre) ) {        
        dt.ajax.reload(null, false);
        mensaje = ( mensaje == '' )? 'Tabla actualizada.': mensaje;
        tipo    = ( tipo == '' )? 'info' : tipo;
        fu_notificacion(mensaje, tipo);
    }
}

function fnuevo_preproyecto(e){
    if ( e == null || e == undefined )
        return;
    var vista = fu_muestra_vista('Preproyectos/registrar');
    if ( vista )
        $('#ajax-html').html(vista);
}

function fmostrar_detalle(){
    fu_modal();
    var preproyecto = dt.row($(this).closest('tr')).data();
    var html = fu_muestra_vista(url('Preproyectos/detalles_preproyecto'), { preproyecto_id: preproyecto.preproyecto_id });
    setTimeout(function() {
        if ( html ){
            fu_modal('Detalle de Preproyecto', html );
        } else 
            fu_modal('404');
    }, 10);
}

function frecargar(){
    setTimeout(function() {
        window.location.replace( url('Preproyectos') ); 
    }, 1000);
}

function fcalcula_trimestre(){
    var hoy = new Date(),
        mes = hoy.getMonth() + 1,
        trimestre;
    if ( mes < 4 )
        trimestre = 1;
    else if ( mes < 7 )
        trimestre = 2;
    else if ( mes < 10 )
        trimestre = 3;
    else
        trimestre = 4;
    $('#trimestre').val(trimestre).trigger('change');
}

function fset_trimestre(){
    var trimestre = $(this).val(),
        fechas    = fu_valida_trimestre(trimestre);

    if ( fechas ){
        if ( fechas.inicio )
            $('#fecha_inicio').val(`${fechas.inicio.getFullYear()}-${('0' + (fechas.inicio.getMonth() + 1)).slice(-2)}-${('0' + fechas.inicio.getDate()).slice(-2)}`);
        if ( fechas.termino )
            $('#fecha_termino').val(`${fechas.termino.getFullYear()}-${('0' + (fechas.termino.getMonth() + 1)).slice(-2)}-${('0' + fechas.termino.getDate()).slice(-2)}`);
    } else {
        fcalcula_trimestre();
        fu_notificacion('No se pudo calcular el trimestre.', 'warning');
    }
}

function fset_url(){
    var url = $(this).val();
    if ( url ){
        if ( ! fu_valida_url(url) ) 
            fu_notificacion('La URL no tiene el formato correcto.<br><b>Nota incluir http/https</b>', 'warning');
    } else 
        $('#url').val('');
}