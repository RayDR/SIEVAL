<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Configurador</a></li>
            <li class="breadcrumb-item active" aria-current="page">Unidades de Medida</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Unidades de Medida registradas</h1>
        </div>
    </div>
    <div class="btn-group" role="group" aria-label="Botones de Acción">
        <a href="<?= base_url('index.php/Configurador/registrar/Ums') ?>" class="btn btn-dark btn-sm">
            <span class="fas fa-plus me-2"></span>Nueva
        </a>
        <a href="<?= base_url('index.php/Configurador/registrar/Ums') ?>" class="btn btn-dark btn-sm">
            <span class="fas fa-check me-2"></span>Asignación
        </a>
    </div>
</div>
<div class="card border-light shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dtUms" class="table table-centered table-nowrap mb-0 rounded w100" style="width: 100% !important;">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0">#</th>
                        <th class="border-0">Clave</th>
                        <th class="border-0">Descripción</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<script src="<?= base_url('assets/js/configurador/configurador.js') ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>
<script src="<?= base_url('assets/js/configurador/ums/ums.js'); ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>