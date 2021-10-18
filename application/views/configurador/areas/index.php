<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Configurador</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ásignación y Configuración de Áreas</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Direcciones registradas</h1>
        </div>
    </div>
    <div class="btn-group" role="group" aria-label="Botones de Acción">
        <a href="<?= base_url('index.php/Configurador/registrar/Direccion') ?>" class="btn btn-dark btn-sm">
            <span class="fas fa-plus me-2"></span>Nueva Dirección
        </a>
        <a href="<?= base_url('index.php/Configurador/registrar/Area') ?>" class="btn btn-dark btn-sm">
            <span class="fas fa-plus me-2"></span>Nueva Área
        </a>
    </div>
</div>
<div class="card border-light shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dtDirecciones" class="table table-centered table-nowrap mb-0 rounded" style="width: 100% !important;">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0">#</th>
                        <th class="border-0">Clave</th>
                        <th class="border-0">Dirección</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<script src="<?= base_url('assets/js/configurador/configurador.js') ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>
<script src="<?= base_url('assets/js/configurador/areas/areas.js'); ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>