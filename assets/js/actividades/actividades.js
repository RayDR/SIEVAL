// Variables globales
var dt, 
    dtNombre     = '#dtActividades', 
    dtAjaxUrl    = 'Actividades/datatable_actividades',
    vRegistro    = 'Actividades/registrar',
    vSeguimiento = 'Actividades/seguimiento';

$(document).off('click.detalle', 'tbody tr')
           .on('click.detalle' , 'tbody tr', fmostrar_detalle);
$(document).ready(function() {
    $('#nueva_actividad').click( fnueva_actividad );
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
                { data: 'actividad_id' },
                { data: 'actividad_general' },
                { data: 'programado_fisico' },
                { data: 'realizado_fisico' },
                {
                    data: null,
                    render: function(data){
                        var progreso = 0,
                            color    = 'dark',
                            html     = '';
                        if ( data.realizado_fisico ){
                            progreso = data.realizado_fisico / data.programado_fisico * 100;
                        }
                        html  = `
                            <div class="progress-wrapper">
                                <div class="progress-info">
                                    <div class="progress-label">
                                        <span class="text-${color}">Progreso físico</span>
                                    </div>
                                    <div class="progress-percentage">
                                        <span>${progreso.toFixed(2)}%</span>
                                    </div>
                                </div>
                                <div class="progress progress-xl">
                                    <div class="progress-bar bg-${color}" role="progressbar" style="width: ${progreso.toFixed(2)}%;" 
                                         aria-valuenow="${progreso.toFixed(2)}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        `;
                        return html;
                    }
                },
                { data: 'programado_financiero' },
                { data: 'realizado_financiero' },
                {
                    data: null,
                    render: function(data){
                        var progreso = 0,
                            color    = 'dark',
                            html     = '';
                        if ( data.realizado_financiero ){
                            progreso = data.realizado_financiero / data.programado_financiero * 100;
                        }
                        html  = `
                            <div class="progress-wrapper">
                                <div class="progress-info">
                                    <div class="progress-label">
                                        <span class="text-${color}">Progreso financiero</span>
                                    </div>
                                    <div class="progress-percentage">
                                        <span>${progreso.toFixed(2)}%</span>
                                    </div>
                                </div>
                                <div class="progress progress-xl">
                                    <div class="progress-bar bg-${color}" role="progressbar" style="width: ${progreso.toFixed(2)}%;" 
                                         aria-valuenow="${progreso.toFixed(2)}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        `;
                        return html;
                    }
                },
                { data: 'beneficiados' },
                { data: 'cantidad_beneficiario' },
                { data: 'unidad_medida' },
                { data: 'linea_accion' },
                { data: 'objetivo_programa' },
                { data: 'estrategia_programa' }
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

function fnueva_actividad(e){
    if ( e == null || e == undefined )
        return;
    var vista = fu_muestra_vista('Actividades/registrar');
    if ( vista )
        $('#ajax-html').html(vista);
}

function fmostrar_detalle(){
    fu_modal();
    var actividad = dt.row($(this).closest('tr')).data();
    var html = fu_muestra_vista(url('Actividades/detalles_actividad'), { actividad_id: actividad.actividad_id });
    setTimeout(function() {
        if ( html ){
            fu_modal('Detalle de Actividad', html );
        } else 
            fu_modal('404');
    }, 10);
}

function frecargar(){
    setTimeout(function() {
        window.location.replace( url('Actividades') ); 
    }, 1000);
}