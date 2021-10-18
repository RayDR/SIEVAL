<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Configurador</a></li>
            <li class="breadcrumb-item"><a href="#">Umbrales</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Registrar Umbral</h1>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-light shadow-sm components-section">
                <div class="card-body">                    
                    <div class="mb-3">
                        <?php $this->load->view(RUTA_TEMA_UTIL . '/alertas'); ?>
                    </div>
                    <form>
                        <div class="card-text fs-5 my-3">Los campos marcados con <span class="text-danger">*</span> son requeridos</div>
                        <div class="row mb-3">
                            <div class="mb-3 col-12">
                                <label class="my-1 me-2" for="clave_umbral"><span class="text-danger">*</span> Clave del Umbral</label>
                                <input class="form-control" type="text" id="clave_umbral" name="clave_umbral" placeholder="Ingrese la Clave del Umbral" required>
                            </div>
                        </div>
                        <div class="row card card-body">
                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Límite Aceptable</h4>
                                    </div>
                                    <div class="col-6">
                                        <label for="l_aceptable_inf">Inferior</label>
                                        <input class="form-control" type="number" id="l_aceptable_inf" name="l_aceptable_inf" value="90">
                                    </div>
                                    <div class="col-6">
                                        <label for="l_aceptable_sup">Superior</label>
                                        <input class="form-control" type="number" id="l_aceptable_sup" name="l_aceptable_sup" value="100">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Límite Riesgo</h4>
                                    </div>
                                    <div class="col-6">
                                        <label for="l_riesgo_inf">Inferior</label>
                                        <input class="form-control" type="number" id="l_riesgo_inf" name="l_riesgo_inf" value="85">
                                    </div>
                                    <div class="col-6">
                                        <label for="l_riesgo_sup">Superior</label>
                                        <input class="form-control" type="number" id="l_riesgo_sup" name="l_riesgo_sup" value="105">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Límite Crítico</h4>
                                    </div>
                                    <div class="col-6">
                                        <label for="l_critico_inf">Inferior</label>
                                        <input class="form-control" type="number" id="l_critico_inf" name="l_critico_inf" value="70">
                                    </div>
                                    <div class="col-6">
                                        <label for="l_critico_sup">Superior</label>
                                        <input class="form-control" type="number" id="l_critico_sup" name="l_critico_sup" value="110">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-3 col-12">
                                <button id="guardar" type="submit" class="btn btn-dark">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var inputs = JSON.parse('<?php print(json_encode($inputs, JSON_HEX_TAG)); ?>');
</script>
<script src="<?= base_url('assets/js/configurador/configurador.js') ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>
<script src="<?= base_url('assets/js/configurador/programas/registrar.js') ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>