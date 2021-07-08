<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Configurador</a></li>
            <li class="breadcrumb-item"><a href="#">Programas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Registrar Programa</h1>
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
                            <div class="mb-3 col-12">
                                <label class="my-1 me-2" for="nombre_programa"><span class="text-danger">*</span> Nombre del Programa</label>
                                <input type="text" id="nombre_programa" name="nombre_programa" class="form-control" placeholder="Ingrese nombre del Programa" required>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="my-1 me-2" for="clave_programa"><span class="text-danger">*</span> Clave del Programa</label>
                                <input type="text" id="clave_programa" name="clave_programa" class="form-control" placeholder="Ingrese la Clave" required>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="my-1 me-2" for="descripcion"><span class="text-danger">*</span> Descripción</label>
                                <textarea class="form-control" placeholder="Detalles del Programa" id="descripcion" name="descripcion" rows="4"></textarea>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="my-1 me-2" for="objetivo"><span class="text-danger">*</span> Objetivo</label>
                                <textarea class="form-control" placeholder="Objetivo del Programa" id="objetivo" name="objetivo" rows="3"></textarea>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="my-1 me-2" for="techo_financiero"><span class="text-danger">*</span> Techo Financiero</label>
                                <input type="number" id="techo_financiero" name="techo_financiero" class="form-control" placeholder="Techo financiero" value="0" min="0" required>
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