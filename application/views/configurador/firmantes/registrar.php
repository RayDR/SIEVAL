<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Configurador</a></li>
            <li class="breadcrumb-item"><a href="#">Firmantes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Registrar Firmante</h1>
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
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label class="my-1 me-2" for="usuario_id"><span class="text-danger">*</span> Usuario Firmante</label>
                                <select class="form-select select2" id="area_responsable" aria-label="Área Responsable">
                                    <option selected disabled>Seleccione una opción</option>
                                    <?php foreach ($usuarios as $key => $usuario): ?>
                                    <option value="<?= $usuario->usuario_id ?>"><?= $usuario->nombres ?> <?= $usuario->primer_apellido ?> <?= $usuario->segundo_apellido ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            
                            <div class="mb-3 col-12">
                                <label class="my-1 me-2" for="area_responsable">Área Responsable</label>
                                <select class="form-select areas_select2" id="area_responsable" aria-label="Área Responsable">
                                    <option selected disabled>Seleccione una opción</option>
                                </select>
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