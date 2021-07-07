<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Configurador</a></li>
            <li class="breadcrumb-item"><a href="#">Proyectos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Registrar Proyecto</h1>
            <p class="mb-0">Rellene el siguiente formulario</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-light shadow-sm components-section">
            <div class="card-body">
                <div class="mb-3">
                    <label class="my-1 me-2" for="proyecto_nombre">Nombre del Proyecto</label>
                    <input type="text" id="proyecto_nombre" name="proyecto_nombre" class="form-control" placeholder="Ingrese el nombre del Proyecto">
                </div>
                <div class="mb-3">
                    <label class="my-1 me-2" for="area_origen">Áreas</label>
                    <select class="form-select areas_select2" id="area_origen" aria-label="Áreas">
                        <option selected disabled>Seleccione una opción</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="my-1 me-2" for="programa_presupuestario">Programa Presupuestario</label>
                    <select class="form-select" id="programa_presupuestario" aria-label="Programas Presupuestarios" required>
                        <option selected disabled>Seleccione una opción</option>
                        <?php foreach ($programas as $key => $programa): ?>
                        <option value="<?= $programa->programa_presupuestario_id ?>" data-descripcion="<?= $programa->descripcion ?>" data-objetivo="<?= $programa->objetivo ?>">(<?= $programa->cve_programa ?>) <?= $programa->nombre ?></option>
                        <?php endforeach; ?>  
                    </select>
                </div>
                <div class="mb-3">
                    <label class="my-1 me-2" for="linea_accion">Línea de Acción</label>
                    <select class="form-select" id="linea_accion" aria-label="Líneas de Acción" required>
                        <option selected disabled>Seleccione una opción</option>
                        <?php foreach ($l_accion as $key => $linea): ?>
                        <option value="<?= $linea->linea_accion_id ?>" data-objetivo="<?= $linea->objetivo_programa ?>" data-estrategia="<?= $linea->estrategia_programa ?>"><?= $linea->linea_accion ?></option>
                        <?php endforeach; ?>  
                    </select>
                </div>
                <div id="datos_linea_accion" class="mb-3"></div>
                <div class="col-12 mb-3">
                    <label class="my-1 me-2" for="fuente_financiamiento">Fuente de Financiamiento</label>
                    <select class="form-select" id="fuente_financiamiento" aria-label="Fuente de Financiamiento" required>
                        <option selected disabled>Seleccione una opción</option>
                        <?php foreach ($f_financia as $key => $fuente): ?>
                        <option value="<?= $fuente->fuente_financiamiento_id ?>"><?= $fuente->descripcion ?></option>
                        <?php endforeach; ?>  
                    </select>
                </div>
                <div class="mt-3">
                    <button id="guardar" type="submit" class="btn btn-dark">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?= base_url('assets/js/configurador/configurador.js') ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>
<script src="<?= base_url('assets/js/configurador/proyectos/registrar.js') ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>