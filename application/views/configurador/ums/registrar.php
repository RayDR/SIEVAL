<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Configurador</a></li>
            <li class="breadcrumb-item"><a href="#">Unidades de Medida</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Registrar Unidades de Medida</h1>
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
                        <div class="row">
                            <div class="mb-3 col-lg-8">
                                <label class="my-1 me-2" for="descripcion"><span class="text-danger">*</span> Nombre de la UMS</label>
                                <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ingrese nombre de la UMS" required>
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label class="my-1 me-2" for="cve_medida"><span class="text-danger">*</span> Clave de la UMS</label>
                                <input type="text" id="cve_medida" name="cve_medida" class="form-control" placeholder="Ingrese la Clave de UMS" required>
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
<script src="<?= base_url('assets/js/configurador/ums/registrar.js') ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>