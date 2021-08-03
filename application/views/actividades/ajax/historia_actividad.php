<style type="text/css" media="screen">
    #encabezado.accordion-button{
        color: dark !important;
    }
    #encabezado.accordion-button:hover{
        color: #29313d !important;
    }
</style>
<div class="accordion my-3 w-100" id="encabezado">
    <div class="accordion-item">
        <h2 class="accordion-header" id="titulo_actividad">
            <button class="accordion-button collapsed text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#datos_actividad" aria-expanded="false" aria-controls="datos_actividad">
                <strong>ACTIVIDAD GENERAL:</strong>&nbsp;<?= $encabezado->actividad_general ?>
            </button>
        </h2>
        <div id="datos_actividad" class="accordion-collapse collapse" aria-labelledby="titulo_actividad" data-bs-parent="#encabezado">
            <div class="accordion-body">                                
                <div class="card card-body shadow-sm bg-transparent border-gray-300 p-0 p-md-4">
                    <div class="card-body px-0 py-0">
                        <ul class="list-group bg-transparent">
                            <li class="list-group-item border-bottom bg-transparent">
                                <p><strong>ESTRATEGIA:</strong><br><?= $encabezado->estrategia_programa ?></p>
                            </li>
                            <li class="list-group-item border-bottom bg-transparent">
                                <p><strong>OBJETIVO:</strong><br><?= $encabezado->objetivo_programa ?></p>
                            </li>
                            <li class="list-group-item bg-transparent">
                                <p><strong>LÍNEA DE ACCIÓN:</strong><br><?= $encabezado->linea_accion ?></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>