<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item active" aria-current="page">Indicadores</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Indicadores</h1>
        </div>
    </div>
    <?php if ( $this->session->userdata('tuser') != 2 ): //No consultores ?> 
    <div class="btn-toolbar dropdown">
      <a id="nuevo_indicador" href="#registrar" class="btn btn-dark btn-sm me-2 dropdown-toggle">
        <span class="fas fa-plus me-2"></span>Nuevo Indicador
      </a>
    </div>
    <?php endif; ?>
</div>
<div class="card border-light shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dtIndicadores" class="table table-hover table-centered table-nowrap mb-0 rounded w-100">
                <thead class="thead-light">
                    <tr>
                        <th class="">#</th>
                        <th class="">Indicador</th>
                        <th class="">Descripción</th>
                        <th class="">Definición</th>
                        <th class="">Propósito</th>
                        <th class="">Nivel</th>
                        <th class="">Fórmula</th>
                        <th class="">Método de Cálculo</th>
                        <th class="">Frecuencia de Medición</th>
                        <th class="">Ejercicio</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/indicadores/indicadores.js') ?>?V1.0" type="text/javascript" charset="utf-8" async defer></script>