<style type="text/css" media="screen">
    .nav-link:hover, .nav-link:focus {
        background-color: #D1D5DB;
    } 
    .nav-pills .nav-link:hover{
        background-color: #D1D5DB;
    }
    .accordion-button{
        color: white;
    }
    .accordion-button:hover{
        color: #262B40;
    }
</style>

<div class="container">
    <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-transparent">
        <div class="row d-flex justify-content-between">
            <div class="col my-auto">
                <h3 class="h5 mb-4">Cuenta: <?= $usuario->cve_cuenta ?></h3>
            </div>
            <div class="col">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-center justify-content-end px-0 bg-transparent">
                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-pill-circle flex-column flex-md-row">
                                <li class="nav-item">
                                    <a id="editar" class="nav-link" aria-label="Tab Editar" data-bs-toggle="tooltip" title="Editar">
                                        <span class="nav-link-icon d-block">
                                            <span class="fas fa-pencil-alt fa-2x"></span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-white" style="color: #000 !important;">
            <div class="row mb-3">
                <div class="col-lg-4 mb-2">
                    <label for="nombres">Nombre(s)</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" value="<?= $usuario->nombres ?>">
                </div>
                <div class="col-lg-4 mb-2">
                    <label for="primer_apellido">Primer Apellido</label>
                    <input type="text" name="primer_apellido" id="primer_apellido" class="form-control" value="<?= $usuario->primer_apellido ?>">
                </div>
                <div class="col-lg-4 mb-2">
                    <label for="segundo_apellido">Segundo Apellido</label>
                    <input type="text" name="segundo_apellido" id="segundo_apellido" class="form-control" value="<?= $usuario->segundo_apellido ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="my-1 me-2" for="area_usuaria">Área Usuaria</label>
                    <select class="form-select areas_select2" id="area_usuaria" aria-label="Áreas">
                        <option selected disabled>Seleccione una opción</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>