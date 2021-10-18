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

<form id="fcArea" class="container formulario">
    <input type="hidden" id="direccion_id" name="direccion_id" value="<?= $direccion->direccion_id ?>">
    <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-transparent">
        <div class="row d-flex justify-content-between">
            <div class="col my-auto">
                <h2 class="h5 mb-4">Dirección <?= $direccion->direccion_id ?></h2>
            </div>
            <div class="col">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-center justify-content-end px-0 bg-transparent">
                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-pill-circle flex-column flex-md-row">
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card card-body shadow-sm mb-2 bg-white" style="color: #000 !important;">
            <div class="row mb-3">
                <div class="col-lg-6 mb-2">
                    <label for="descripcion">Nombre de la Dirección</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" value="<?= $direccion->descripcion ?>">
                </div>
                <div class="col-lg-6 mb-2">
                    <label for="cve_direccion">Clave</label>
                    <input type="text" name="cve_direccion" id="cve_direccion" class="form-control" value="<?= $direccion->cve_direccion ?>">
                </div>
            </div>
            <input id="guardar" type="submit" value="Editar" class="btn btn-primary my-3" style="display: none;">
        </div>
        <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-white" style="color: #000 !important;">
            <h4 class="text-dark">Combinación de Áreas</h4>
            <div class="table-responsive">
                <table class="table table-hover w-100">
                    <thead>
                        <tr>
                            <th width="6%"># ID</th>

                            <th width="8%">Clave Subdirección</th>
                            <th width="20%">Subdirección</th>

                            <th width="8%">Clave Departamento</th>
                            <th width="20%">Departamento</th>

                            <th width="8%">Clave Área</th>
                            <th width="20%">Área</th>

                            <th width="10%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $combinaciones as $key => $combinacion ): ?>
                            <?php if($key > 0): ?>
                            <tr data-combinacion_id="<?= $combinacion->combinacion_area_id ?>" data-direccion_id="<?= $combinacion->direccion_id ?>" data-subdireccion_id="<?= $combinacion->subdireccion_id ?>" data-departamento_id="<?= $combinacion->departamento_id ?>" data-area_id="<?= $combinacion->area_id ?>">
                                <td><?= $combinacion->combinacion_area_id ?></td>
                                <td>
                                    <?= $combinacion->cve_subdireccion ?>
                                </td>
                                <td>
                                    <?= $combinacion->subdireccion ?>
                                </td>

                                <td>
                                    <?= $combinacion->cve_departamento ?>
                                </td>
                                <td>
                                    <?= $combinacion->departamento ?>
                                </td>

                                <td>
                                    <?= $combinacion->cve_area ?>
                                </td>
                                <td>
                                    <?= $combinacion->area ?>
                                </td>

                                <td>
                                    <i class="fas fa-pencil-alt"></i>
                                    <i class="far fa-trash-alt"></i>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
$(document).ready(function($) {
    finicia_select2();
    $('.formulario').change(function(event) {
       $('#guardar').fadeIn('slow');
    });
    $('#guardar').click(fmConfEditar);
});

function fmConfEditar(e){
    e.preventDefault();
}
</script>