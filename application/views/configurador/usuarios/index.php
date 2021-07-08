<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Configurador</a></li>
            <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Listado de Usuarios</h1>
        </div>
    </div>
    <div class="btn-toolbar dropdown">
      <a href="<?= base_url('index.php/Configurador/registrar/Usuario') ?>" class="btn btn-dark btn-sm me-2 dropdown-toggle">
        <span class="fas fa-plus me-2"></span>Nuevo Usuario
      </a>
    </div>
</div>
<div class="card border-light shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dtUsuarios" class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="">#</th>
                        <th class="">Cuenta</th>
                        <th class="">Nombre Completo</th>
                        <th class="">Pertenece</th>
                        <th class="">Estatus</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<script src="<?= base_url('assets/js/configurador/configurador.js') ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>
<script src="<?= base_url('assets/js/configurador/usuarios/usuarios.js') ?>?" type="text/javascript" charset="utf-8" async defer></script>