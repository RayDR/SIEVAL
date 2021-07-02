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
            <h1 class="h4">Editar Preproyecto</h1>
        </div>
    </div>
</div>
<input type="hidden" id="preproyecto" name="preproyecto" value="<?= $preproyecto->preproyecto_id ?>">
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
                                <label class="my-1 me-2" for="linea_accion">Línea de Acción</label>
                                <select class="form-select" id="linea_accion" aria-label="Líneas de Acción" required>
                                    <option selected disabled>Seleccione una opción</option>
                                    <?php foreach ($l_accion as $key => $linea): ?>
                                    <option value="<?= $linea->linea_accion_id ?>" data-objetivo="<?= $linea->objetivo_programa ?>" data-estrategia="<?= $linea->estrategia_programa ?>"><?= $linea->linea_accion ?></option>
                                    <?php endforeach; ?>  
                                </select>
                            </div>
                            <div id="datos_linea_accion" class="col-12"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <div>
                                <label for="detalle_preproyecto">Descripción/Propuesta</label>
                                <textarea class="form-control" placeholder="Descripción del preproyecto o propuesta." id="detalle_preproyecto" name="detalle_preproyecto" rows="4" required><?= $preproyecto->actividad ?></textarea>
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
                                <input class="form-control" id="seccion" name="seccion" type="number" value="<?= $preproyecto->seccion ?>" min="0">
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 m-md-auto">
                            <input class="form-check-input" type="checkbox" <?= ($preproyecto->incluido)? 'checked': '' ?> id="incluido" name="incluido">
                            <label class="form-check-label" for="incluido">
                                Incluido
                            </label>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 mb-3">
                            <label for="url">URL</label>
                            <input type="url" class="form-control" id="url" name="url" value="<?= $preproyecto->url ?>" placeholder="https://ejemplo.com">
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
        linea_accion    = <?= $preproyecto->linea_accion_id ?>;
</script>
<script src="<?= base_url('assets/js/preproyectos/editar.js') ?>" type="text/javascript" charset="utf-8" async defer></script>