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

<input type="hidden" id="actividad_id" name="actividad_id" value="<?= $encabezado->actividad_id ?>">

<div class="container">
    <div class="text-white">
    <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-transparent">
        <div class="row d-flex justify-content-between">
            <div class="col my-auto">
                <h2 class="h5 mb-4 text-center">DETALLE DE ACTIVIDAD</h2>
                <br>
                <?= $encabezado->estatus_actividad ?>
            </div>
            <div class="col">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-center justify-content-end px-0 bg-transparent">
                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-pill-circle flex-column flex-md-row">
                                <li class="nav-item">
                                    <a id="editar" class="nav-link" aria-label="Tab Editar" href="#editar-actividad" data-bs-toggle="tooltip" title="Editar Actividad">
                                        <span class="nav-link-icon d-block">
                                            <span class="fas fa-pencil-alt fa-2x"></span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="reporte" class="nav-link" aria-label="Tab Reporte" href="#reporte-actividad" data-bs-toggle="tooltip" title="Reportar Actividad">
                                        <span class="nav-link-icon d-block">
                                            <span class="fas fa-file-contract fa-2x"></span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="imprimir" class="nav-link" aria-label="Tab Imprimir" href="<?= base_url('index.php/Actividades/generar_reporte/' . $encabezado->actividad_id) ?>" data-bs-toggle="tooltip" title="Imprimir" target="_blank">
                                        <span class="nav-link-icon d-block">
                                            <span class="fas fa-print fa-2x"></span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex align-items-center justify-content-center px-0 bg-transparent">
                <div class="accordion my-3 w-100" id="encabezado">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="titulo_actividad">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#datos_actividad" aria-expanded="false" aria-controls="datos_actividad">
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
            </li>
        </ul>
    </div>

    <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-white">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="h5 mb-0 text-primary">Reportes de Actividad</h3>
                        <li class="list-group-item d-flex align-items-center justify-content-center px-0 bg-transparent">
                            <div class="accordion my-3 w-100" id="reportes">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="encabezado-rfisico">
                                        <button class="accordion-button collapsed text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#reporte_fisico" aria-expanded="false" aria-controls="reporte_fisico">
                                            REPORTE FÍSICO - Programado:&nbsp;<b><?= $encabezado->programado_fisico ?></b>
                                        </button>
                                    </h2>
                                    <div id="reporte_fisico" class="accordion-collapse collapse" aria-labelledby="encabezado-rfisico" data-bs-parent="#reportes">
                                        <div class="accordion-body">
                                            <div class="card-body">
                                                <div class="row">
                                                <?php foreach ($detalles as $key => $detalle): ?>
                                                    <?php if( $detalle->programado_fisico != 0 || $detalle->realizado_fisico != 0  ): ?>
                                                        <?php if( $key == 6 ): ?>
                                                            </div> <!-- Fin de lista -->
                                                        </div> <!-- Fin de columna -->
                                                        <?php endif ?>    
                                                        <?php if( $key == 0 || $key == 6 ): ?>
                                                        <div class="col-md-6">
                                                            <div class="list-group list-group-flush list-group-timeline">
                                                        <?php endif ?>
                                                            <div class="list-group-item">
                                                                <?php 
                                                                    $reporteFisico      = '';
                                                                    $color = 'bg-dark';
                                                                    if ( !$detalle->realizado_fisico ){
                                                                        $reporteFisico = 'SIN REPORTE';
                                                                        $color = 'bg-dark';
                                                                    } else if ( $detalle->realizado_fisico == $detalle->programado_fisico ){
                                                                        $reporteFisico = 'OBJETIVO ALCANZADO';
                                                                        $color = 'bg-success';
                                                                    } else if ( $detalle->realizado_fisico > $detalle->programado_fisico ){
                                                                        $reporteFisico = 'OBJETIVO SUPERADO';
                                                                        $color = 'bg-success';
                                                                    } else if ( $detalle->realizado_fisico == 0 ){
                                                                        $reporteFisico = 'NO SE REALIZÓ NINGUNA ACTIVIDAD';
                                                                        $color = 'bg-warning';
                                                                    } else if ( $detalle->realizado_fisico < $detalle->programado_fisico ){
                                                                        $reporteFisico = 'NO SE ALCANZÓ EL OBJETIVO';
                                                                        $color = 'bg-warning';
                                                                    } else {
                                                                        $reporteFisico = 'SIN REPORTE';
                                                                        $color = 'bg-dark';
                                                                    }
                                                                ?>
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        <div class="icon icon-shape icon-sm <?= $color ?> text-white rounded-circle">
                                                                            <i class="far fa-calendar-check"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col ms-n2">
                                                                        <span class="badge <?= $color ?> py-1 mb-2">
                                                                            Reporte Mensual: 
                                                                            <b class="text-uppercase">
                                                                                <?= strftime( "%B", DateTime::createFromFormat('!m', $detalle->mes)->getTimestamp() ); ?>
                                                                            </b>
                                                                        </span>
                                                                        <p class="text-dark fw-bold mb-1">
                                                                            <?php if ( $detalle->realizado_fisico ): ?>
                                                                            Trabajo físico realizado: <?= $detalle->realizado_fisico ?>
                                                                            <?php endif ?>
                                                                            <span class="badge text-dark"><?= $reporteFisico ?></span>
                                                                        </p>
                                                                        <?php if ( $detalle->descripcion ): ?>
                                                                        <small class="text-primary">
                                                                            Detalle de actividad:
                                                                            <span contenteditable="true"><?= $detalle->descripcion ?></span>
                                                                        </small>
                                                                        <?php endif ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php endif ?>
                                                    <?php if( $key == count($detalles) - 1 ): ?>
                                                        </div> <!-- Fin de lista -->
                                                    </div> <!-- Fin de columna --> 
                                                    <!-- Fin general -->
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="encabezado-rfinanciero">
                                        <button class="accordion-button collapsed text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#reporte_financiero" aria-expanded="false" aria-controls="reporte_financiero">
                                            REPORTE FINANCIERO - Programado:&nbsp;<b><?= $encabezado->programado_financiero ?></b>
                                        </button>
                                    </h2>
                                    <div id="reporte_financiero" class="accordion-collapse collapse" aria-labelledby="encabezado-rfinanciero" data-bs-parent="#reportes">
                                        <div class="accordion-body">
                                            <div class="card-body">
                                                <div class="row">
                                                <?php foreach ($detalles as $key => $detalle): ?>
                                                    <?php if( $detalle->programado_fisico != 0 || $detalle->realizado_fisico != 0  ): ?>
                                                        <?php if( $key == 6 ): ?>
                                                            </div> <!-- Fin de lista -->
                                                        </div> <!-- Fin de columna -->
                                                        <?php endif ?>    
                                                        <?php if( $key == 0 || $key == 6 ): ?>
                                                        <div class="col-md-6">
                                                            <div class="list-group list-group-flush list-group-timeline">
                                                        <?php endif ?>
                                                                <div class="list-group-item">
                                                                    <?php 
                                                                        $reporteFinanciero  = '';
                                                                        $color = 'bg-dark';
                                                                        if ( !$detalle->realizado_financiero ){
                                                                            $reporteFinanciero = 'SIN REPORTE';
                                                                            $color = 'bg-dark';
                                                                        } else if ( $detalle->realizado_financiero == $detalle->programado_financiero ){
                                                                            $reporteFinanciero = 'OBJETIVO ALCANZADO';
                                                                            $color = 'bg-success';
                                                                        } else if ( $detalle->realizado_financiero > $detalle->programado_financiero ){
                                                                            $reporteFinanciero = 'OBJETIVO SUPERADO';
                                                                            $color = 'bg-success';
                                                                        } else if ( $detalle->realizado_financiero == 0 ){
                                                                            $reporteFinanciero = 'NO SE REALIZÓ NINGUNA ACTIVIDAD';
                                                                            $color = 'bg-warning';
                                                                        } else if ( $detalle->realizado_financiero < $detalle->programado_financiero ){
                                                                            $reporteFinanciero = 'NO SE ALCANZÓ EL OBJETIVO';
                                                                            $color = 'bg-warning';
                                                                        } else {
                                                                            $reporteFinanciero = 'SIN REPORTE';
                                                                            $color = 'bg-dark';
                                                                        }
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-auto">
                                                                            <div class="icon icon-shape icon-sm <?= $color ?> text-white rounded-circle">
                                                                                <i class="far fa-calendar-check"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col ms-n2">
                                                                            <span class="badge <?= $color ?> py-1 mb-2">
                                                                                Reporte Mensual: 
                                                                                <b class="text-uppercase">
                                                                                    <?= strftime( "%B", DateTime::createFromFormat('!m', $detalle->mes)->getTimestamp() ); ?>
                                                                                </b>
                                                                            </span>
                                                                            <p class="text-dark fw-bold mb-1">
                                                                                <?php if ( $detalle->realizado_financiero ): ?>
                                                                                Total financiero ocupado: <?= $detalle->realizado_financiero ?>
                                                                                <?php endif ?>
                                                                                <span class="badge text-dark"><?= $reporteFinanciero ?></span>
                                                                            </p>
                                                                            <?php if ( $detalle->descripcion ): ?>
                                                                            <small class="text-primary">
                                                                                Detalle de actividad:
                                                                                <span contenteditable="true"><?= $detalle->descripcion ?></span>
                                                                            </small>
                                                                            <?php endif ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                    <?php endif ?>
                                                    <?php if( $key == count($detalles) - 1 ): ?>
                                                        </div> <!-- Fin de lista -->
                                                    </div> <!-- Fin de columna --> 
                                                    <!-- Fin general -->
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf-8" async defer>
(function(){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
})();
</script>
<script src="<?= base_url('assets/js/actividades/detalle_actividad.js') ?>" type="text/javascript" charset="utf-8"></script>