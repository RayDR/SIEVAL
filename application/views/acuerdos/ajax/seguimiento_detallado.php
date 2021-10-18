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
<div class="container">
    <div class="text-white">
    <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-transparent">
        <h2 class="h5 mb-4">Datos del Acuerdo #<?= $acuerdo[0]->acuerdo_id ?></h2>
        <input type="hidden" value="<?= $seguimiento[0]->acuerdo_id ?>" id="acuerdo" name="acuerdo">
        <input type="hidden" value="<?= $seguimiento[0]->seguimiento_acuerdo_id ?>" id="seguimiento" name="seguimiento">
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex align-items-center justify-content-between px-0  bg-transparent">
                <div>
                    <p class="p-0 m-0"><b>Asunto:</b> <?= $acuerdo[0]->asunto ?></p>
                    <p class="p-0 m-0"><b>Tema:</b> <?= $acuerdo[0]->tema ?></p>
                    <p class="p-0 m-0"><b>Solicitante:</b> <?= $seguimiento[0]->usuario_registra ?></p>
                    <p class="p-0 m-0">
                        <b>
                        <?php if ( $seguimiento[0]->estatus_acuerdo_id == 3 ): ?>
                            Fecha de respuesta:
                        <?php else: ?>
                            Fecha de probable respuesta:
                        <?php endif ?>
                        </b>
                    <?PHP 
                        $fecha_probable = strtotime($acuerdo[0]->fecha_creacion_acuerdo . " + {$acuerdo[0]->fecha_respuesta} days");
                        if ( $seguimiento[0]->estatus_acuerdo_id == 3 )
                            echo mdate('%d/%m/%Y', strtotime($seguimiento[0]->fecha_creacion_acuerdo));
                        else if ( time() > $fecha_probable ) 
                            echo mdate('%d/%m/%Y', time());
                        else
                            echo mdate('%d/%m/%Y', $fecha_probable);
                    ?>
                    </p>
                </div>              
                <div class="text-right text-white">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center justify-content-end px-0 bg-transparent">
                            <div class="nav-wrapper">
                                <ul class="nav nav-pills nav-pill-circle flex-column flex-md-row">
                                    <?php 
                                    if ( $seguimiento[0]->estatus_acuerdo_id != 3 ): 
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link editar-acuerdo" data-acuerdo="<?= $acuerdo[0]->acuerdo_id ?>" aria-label="Tab Editar" href="#editar-acuerdo" data-bs-toggle="tooltip" title="Editar Preproyecto">
                                            <span class="nav-link-icon d-block"><span class="fas fa-pencil-alt fa-2x"></span></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link nuevo-seguimiento" data-acuerdo="<?= $acuerdo[0]->acuerdo_id ?>" aria-label="Tab Seguimiento" href="#contestacion" data-bs-toggle="tooltip" title="Nueva Actividad">
                                            <span class="nav-link-icon d-block"><span class="fas fa-file-contract fa-2x"></span></span>
                                        </a>
                                    </li>
                                    <?php endif ?>
                                    <li class="nav-item">
                                        <a class="nav-link seguimiento-finalizar" data-acuerdo="<?= $acuerdo[0]->acuerdo_id ?>" aria-label="Tab Documentación" href="#<?= base_url('index.php/Acuerdos/descargar_zip/' . $acuerdo[0]->acuerdo_id) ?>" data-bs-toggle="tooltip" title="Descargar Documentación">
                                            <span class="nav-link-icon d-block"><span class="fas fa-cloud-download-alt fa-2x"></span></span>
                                        </a>
                                    </li>
                                    <?php 
                                    if ( 
                                        $seguimiento[0]->estatus_acuerdo_id != 3 && 
                                        (
                                            ( $this->session->userdata('tuser') == 1 ) // Solo administradores
                                            ||
                                            ( $combinacion->subdireccion_id   == 1 && 
                                              $combinacion->departamento_id   == 1 && 
                                              $combinacion->area_id           == 1  ) // Solo directores
                                        )
                                    ): 
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link seguimiento-finalizar" data-acuerdo="<?= $acuerdo[0]->acuerdo_id ?>" aria-label="Tab Finalizar" href="#finalizar" data-bs-toggle="tooltip" title="Nueva Actividad">
                                            <span class="nav-link-icon d-block"><span class="fas fa-check fa-2x"></span></span>
                                        </a>
                                    </li>
                                    <?php endif ?>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <span class="badge badge-lg bg-secondary text-dark"><?= $seguimiento[0]->estatus_seguimiento ?></span>
                    <br>
                </div>
            </li>
        </ul>
    </div>

    <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-white">
        <h2 class="h5 mb-4 text-primary">
            Historial del Acuerdo 
            <a href="<?= base_url('index.php/Acuerdos/descargar_zip/' . $acuerdo[0]->acuerdo_id) ?>" title="Descargar archivos adjuntos" data-title="Descargar archivos adjuntos" data-toggle="tooltip">
                <i class="fas fa-cloud-download-alt text-primary"></i>
            </a>
        </h2>
        <div id="historial" class="container" style="max-height: 500px; overflow-y: scroll;">
            <?php $this->load->view('acuerdos/ajax/historial_seguimiento', ['historial' => $seguimiento]); ?>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/acuerdos/ajax/seguimiento_detallado.js') ?>" type="text/javascript" charset="utf-8"></script>