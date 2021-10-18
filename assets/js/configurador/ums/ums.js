var dt, 
    dtNombre     = '#dtUms', 
    dtAjaxUrl    = 'Configurador/datatable_ums';

$(document).ready(function($) {
   
   finicia_datatable();
    loader(false);
    activar_menu_desplegable();

    $(`${dtNombre} tbody`).on('click', 'tr td', fcModalDetalles); 
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
            { data: 'unidad_medida_id' },
            { data: 'cve_medida' },
            { data: 'descripcion' }
        ],
        drawCallback: function (settings) {
            $('[data-toggle="tooltip"]').tooltip({ boundary: 'window' });
        },
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        }
    });
}

function fcModalDetalles(){
    var dtData = dt.row($(this).closest('tr')).data();
    if ( dtData ){
        setTimeout(function() {
            $.post(url('Configurador/modal/ums', true, false), {medida_id: dtData.unidad_medida_id}).then(function(data){
                return JSON.parse(data);
            }).then(function(data){
                console.log(data);
                if ( data.exito ){
                    fu_modal(`<span class="text-white">UM: <b>${dtData.cve_medida}</b></span>`, data.html);
                } else 
                    fu_notificacion((data.error)? data.error : 'Falló la operación','danger');
                loader(false);
            }).catch(function(error){
                loader(false);
                fu_notificacion('Falló al obtener la respuesta del servidor. Contacte al administrador.', 'danger');
            });
        }, 100);
    }
}

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

function factualiza_datatable(mensaje = '', tipo = ''){
    if ( $.fn.dataTable.isDataTable(dtNombre) ) {
        dt.ajax.reload(null, false);
        mensaje = ( mensaje == '' )? 'Tabla actualizada.': mensaje;
        tipo    = ( tipo == '' )? 'info' : tipo;
        fu_notificacion(mensaje, tipo);
    }
}