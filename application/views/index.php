<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
  <div class="btn-toolbar dropdown">
    <button class="btn btn-dark btn-sm me-2 dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="fas fa-plus me-2"></span>Acceso rápido
    </button>
    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-0">
      <?php if ( $this->session->userdata('tuser') != 2 ): //No consultores ?> 
      <a id="nuevo_actividad" onclick="fnueva_actividad()" class="dropdown-item fw-normal" href="#nueva_actividad"><span class="far fa-calendar-plus"></span>Nueva Actividad</a>
      <a id="nuevo_acuerdo" onclick="fnuevo_acuerdo()" class="dropdown-item fw-normal rounded-top" href="#nuevo_acuerdo"><span class="fas fa-file-signature"></span>Nuevo Acuerdo</a>
      <div role="separator" class="dropdown-divider my-0"></div>
      <?php endif; ?>
      <a class="dropdown-item fw-normal rounded-bottom" href="#"><span class="fas fa-file-import"></span>Reportes</a>
    </div>
  </div>
</div>
<div class="row justify-content-md-center">
  <div class="col-12">
    <h1>Tablero Ejecutivo</h1>
  </div>
  <div class="col-12">
    <div class="col-lg-4">      
      <div class="mb-4">
        <label class="my-1 me-2" for="filtro-area">Dirección</label>
        <select class="form-select" id="filtro-area" aria-label="Filtro de dirección/área">
          <option selected="selected">Todos</option>
        </select>
      </div>
    </div>
    <div class="col-md-4"></div>
  </div>
  <!-- Sección Estadística -->
  <div class="col-12">
    <!-- Contadores por Módulo -->
    <div class="row mb-3">
      <div class="col-12 col-lg-4 mb-4 mb-md-0">
        <div class="card border-light shadow-sm">
          <div class="card-body">
            <h2 class="h5">Actividades</h2>
            <h3 id="counter-actividades" class="h2 mb-1">0</h3>
            <div class="small mb-3">
              <span class="icon icon-small">
                <span class="far fa-calendar-alt"></span>
              </span> 
              <a class="stretched-link" href="<?= base_url('Actividades') ?>">Ver más</a></div>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-4 mb-4 mb-md-0">
        <div class="card border-light shadow-sm">
          <div class="card-body">
            <h2 class="h5">Preproyectos</h2>
            <h3 id="counter-preproyectos" class="h2 mb-1">0</h3>
            <div class="small mb-3">
              <span class="icon icon-small">
                <span class="fas fa-tasks"></span>
              </span> 
              <a class="stretched-link" href="<?= base_url('Preproyectos') ?>">Ver más</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-4 mb-4 mb-md-0">
        <div class="card border-light shadow-sm">
          <div class="card-body">
            <h2 class="h5">Acuerdos</h2>
            <h3 id="counter-acuerdos" class="h2 mb-1">0</h3>
            <div class="small mb-3">
              <span class="icon icon-small">
                <span class="far fa-handshake"></span>
              </span>
              <a class="stretched-link" href="<?= base_url('Acuerdos') ?>">Ver más</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Contadores por Módulo -->
    <!-- Gráficas de Finanzas -->
    <div class="row">
      <div class="col-12 col-xl-6 mb-4">
        <div class="card border-light shadow-sm">
          <div class="card-body d-flex flex-row align-items-center flex-0 border-bottom">
            <div class="d-block">
              <h2 class="h5">Progreso de Actividades</h2>
              <div class="d-flex">
              </div>
            </div>
          </div>
          <div class="card-body p-2">
            <div class="ct-chart-app-ranking ct-major-tenth ct-series-a">
              <div class="chartist-tooltip" style="top: -22px; left: 628px;">
                <span class="chartist-tooltip-value">10</span>
              </div>
            </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-6 mb-4">
          <div class="card border-light shadow-sm">
            <div class="card-body d-flex flex-row align-items-center flex-0 border-bottom">
              <div class="d-block">
                <h2 class="h5">Progreso de Preproyectos</h2>
                <div class="d-flex">
                  <div class="d-flex align-items-center me-3 lh-130">
                    <span class="shape-xs rounded-circle bg-tertiary me-2"></span> 
                    <span class="fw-normal small">Con Acciones</span>
                  </div>
                  <div class="d-flex align-items-center me-3 lh-130">
                    <span class="shape-xs rounded-circle bg-secondary me-2"></span> 
                    <span class="fw-normal small">Con Avances</span>
                  </div>
                  <div class="d-flex align-items-center me-3 lh-130">
                    <span class="shape-xs rounded-circle bg-dark me-2"></span> 
                    <span class="fw-normal small">Cumplidos</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body p-2">
              <div class="ct-chart-app-ranking ct-major-tenth ct-series-a">
                <div class="chartist-tooltip" style="top: -22px; left: 628px;">
                  <span class="chartist-tooltip-value">10</span>
                </div>
              </div>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Gráficas de Finanzas -->
  </div>
  <!-- /Sección Estadística -->
</div>

<script src="<?= base_url('assets/js/dashboard.js') ?>" type="text/javascript" charset="utf-8" async defer></script>

<?php $this->load->view(BASE_TEMA . 'footer'); ?>