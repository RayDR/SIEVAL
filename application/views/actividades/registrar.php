<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('index.php/Actividades') ?>">Actividades</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Registrar Actividad</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-light shadow-sm components-section">
            <div class="card-body">
                <div class="mb-3">
                    <?php $this->load->view(RUTA_TEMA_UTIL . '/alertas'); ?>
                </div>
                <form>
                    <!-- ORIGEN DEL PROYECTO -->
                    <div class="row">
                        <?php if( $this->session->userdata('tuser') == 1 ): ?>
                        <div class="col-12 mb-3">
                            <label class="my-1 me-2" for="area_origen">Áreas</label>
                            <select class="form-select areas_select2" id="area_origen" aria-label="Áreas">
                                <option selected disabled>Seleccione una opción</option>
                            </select>
                        </div>
                        <?php else: ?>
                            <input type="hidden" id="area_origen" name="area_origen" value="<?= $this->session->userdata('combinacion_area') ?>">
                        <?php endif ?>
                    </div>
                    <!-- ORIGEN DEL PROYECTO -->

                    <!-- ENCABEZADO DEL PROYECTO -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="my-1 me-2" for="programa_presupuestario">Programa Presupuestario</label>
                            <select class="form-select" id="programa_presupuestario" aria-label="Programas Presupuestarios" required>
                                <option selected disabled>Seleccione una opción</option>
                                <?php foreach ($programas as $key => $programa): ?>
                                <option value="<?= $programa->programa_presupuestario_id ?>" data-descripcion="<?= $programa->descripcion ?>" data-objetivo="<?= $programa->objetivo ?>">(<?= $programa->cve_programa ?>) <?= $programa->nombre ?></option>
                                <?php endforeach; ?>  
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="my-1 me-2" for="proyecto">Proyecto</label>
                            <select class="form-select" id="proyecto" aria-label="Programas Presupuestarios" required>
                                <option selected disabled>Seleccione una opción</option>
                                <?php foreach ($proyectos as $key => $proyecto): ?>
                                <option value="<?= $proyecto->proyecto_actividad_id ?>"><?= $proyecto->proyecto_nombre ?></option>
                                <?php endforeach; ?>  
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="my-1 me-2" for="linea_accion">Línea de Acción</label>
                            <select class="form-select" id="linea_accion" aria-label="Líneas de Acción" required>
                                <option selected disabled>Seleccione una opción</option>
                                <?php foreach ($l_accion as $key => $linea): ?>
                                <option value="<?= $linea->linea_accion_id ?>" data-objetivo="<?= $linea->objetivo_programa ?>" data-estrategia="<?= $linea->estrategia_programa ?>"><?= $linea->linea_accion ?></option>
                                <?php endforeach; ?>  
                            </select>
                        </div>
                        <div id="datos_linea_accion" class="col-12 mb-3"></div>
                        <div class="col-12 mb-3">
                            <label class="my-1 me-2" for="fuente_financiamiento">Fuente de Financiamiento</label>
                            <select class="form-select" id="fuente_financiamiento" aria-label="Fuente de Financiamiento" required>
                                <option selected disabled>Seleccione una opción</option>
                                <?php foreach ($f_financia as $key => $fuente): ?>
                                <option value="<?= $fuente->fuente_financiamiento_id ?>"><?= $fuente->descripcion ?></option>
                                <?php endforeach; ?>  
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div>
                                <label for="detalle_actividad">Detalle la Actividad</label>
                                <textarea class="form-control" placeholder="¿Que actividades se desempeñaran?" id="detalle_actividad" name="detalle_actividad" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- ENCABEZADO DEL PROYECTO -->

                    <!-- DATOS DE ACTIVIDAD -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="my-1 me-2" for="unidad_medida">Unidad de Análisis</label>
                            <select class="form-select" id="unidad_medida" aria-label="Unidades de Análisis">
                                <option selected disabled>Seleccione una opción</option>
                                <?php foreach ($u_medida as $key => $um): ?>
                                <option value="<?= $um->unidad_medida_id ?>"><?= $um->descripcion ?> (<?= $um->cve_medida ?>)</option>
                                <?php endforeach; ?>  
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="my-1 me-2" for="tipo_medicion">Tipo de Medición</label>
                            <select class="form-select" id="tipo_medicion" aria-label="Tipos de Medición">
                                <option selected disabled>Seleccione una opción</option>
                                <?php foreach ($mediciones as $key => $medicion): ?>
                                <option value="<?= $medicion->medicion_id ?>"><?= $medicion->descripcion ?></option>
                                <?php endforeach; ?>  
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="my-1 me-2" for="grupo_beneficiado">Grupo Beneficiado</label>
                            <select class="form-select" id="grupo_beneficiado" aria-label="Grupos Beneficiados">
                                <option selected disabled>Seleccione una opción</option>
                                <?php foreach ($g_benef as $key => $grupo): ?>
                                <option value="<?= $grupo->beneficiado_id ?>"><?= $grupo->descripcion ?></option>
                                <?php endforeach; ?>  
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cantidad_beneficiarios">Población Objetivo</label>
                            <input type="number" class="form-control" id="cantidad_beneficiarios" value="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="umbral">Umbrales</label>
                            <select class="form-select" id="umbral" aria-label="umbral">
                                <option selected disabled>Seleccione una opción</option>
                                <option value="A">Limite Aceptable 90% - 100%</option>
                            </select>
                            <small>Mostrar tabla de umbrales</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="indicador">Indicador</label>
                            <select class="form-select" id="indicador" aria-label="Indicadores" multiple>
                                <option selected disabled>Seleccione una opción</option>
                                <option value="0">Promedio diario de consultas por médico general y familiar</option>
                                <option value="1">Cobertura en atención de médicos generales y familiares en las unidades médicas de primer nivel</option>
                                <option value="2">Indicador de 5 puntos</option>
                            </select>
                        </div>
                    </div>
                    <!-- DATOS DE ACTIVIDAD -->

                    <!-- DETALLES DE ACTIVIDAD -->
                    <div id="programados" class="card card-body my-3 mx-2" style="display: none;">
                        <?php $this->load->view('actividades/secciones/programado_fisico'); ?>
                        <?php $this->load->view('actividades/secciones/programado_financiero'); ?>
                    </div>
                    <!-- DETALLES DE ACTIVIDAD -->

                    <div class="mt-3">
                        <button id="guardar" type="button" class="btn btn-dark">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var inputs = JSON.parse('<?php print(json_encode($inputs, JSON_HEX_TAG)); ?>');
</script>
<script src="<?= base_url('assets/js/actividades/registrar.js') ?>" type="text/javascript" charset="utf-8" async defer></script>