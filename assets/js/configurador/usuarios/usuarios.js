var dt, 
    dtNombre     = '#dtUsuarios', 
    dtAjaxUrl    = 'Configurador/datatable_usuarios';

$(document).ready(function($) {
	finicia_datatable();
    loader(false);

    $(`${dtNombre} tbody`).on('click', 'tr td', fcModal); 
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
            { 
            	data: null,
            	render: function(data){
            		return `${data.nombres} ${data.primer_apellido} ${data.segundo_apellido}`;
            	} 
            },
            { 
            	data: null,
            	render: function(data){
            		return `${data.direccion} ${data.subdireccion} ${data.departamento} ${data.area}`;
            	} 
            },
            { 
            	data: null,
            	render: function(data){
            		estatus = ( data.estatus == 1 )? 'ACTIVO': 'INACTIVO';
            		return `${estatus}`;
            	} 
            },
        ],
        drawCallback: function (settings) {
            $('[data-toggle="tooltip"]').tooltip({ boundary: 'window' });
        },
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        }
    });
}

function fcModal(){
    
}