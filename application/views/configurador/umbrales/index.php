<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Configurador</a></li>
            <li class="breadcrumb-item active" aria-current="page">Umbrales</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Umbrales registrados</h1>
        </div>
    </div>
    <div class="btn-toolbar dropdown">
      <a href="<?= base_url('index.php/Configurador/registrar/Umbral') ?>" class="btn btn-dark btn-sm me-2 dropdown-toggle">
        <span class="fas fa-plus me-2"></span>Nuevo Umbral
      </a>
    </div>
</div>
<div class="card border-light shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dtUmbrales" class="table table-centered table-nowrap mb-0 rounded" style="width: 100% !important;">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0">#</th>
                        <th class="border-0">Clave</th>
                        <th class="border-0">Límite Aceptable</th>
                        <th class="border-0">Límite de Riesgo</th>
                        <th class="border-0">Límite Crítico</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<script src="<?= base_url('assets/js/configurador/configurador.js') ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>
<script src="<?= base_url('assets/js/configurador/umbrales/umbrales.js'); ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>