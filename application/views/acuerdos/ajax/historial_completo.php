<style type="text/css" media="screen">
    #encabezado.accordion-button{
        color: dark !important;
    }
    #encabezado.accordion-button:hover{
        color: #29313d !important;
    }
</style>
<!-- Ver Historial General -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="seguimientos">
            <button class="accordion-button collapsed text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#historial-seguimiento" aria-expanded="false" aria-controls="historial-seguimiento">
            Mostrar historial de seguimiento
            </button>
        </h2>
        <div id="historial-seguimiento" class="accordion-collapse collapse" aria-labelledby="seguimientos" data-bs-parent="#ver-historial">
            <div class="accordion-body">
            <?php $this->load->view('acuerdos/ajax/historial_seguimiento', ['historial' => $historial]); ?>
            </div>
        </div>
    </div>
    
    <div class="accordion-item">
        <h2 class="accordion-header" id="archivos">
            <button class="accordion-button collapsed text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#historial-archivos" aria-expanded="false" aria-controls="historial-archivos">
            Mostrar historial de archivos
            </button>
        </h2>
        <div id="historial-archivos" class="accordion-collapse collapse" aria-labelledby="archivos" data-bs-parent="#ver-historial">
            <div class="accordion-body">
            <?php $this->load->view('acuerdos/ajax/historial_archivos', ['acuerdo_id' => $historial[0]->acuerdo_id, 'archivos' => $archivos]); ?>
            </div>
        </div>
    </div>
<!-- FIN Historial General -->