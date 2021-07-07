<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Configurador</a></li>
            <li class="breadcrumb-item active" aria-current="page">Proyectos</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Proyectos Registrados</h1>
        </div>
    </div>
    <div class="btn-toolbar dropdown">
      <a href="<?= base_url('index.php/Configurador/registrar/Proyecto') ?>" class="btn btn-dark btn-sm me-2 dropdown-toggle">
        <span class="fas fa-plus me-2"></span>Nuevo Proyecto
      </a>
    </div>
</div>
<div class="card border-light shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive-md">
            <table id="dtProyectos" class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0">#</th>
                        <th class="border-0">Clave Programa Presupuestario</th>
                        <th class="border-0">Línea de Acción</th>
                        <th class="border-0">Objetivos</th>
                        <th class="border-0">Estrategia</th>
                        <th class="border-0">Fuente de Financiamiento</th>
                        <th class="border-0">Usuario Registró</th>
                        <th class="border-0">Fecha de Creación</th>
                        <th class="border-0">Ejercicio</th>
                        <th class="border-0">Estatus</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<script src="<?= base_url('assets/js/configurador/configurador.js') ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>
<script src="<?= base_url('assets/js/configurador/proyectos/proyectos.js'); ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>