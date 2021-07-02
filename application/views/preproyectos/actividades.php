<input type="hidden" id="linea_accion"   name="linea_accion"   value="<?= $preproyecto->linea_accion_id ?>" required>
<input type="hidden" id="preproyecto"    name="preproyecto"    value="<?= $preproyecto->preproyecto_id ?>" required>

<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('index.php/Preproyectos') ?>">Preproyectos</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Actividades - Preproyecto</h1>
        </div>
    </div>    
    <div class="shadow rounded border-light p-3 w-100">
        <?php $this->load->view('preproyectos/ajax/historia_preproyecto', array('preproyecto' => $preproyecto, 'actividades' => $actividades), FALSE); ?>
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
                    <div class="row">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="my-1 me-2" for="municipio">Municipio</label>
                                <select class="form-select" id="municipio" aria-label="Municipios" required>
                                    <option selected disabled>Seleccione una opción</option>
                                    <?php foreach ($municipios as $key => $municipio): ?>
                                    <option value="<?= $municipio->municipio_id ?>"><?= $municipio->descripcion ?></option>
                                    <?php endforeach; ?>  
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="my-1 me-2" for="localidad">Localidad</label>
                                <select class="form-select" id="localidad" aria-label="Localidades" required>
                                    <option selected disabled>Seleccione un municipio primero</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="my-1 me-2" for="unidad_medida">Unidad de Medida</label>
                            <select class="form-select" id="unidad_medida" aria-label="Default select example">
                                <option selected disabled>Seleccione una opción</option>
                                <?php foreach ($u_medida as $key => $um): ?>
                                <option value="<?= $um->unidad_medida_id ?>"><?= $um->descripcion ?> (<?= $um->cve_medida ?>)</option>
                                <?php endforeach; ?>  
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="my-1 me-2" for="tipo_medicion">Tipo de Medición</label>
                            <select class="form-select" id="tipo_medicion" aria-label="Default select example">
                                <option selected disabled>Seleccione una opción</option>
                                <?php foreach ($mediciones as $key => $medicion): ?>
                                <option value="<?= $medicion->medicion_id ?>"><?= $medicion->descripcion ?></option>
                                <?php endforeach; ?>  
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="my-1 me-2" for="grupo_beneficiado">Grupo Beneficiado</label>
                            <select class="form-select" id="grupo_beneficiado" aria-label="Default select example">
                                <option selected disabled>Seleccione una opción</option>
                                <?php foreach ($g_benef as $key => $grupo): ?>
                                <option value="<?= $grupo->beneficiado_id ?>"><?= $grupo->descripcion ?></option>
                                <?php endforeach; ?> 
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cantidad_beneficiarios">Cantidad de Beneficiarios</label>
                            <input type="number" class="form-control" id="cantidad_beneficiarios" value="0" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="inversion">Inversión</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>                                
                                <input type="number" class="form-control" min="0" step="any" id="inversion" value="0" required>
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div>
                                <label for="detalle_preproyecto">Detalle de Actividad</label>
                                <textarea class="form-control" placeholder="¿Que actividades se desempeñaran para este preproyecto?" id="detalle_preproyecto" name="detalle_preproyecto" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="trimestre">Trimestre</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-day"></i>
                                </span>
                                <input class="form-control" id="trimestre" name="trimestre" type="number" min="1" max="4" step="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                                <input data-datepicker="" class="form-control" id="fecha_inicio" name="fecha_inicio" type="date" placeholder="dd/mm/yyyy" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_termino">Fecha de Término</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-check"></i>
                                </span>
                                <input data-datepicker="" class="form-control" id="fecha_termino" name="fecha_termino" type="date" placeholder="dd/mm/yyyy" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="seccion">Sección</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-hashtag"></i>
                                </span>
                                <input class="form-control" id="seccion" name="seccion" type="number" min="0">
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 m-md-auto">
                            <input class="form-check-input" type="checkbox" value="" id="incluido" name="incluido">
                            <label class="form-check-label" for="incluido">
                                Incluido
                            </label>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12 mb-3">
                            <label for="url">URL</label>
                            <input type="url" class="form-control" id="url" name="url" placeholder="https://ejemplo.com">
                        </div>  
                    </div>

                    <div class="mt-3">
                        <button id="guardar" type="button" class="btn btn-dark">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var inputs          = JSON.parse('<?php print(json_encode($inputs, JSON_HEX_TAG)); ?>'),
        lastMunicipio   = '<?= ($actividades)? $actividades[0]->municipio_id : 18 ?>',
        lastLocalidad   = '<?= ($actividades)? $actividades[0]->localidad_id : 2717 ?>';
</script>
<script src="<?= base_url('assets/js/preproyectos/actividades.js') ?>" type="text/javascript" charset="utf-8" async defer></script>