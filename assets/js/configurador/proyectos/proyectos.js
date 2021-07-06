var dt, 
    dtNombre     = '#dtProyectos', 
    dtAjaxUrl    = 'Configurador/datatable_proyectos';

$(document).ready(function($) {
	finicia_datatable();
    loader(false);
    activar_menu_desplegable();
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
            { data: 'proyecto_actividad_id' },
            { data: 'cve_programa' },
            { data: 'linea_accion' },
            { data: 'estrategia_programa' },
            { data: 'objetivo_programa' },
            { data: 'fuente_financiamiento' },
            { data: 'fecha_creacion' },
            { data: 'ejercicio' },
            { 
                data: null,
                render: function(data){
                    return `${data.usuario_registro_nombres} ${data.usuario_registro_primer_apellido} ${data.usuario_registro_segundo_apellido}`;
                }
            },
            { data: 'estatus' },
        ],
        drawCallback: function (settings) {
            $('[data-toggle="tooltip"]').tooltip({ boundary: 'window' });
        },
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        }
    });
}