<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Configurador</a></li>
            <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Registrar Usuario</h1>
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
                            <legend class="col-12">Información del Responsable</legend>
                            <div class="mb-3 col-lg-4">
                                <label class="my-1 me-2" for="nombres"><span class="text-danger">*</span> Nombre(s)</label>
                                <input type="text" id="nombres" name="nombres" class="form-control" required>
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label class="my-1 me-2" for="primer_apellido"><span class="text-danger">*</span> Primer Apellido</label>
                                <input type="text" id="primer_apellido" name="primer_apellido" class="form-control" required>
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label class="my-1 me-2" for="segundo_apellido">Segundo Apellido</label>
                                <input type="text" id="segundo_apellido" name="segundo_apellido" class="form-control">
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label class="my-1 me-2" for="sexo"><span class="text-danger">*</span> Sexo</label>
                                <select class="form-select" id="sexo" aria-label="Sexo">
                                    <option selected disabled>Seleccione una opción</option>
                                    <option value="1">Hombre</option>
                                    <option value="2">Mujer</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <legend class="col-12">Datos de Acceso</legend>
                            <div class="mb-3 col-lg-4">
                                <label class="my-1 me-2" for="usuario"><span class="text-danger">*</span> Número de Cuenta</label>
                                <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Se usara como usuario" required>
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label class="my-1 me-2" for="password"><span class="text-danger">*</span> Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <legend class="col-12">Información de Contacto</legend>
                            <div class="mb-3 col-lg-4">
                                <label class="my-1 me-2" for="correo"><span class="text-danger">*</span> Correo Electrónico</label>
                                <input type="email" id="correo" name="correo" class="form-control" placeholder="ejemplo@correo.com" required>
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label class="my-1 me-2" for="telefono"><span class="text-danger">*</span> Teléfono</label>
                                <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="Ej: 9930000000" size="10" maxlength="10" pattern="[0-9]{10}" required>
                            </div>
                        </div>
                        <div class="row">
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
<script src="<?= base_url('assets/js/configurador/usuarios/registrar.js') ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>