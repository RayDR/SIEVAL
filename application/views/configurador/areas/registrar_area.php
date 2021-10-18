<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Configurador</a></li>
            <li class="breadcrumb-item"><a href="#">Ásignación y Configuración de Áreas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Registrar Combinación de Área</h1>
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
                                <label class="my-1 me-2" for="direccion">Dirección</label>
                                <select class="form-select" id="direccion" name="direccion" aria-label="Área Responsable">
                                    <option selected disabled>Seleccione una opción</option>
                                    <?php foreach($direcciones as $key => $direccion): ?>
                                        <option value="<?= $direccion->direccion_id ?>"><?= $direccion->descripcion ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-12 card card-body mb-4">
                                <div class="row">
                                    <h4>Combinación de Área</h4>
                                    <div class="mb-3 col-lg-6">
                                        <label class="my-1 me-2" for="descripcion_subdireccion"> Nombre de la Subdirección</label>
                                        <input type="text" id="descripcion_subdireccion" name="descripcion_subdireccion" class="form-control" placeholder="Ingrese nombre de la Subdirección">
                                    </div>
                                    <div class="mb-3 col-lg-4">
                                        <label class="my-1 me-2" for="clave_subdireccion"> Clave de Subdirección</label>
                                        <input type="text" id="clave_subdireccion" name="clave_subdireccion" class="form-control" placeholder="Ingrese la Clave">
                                    </div>
                                    <div class="mb-3 col-lg-6">
                                        <label class="my-1 me-2" for="descripcion_departamento"> Nombre del Departamento</label>
                                        <input type="text" id="descripcion_departamento" name="descripcion_departamento" class="form-control" placeholder="Ingrese nombre del Departamento">
                                    </div>
                                    <div class="mb-3 col-lg-4">
                                        <label class="my-1 me-2" for="clave_departamento"> Clave de Departamento</label>
                                        <input type="text" id="clave_departamento" name="clave_departamento" class="form-control" placeholder="Ingrese la Clave de Departamento">
                                    </div>
                                    <div class="mb-3 col-lg-6">
                                        <label class="my-1 me-2" for="descripcion_area"> Nombre del Área</label>
                                        <input type="text" id="descripcion_area" name="descripcion_area" class="form-control" placeholder="Ingrese nombre del Área">
                                    </div>
                                    <div class="mb-3 col-lg-4">
                                        <label class="my-1 me-2" for="clave_area"> Clave del Área</label>
                                        <input type="text" id="clave_area" name="clave_area" class="form-control" placeholder="Ingrese la Clave Área">
                                    </div>
                                    <div class="col-12">                                    
                                        <button id="guardar" type="submit" class="btn btn-secondary">Agregar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <div class="table-responsive">
                                    <table id="combinaciones" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th>Dirección</th>
                                                <th>Subdirección</th>
                                                <th>Departamento</th>
                                                <th>Área</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                    </table>
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