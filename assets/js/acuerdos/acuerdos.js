// Variables globales
var dt, 
    dtNombre        = '#dtAcuerdos', 
    dtAjaxUrl       = 'Acuerdos/datatable_acuerdos',
    vRegistro       = 'Acuerdos/registrar',
    vPlanificador   = 'Acuerdos/planificador',
    vEdicion        = 'Acuerdos/editar',
    vSeguimiento    = 'Acuerdos/seguimiento',
    vFinalizar      = 'Acuerdos/finalizar';

$(document).off('click','.seguimiento-detallado').on('click','.seguimiento-detallado', fseguimiento_detallado);
$(document).off('click','.nuevo-seguimiento').on('click','.nuevo-seguimiento', fnuevo_seguimiento);
$(document).off('click','.editar-acuerdo').on('click','.editar-acuerdo', feditar_acuerdo);
$(document).off('click','.seguimiento-finalizar').on('click','.seguimiento-finalizar', ffinalizar_acuerdo);
$(document).ready(function() {
    $('#nuevo_acuerdo').click(fmuestra_registro);
    $('#vista_calendario').click(fmuestra_planificador);

    finicia_datatable();

    //$(`${dtNombre} tbody`).on('click', 'tr td', fdetalle_acuerdo);
    $(`${dtNombre} tbody`).on('click', 'tr td', fmodal_seguimiento_acuerdo); // Simplificado
});

function finicia_datatable(){
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
            { data: 'acuerdo_id' },
            { data: 'asunto' },
            { data: 'tema' },
            { data: 'area_acuerdo' },
            { data: 'usuario_envia' },
            { data: 'area_seguimiento' },
            { data: 'usuario_recibe' },
            { data: 'folio' },
            { data: 'seguimiento' },
            { data: 'fecha_creacion_acuerdo' },
            { data: 'fecha_creacion_seguimiento' }
        ],
        drawCallback: function (settings) {
            $('[data-toggle="tooltip"]').tooltip({ boundary: 'window' });
        },
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        }
    });
}

function factualiza_datatable(mensaje = '', tipo = ''){
    if ( $.fn.dataTable.isDataTable(dtNombre) ) {        
        dt.ajax.reload(null, false);
        mensaje = ( mensaje == '' )? 'Tabla actualizada.': mensaje;
        tipo    = ( tipo == '' )? 'info' : tipo;
        fu_notificacion(mensaje, tipo);
    }
}

function fdetalle_acuerdo(){
    var tr   = $(this).closest('tr');
        row  = dt.row( tr );

    var data = dt.row( tr ).data();

    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown dt-detalles');
    } else {
        if ( data ){
            row.child( fseguimiento_acuerdo(data) ).show();
            tr.addClass('shown dt-detalles');
        }
    }
}

function fseguimiento_acuerdo(data){ 
   var contenido = $('<div/>')
        .addClass( 'cargando' )
        .text( 'Cargando...' );

   var html = fu_muestra_vista(url('Acuerdos/detalles_acuerdo'), {acuerdo: data.acuerdo_id} );
   return html;
}

function fmodal_seguimiento_acuerdo(){
    var tr   = $(this).closest('tr');
        row  = dt.row( tr ),
        data = dt.row( tr ).data(),
        html = fu_muestra_vista(url('Acuerdos/seguimiento_detallado'), {acuerdo: data.acuerdo_id});
    if ( html ){
        fu_modal('Seguimiento de Acuerdos', 
                html, 
                ``);
    } else 
        fu_modal('404');
}

function fmuestra_registro(e){
    if ( e == null || e == undefined )
        return;
    e.preventDefault();
    var vista = fu_muestra_vista( url(vRegistro, true, false) );
    if ( vista )
        $('#ajax-html').html(vista);
}


function fmuestra_planificador(e){
    if ( e == null || e == undefined )
        return;
    e.preventDefault();
    var vista = fu_muestra_vista( url(vPlanificador, true, false) );
    if ( vista )
        $('#ajax-html').html(vista);
}

function fseguimiento_detallado(){
    var acuerdo = $(this).data('acuerdo');
    var html    = fu_muestra_vista(url('Acuerdos/seguimiento_detallado'), {acuerdo: acuerdo});
    if ( html ){
        fu_modal('Seguimiento de Acuerdos', 
                html, 
                `<button data-acuerdo="${acuerdo}" 
                    type="button" class="btn btn-pill btn-outline-secondary nuevo-seguimiento" 
                    data-bs-dismiss="modal">Nuevo Seguimiento</button>
                 <button type="button" class="btn btn-pill btn-outline-danger" 
                    data-bs-dismiss="modal">Cerrar</button>`);
    } else 
        fu_modal('404');
}

function fnuevo_seguimiento(e){
    if ( e == null || e == undefined )
        return;
    e.preventDefault();
    var acuerdo     = $(this).data('acuerdo'),
        respuesta   = fu_json_query( url(`${vSeguimiento}/${acuerdo}`, true, false) );
    if ( respuesta ){
        if ( respuesta.exito ){
            fu_modal();
            $('#ajax-html').html(respuesta.html);
        }
        else
            fu_notificacion(respuesta.error, 'danger', 5000);
    }
}

function feditar_acuerdo(e){
    if ( e == null || e == undefined )
        return;
    e.preventDefault();
    var acuerdo     = $(this).data('acuerdo'),
        respuesta   = fu_json_query( url(`${vEdicion}/${acuerdo}`, true, false) );
    if ( respuesta ){
        if ( respuesta.exito ){
            fu_modal();
            $('#ajax-html').html(respuesta.html);
        }
        else
            fu_notificacion(respuesta.error, 'danger', 5000);
    }
}

function ffinalizar_acuerdo(e){
    if ( e == null || e == undefined )
        return;
    e.preventDefault();
    var acuerdo     = $(this).data('acuerdo'),
        respuesta   = fu_json_query( url(`${vFinalizar}/${acuerdo}`, true, false) );
    if ( respuesta ){
        if ( respuesta.exito ){
            fu_modal();
            $('#ajax-html').html(respuesta.html);
        }
        else
            fu_notificacion(respuesta.error, 'danger', 5000);
    }
}

function frecargar(){
    setTimeout(function() {
        window.location.replace( url('Acuerdos') ); 
    }, 1000);
}