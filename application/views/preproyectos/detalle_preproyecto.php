<style type="text/css" media="screen">
    .nav-link:hover, .nav-link:focus {
        background-color: #D1D5DB;
    } 
    .nav-pills .nav-link:hover{
        background-color: #D1D5DB;
    }
    .accordion-button{
        color: white;
    }
    .accordion-button:hover{
        color: #262B40;
    }
</style>
<!-- Detalle Preproyecto -->
<input type="hidden" id="preproyecto_id" name="preproyecto_id" value="<?= $preproyecto->preproyecto_id ?>">
<div class="container">
    <div class="text-white">
    <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-transparent">
        <!-- Botonera -->
        <div class="row d-flex justify-content-between">
            <div class="col-lg-6 my-auto">
                <h2 class="h5 mb-4 text-center">DETALLE DE PREPROYECTO</h2>
                <hr class="ml-3">
            </div>
            <div class="col">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-inline-flex align-items-center justify-content-end px-0 bg-transparent">
                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-pill-circle flex-row">
                                <li class="nav-item">
                                    <a id="editar" class="nav-link" aria-label="Tab Editar" href="#editar-preproyecto" data-bs-toggle="tooltip" title="Editar Preproyecto">
                                        <span class="nav-link-icon d-block"><span class="fas fa-pencil-alt fa-2x"></span></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="actividad" class="nav-link" aria-label="Tab Reporte" href="#actividad-preproyecto" data-bs-toggle="tooltip" title="Nueva Actividad">
                                        <span class="nav-link-icon d-block"><span class="fas fa-file-contract fa-2x"></span></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="concluido" class="nav-link disabled" disabled aria-label="Tab Concluído" href="#concluido-preproyecto" data-bs-toggle="tooltip" title="Concluído Preproyecto">
                                        <span class="nav-link-icon d-block"><span class="fas fa-check fa-2x"></span></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="cancelar" class="nav-link disabled" disabled aria-label="Tab Cancelar" href="#cancelar-preproyecto" data-bs-toggle="tooltip" title="Cancelar Preproyecto">
                                        <span class="nav-link-icon d-block"><span class="fas fa-ban fa-2x"></span></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Fin de Botonera -->

        <!-- Desplegable de Detalle del Preproyecto -->
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex align-items-center justify-content-center px-0 bg-transparent">
                <div class="accordion my-3 w-100" id="preproyecto">
                    <div class="accordion-item">
                        <h2 class="accordion-header text-wrap" id="titulo_preproyecto">
                            <button class="accordion-button collapsed text-wrap" type="button" data-bs-toggle="collapse" data-bs-target="#encabezado-preproyecto" aria-expanded="false" aria-controls="encabezado-preproyecto">
                                <strong>PREPROYECTO: </strong>&nbsp;<?= $preproyecto->actividad ?>
                            </button>
                        </h2>
                        <div id="encabezado-preproyecto" class="accordion-collapse collapse" aria-labelledby="titulo_preproyecto" data-bs-parent="#preproyecto">
                            <div class="accordion-body">
                                <ul class="list-group bg-transparent">
                                    <li class="list-group-item border-bottom bg-transparent">
                                        <p><strong>ESTRATEGIA:</strong><br><?= $preproyecto->estrategia ?></p>
                                    </li>
                                    <li class="list-group-item border-bottom bg-transparent">
                                        <p><strong>OBJETIVO:</strong><br><?= $preproyecto->objetivo ?></p>
                                    </li>
                                    <li class="list-group-item bg-transparent">
                                        <p><strong>LÍNEA DE ACCIÓN:</strong><br><?= $preproyecto->linea_accion ?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="titulo_preproyecto">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#datos_preproyecto" aria-expanded="true" aria-controls="datos_preproyecto">
                                DETALLES
                            </button>
                        </h2>
                        <div id="datos_preproyecto" class="accordion-collapse collapse show" aria-labelledby="titulo_preproyecto" data-bs-parent="#preproyecto">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table w-100 bg-white">
                                        <tbody>
                                            <?php if( $preproyecto->seccion ): ?>
                                            <tr>
                                                <th>Sección</th>
                                                <td><?= $preproyecto->seccion ?></td>
                                            </tr>
                                            <?php endif ?>
                                            <?php if( $preproyecto->incluido ): ?>
                                            <tr>
                                                <th>Incluido</th>
                                                <td><?= ( $preproyecto->incluido == 1 )? 'Sí' : 'No' ?></td>
                                            </tr>
                                            <?php endif ?>
                                            <?php if( $preproyecto->url ): ?>
                                            <tr>
                                                <th>URL</th>
                                                <td><a href="<?= $preproyecto->url ?>" target="_blank" class="card-link text-primary"><?= $preproyecto->url ?></a></td>
                                            </tr>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <!-- Fin del desplegable de Detalle del Preproyecto -->

    <!-- Contenedor de Actividades de Preproyecto -->
    <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-white">
        <div class="container">
            <h3 class="card-title text-dark h5">ACTIVIDADES</h3>
            <?php if ( $actividades ): ?>
            <div class="row">
                <?php foreach ($actividades as $key => $actividad): ?>
                <div class="col-12 col-lg-6 mb-3 opcion-detalles" data-target="#actividad-detalle<?= $key ?>">
                    <div class="card border-rounded shadow p-3">
                        <div class="card-body text-dark">
                            <h2 class="h6 mb-0 text-dark"><strong class="h3 text-dark"><?= $key+1 ?>.</strong>&nbsp;<?= $actividad->actividad ?></h2>
                            <h3 class="fw-extrabold mb-2 text-dark">Inversión: <span class="dinero"><?= $actividad->inversion ?></span></h3>
                            <small class="text-dark">                                
                                <?= mdate('%d-%m-%Y', strtotime($actividad->fecha_inicio)) ?> -  <?= mdate('%d-%m-%Y', strtotime($actividad->fecha_termino)) ?>
                            </small> 
                            <div class="small d-flex mt-1 text-dark">
                                <div>Alcance: <?= ($actividad->ambito_localidad == 'E')? '' : $actividad->localidad .' - ' ?><b><?= $actividad->municipio ?></b></div>
                            </div>

                            <div class="row">
                                <input type="hidden" class=".actactividad_id" data-actividad="<?= $actividad->preproyecto_actividad_id ?>">
                                <div class="col-9">                                    
                                    <legend class="h6 text-dark mt-3">Mas detalles »</legend>
                                </div>
                                <div class="col mr-auto">
                                    <a class="btn btn-icon-only rounded-circle bg-dark text-white my-3 editar-actividad" data-actividad="<?= $actividad->preproyecto_actividad_id ?>" aria-label="Editar Actividad" href="#editar-actividad"><i class="fas fa-pencil-alt"></i></a>
                                </div>
                            </div>

                            <div id="actividad-detalle<?= $key ?>" style="display: none;">
                                <hr class="border-light">
                                <div>Grupo Beneficiado: <?= $actividad->cantidad_beneficiarios ?> (<?= $actividad->beneficiados ?>, <?= $actividad->beneficiados ?>)</div>
                                <div class="row">
                                    <div class="col-6"><?php if ( $actividad->seccion ): ?> Sección: <?= $actividad->seccion ?><?php endif ?></div>
                                    <div class="col-6">Incluido: <?= ( $actividad->incluido == 1 )? 'Sí' : 'No' ?></div>
                                </div>
                                
                                <?php if ( $actividad->url ): ?>
                                <div>URL: <a href="<?= $actividad->url ?>" target="_blank" class="card-link text-primary"><?= $actividad->url ?></a></div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
            <?php else: ?>
                <p class="lead my-3 text-dark">No se han registrado actividades.</p>
            <?php endif ?>
        </div>
    </div>
    <!-- Fin de Contenedor de Actividades de Preproyecto -->
</div>
<!-- Detalle de Preproyecto -->


<!-- Custom scripts - styles -->
<script type="text/javascript" charset="utf-8" async defer>
(function(){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    $('.dinero').each(function(index, input) {
        $(input).text( '$' + fu_formatNum($(input).text()) );
    });
})();
</script>

<script src="<?= base_url('assets/js/preproyectos/detalle_preproyecto.js') ?>" type="text/javascript" charset="utf-8"></script>