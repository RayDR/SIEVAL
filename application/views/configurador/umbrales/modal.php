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

<form id="fcUmbral" class="container formulario">
    <input type="hidden" id="umbral_id" name="umbral_id" value="<?= $umbral->umbral_id ?>">
    <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-transparent">
        <div class="row d-flex justify-content-between">
            <div class="col my-auto">
                <h2 class="h5 mb-4">Umbral <?= $umbral->umbral_id ?></h2>
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

        <div class="card card-body shadow-sm mb-4 mb-lg-0 bg-white" style="color: #000 !important;">
            <div class="row mb-3">
                <div class="col-lg-6 mb-2">
                    <label for="cve_umbral">Clave</label>
                    <input type="text" name="cve_umbral" id="cve_umbral" class="form-control" value="<?= $umbral->cve_umbral ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <h4>Límites Aceptables</h4>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <p>Límite Aceptable Inferior</p>
                            <input type="number" class="form-control" id="l_aceptable_inf" name="l_aceptable_inf" step="0.01" value="<?= $umbral->limite_aceptable_inf ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <p>Límite Aceptable Superior</p>
                            <input type="number" class="form-control" id="l_aceptable_sup" name="l_aceptable_sup" step="0.01" value="<?= $umbral->limite_aceptable_sup ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h4>Límites de Riesgo</h4>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <p>Límite Riesgo Inferior</p>
                            <input type="number" class="form-control" id="l_riesgo_inf" name="l_riesgo_inf" step="0.01" value="<?= $umbral->limite_riesgo_inf ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <p>Límite Riesgo Superior</p>
                            <input type="number" class="form-control" id="l_riesgo_sup" name="l_riesgo_sup" step="0.01" value="<?= $umbral->limite_riesgo_sup ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h4>Límites Críticos</h4>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <p>Límite Crítico Inferior</p>
                            <input type="number" class="form-control" id="l_critico_inf" name="l_critico_inf" step="0.01" value="<?= $umbral->limite_critico_inf ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <p>Límite Crítico Superior</p>
                            <input type="number" class="form-control" id="l_critico_sup" name="l_critico_sup" step="0.01" value="<?= $umbral->limite_critico_sup ?>">
                        </div>
                    </div>
                </div>
            </div>

            <input id="guardar" type="submit" value="Editar" class="btn btn-primary my-3" style="display: none;">
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