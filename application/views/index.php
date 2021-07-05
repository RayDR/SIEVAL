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
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-xl-6 mb-4">
        <div class="card border-light shadow-sm">
          <div class="card-body d-flex flex-row align-items-center flex-0 border-bottom">
            <div class="d-block">
              <h2 class="h5">Gráfico de ejemplo</h2>
              <div class="small mt-2 mb-3">
                <span class="fas fa-angle-up text-success"></span> 
                <span class="text-success fw-bold">155</span> 
                <span class="fw-bold ms-2">
                  <span class="icon icon-small me-1">
                    <span class="fas fa-globe-europe"></span>
                  </span>Actividades
                </span>
              </div>
              <div class="d-flex">
                <div class="d-flex align-items-center me-3 lh-130">
                  <span class="shape-xs rounded-circle bg-tertiary me-2"></span> 
                  <span class="fw-normal small">Direccion</span>
                </div>
                <div class="d-flex align-items-center me-3 lh-130">
                  <span class="shape-xs rounded-circle bg-secondary me-2"></span> 
                  <span class="fw-normal small">Subdirección</span>
                </div>
                <div class="d-flex align-items-center me-3 lh-130">
                  <span class="shape-xs rounded-circle bg-dark me-2"></span> 
                  <span class="fw-normal small">Departamento</span>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body p-2">
            <div class="ct-chart-app-ranking ct-major-tenth ct-series-a">
              <div class="chartist-tooltip" style="top: -22px; left: 628px;">
                <span class="chartist-tooltip-value">10</span>
              </div>
              <svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids">
                <line x1="10" x2="10" y1="15" y2="237.796875" class="ct-grid ct-horizontal"></line>
                <line x1="103.85714285714286" x2="103.85714285714286" y1="15" y2="237.796875" class="ct-grid ct-horizontal"></line>
                <line x1="197.71428571428572" x2="197.71428571428572" y1="15" y2="237.796875" class="ct-grid ct-horizontal"></line>
                <line x1="291.57142857142856" x2="291.57142857142856" y1="15" y2="237.796875" class="ct-grid ct-horizontal"></line>
                <line x1="385.42857142857144" x2="385.42857142857144" y1="15" y2="237.796875" class="ct-grid ct-horizontal"></line>
                <line x1="479.28571428571433" x2="479.28571428571433" y1="15" y2="237.796875" class="ct-grid ct-horizontal"></line>
                <line x1="573.1428571428571" x2="573.1428571428571" y1="15" y2="237.796875" class="ct-grid ct-horizontal"></line></g><g><g class="ct-series ct-series-a">
                <line x1="41.92857142857143" x2="41.92857142857143" y1="237.796875" y2="126.3984375" class="ct-bar" ct:value="5"></line>
                <line x1="135.78571428571428" x2="135.78571428571428" y1="237.796875" y2="148.678125" class="ct-bar" ct:value="4"></line>
                <line x1="229.64285714285717" x2="229.64285714285717" y1="237.796875" y2="170.9578125" class="ct-bar" ct:value="3"></line>
                <line x1="323.5" x2="323.5" y1="237.796875" y2="81.83906250000001" class="ct-bar" ct:value="7"></line>
                <line x1="417.3571428571429" x2="417.3571428571429" y1="237.796875" y2="126.3984375" class="ct-bar" ct:value="5"></line>
                <line x1="511.2142857142858" x2="511.2142857142858" y1="237.796875" y2="15" class="ct-bar" ct:value="10"></line>
                <line x1="605.0714285714286" x2="605.0714285714286" y1="237.796875" y2="170.9578125" class="ct-bar" ct:value="3"></line></g><g class="ct-series ct-series-b">
                <line x1="56.92857142857143" x2="56.92857142857143" y1="237.796875" y2="193.2375" class="ct-bar" ct:value="2"></line>
                <line x1="150.78571428571428" x2="150.78571428571428" y1="237.796875" y2="193.2375" class="ct-bar" ct:value="2"></line>
                <line x1="244.64285714285717" x2="244.64285714285717" y1="237.796875" y2="215.5171875" class="ct-bar" ct:value="1"></line>
                <line x1="338.5" x2="338.5" y1="237.796875" y2="126.3984375" class="ct-bar" ct:value="5"></line>
                <line x1="432.3571428571429" x2="432.3571428571429" y1="237.796875" y2="170.9578125" class="ct-bar" ct:value="3"></line>
                <line x1="526.2142857142858" x2="526.2142857142858" y1="237.796875" y2="148.678125" class="ct-bar" ct:value="4"></line>
                <line x1="620.0714285714286" x2="620.0714285714286" y1="237.796875" y2="193.2375" class="ct-bar" ct:value="2"></line></g><g class="ct-series ct-series-c">
                <line x1="71.92857142857143" x2="71.92857142857143" y1="237.796875" y2="170.9578125" class="ct-bar" ct:value="3"></line>
                <line x1="165.78571428571428" x2="165.78571428571428" y1="237.796875" y2="193.2375" class="ct-bar" ct:value="2"></line>
                <line x1="259.64285714285717" x2="259.64285714285717" y1="237.796875" y2="37.279687499999994" class="ct-bar" ct:value="9"></line>
                <line x1="353.5" x2="353.5" y1="237.796875" y2="126.3984375" class="ct-bar" ct:value="5"></line>
                <line x1="447.3571428571429" x2="447.3571428571429" y1="237.796875" y2="148.678125" class="ct-bar" ct:value="4"></line>
                <line x1="541.2142857142858" x2="541.2142857142858" y1="237.796875" y2="104.11875" class="ct-bar" ct:value="6"></line>
                <line x1="635.0714285714286" x2="635.0714285714286" y1="237.796875" y2="148.678125" class="ct-bar" ct:value="4"></line></g></g><g class="ct-labels">
                  <foreignObject style="overflow: visible;" x="10" y="242.796875" width="93.85714285714286" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 94px; height: 20px;">21 Apr</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="103.85714285714286" y="242.796875" width="93.85714285714286" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 94px; height: 20px;">21 Ap</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="197.71428571428572" y="242.796875" width="93.85714285714283" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 94px; height: 20px;">22 Ap</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="291.57142857142856" y="242.796875" width="93.85714285714289" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 94px; height: 20px;">23 Ap</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="385.42857142857144" y="242.796875" width="93.85714285714289" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 94px; height: 20px;">24 Ap</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="479.28571428571433" y="242.796875" width="93.85714285714278" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 94px; height: 20px;">25 Ap</span></foreignObject>
                  <foreignObject style="overflow: visible;" x="573.1428571428571" y="242.796875" width="93.85714285714289" height="20">
                    <span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 94px; height: 20px;">26 Ap</span>
                  </foreignObject></g>
                </svg>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-6 mb-4">
          <div class="row">
            <div class="col-12 mb-4">
              <div class="card border-light shadow-sm">
                <div class="card-body">
                  <div class="row d-block d-md-flex align-items-center">
                    <div class="col-12 col-md-5">
                      <h2 class="h5 mb-1">Gráfico Ejemplo 2</h2>
                      <h3 class="h1 mb-1">Total</h3>
                      <span class="small">Datos del conteo</span>
                    </div>
                    <div class="col-12 col-md-7 mt-3 mt-md-0">
                      <div class="col-12">
                        <div class="row d-flex align-items-center mb-1">
                          <div class="col-2 text-gray fw-bold px-0 small">5
                          </div>
                          <div class="col-10 px-0">
                            <div class="progress progress-lg rounded mb-0">
                              <div class="progress-bar bg-success rounded" role="progressbar" aria-valuenow="51" aria-valuemin="0" aria-valuemax="100" style="width: 51%;">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row d-flex align-items-center mb-1">
                          <div class="col-2 text-gray fw-bold px-0 small">4
                          </div>
                          <div class="col-10 px-0">
                            <div class="progress progress-lg rounded mb-0">
                              <div class="progress-bar bg-cyan rounded" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 31%;"></div>
                            </div>
                          </div>
                        </div>
                        <div class="row d-flex align-items-center mb-1">
                          <div class="col-2 text-gray fw-bold px-0 small">3
                          </div>
                          <div class="col-10 px-0">
                            <div class="progress progress-lg rounded mb-0">
                              <div class="progress-bar bg-warning rounded" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
                                
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row d-flex align-items-center mb-1">
                          <div class="col-2 text-gray fw-bold px-0 small">2
                          </div>
                          <div class="col-10 px-0">
                            <div class="progress progress-lg rounded mb-0">
                              <div class="progress-bar bg-pink rounded" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                                
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row d-flex align-items-center mb-1">
                          <div class="col-2 text-gray fw-bold px-0 small">1
                          </div>
                          <div class="col-10 px-0">
                            <div class="progress progress-lg rounded mb-0">
                              <div class="progress-bar bg-danger rounded" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100" style="width: 6%;"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 mb-4 mb-md-0">
              <div class="card border-light shadow-sm">
                <div class="card-body">
                  <h2 class="h5">Otro contador</h2>
                  <h3 class="h2 mb-1">367,567</h3>
                  <div class="small mb-3">Enero 1 - Abril 1, <span class="icon icon-small">
                    <span class="fas fa-globe-europe"></span>
                  </span> Actividades</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/dashboard.js') ?>" type="text/javascript" charset="utf-8" async defer></script>

<?php $this->load->view(BASE_TEMA . 'footer'); ?>