var dt, 
    dtNombre     = '#dtFirmantes', 
    dtAjaxUrl    = 'Configurador/datatable_firmantes';

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
            { data: 'usuario_id' },
            { data: 'usuario' },
            { data: 'nombre_completo' },
            { data: 'direccion' },
            { data: 'subdireccion' },
            { data: 'departamento' },
            { data: 'area' }
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
            $.post(url('Configurador/modal/firmantes', true, false), {firmante_id: dtData.firmante_id}).then(function(data){
                return JSON.parse(data);
            }).then(function(data){
                if ( data.exito ){
                    fu_modal(`<span class="text-white">Firmante: <b>${dtData.usuario}</b></span>`, data.html);
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
    $.get(url('Configurador/get_areas_select2')).then(function(data){
        return JSON.parse(data);
    }).then(function(data){
        if ( data.exito ){
            $('.areas_select2').select2({
                data: data.result,
                pagination: {
                    'more': true
                }
            });
        } else{
            fu_notificacion((data.error)? data.error: 'No se pudo obtener el resultado.', 'danger');
        }
    }).catch(function(error){
        fu_notificacion('Falló al obtener respuesta del servidor.<br>'+ error.message, 'danger');
    });

    $.get(url('Configurador/get_usuarios_select2')).then(function(data){
        return JSON.parse(data);
    }).then(function(data){
        if ( data.exito ){
            $('.usuarios_select2').select2({
                data: data.result,
                pagination: {
                    'more': true
                }
            });
        } else{
            fu_notificacion((data.error)? data.error: 'No se pudo obtener el resultado.', 'danger');
        }
    }).catch(function(error){
        fu_notificacion('Falló al obtener respuesta del servidor.<br>'+ error.message, 'danger');
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