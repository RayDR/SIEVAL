<nav id="sidebarMenu" class="sidebar d-md-block bg-dark text-white collapse" data-simplebar>
   <div class="sidebar-inner px-4 pt-3">
      <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
         <div class="d-flex align-items-center">
            <div class="user-avatar lg-avatar me-4">
               <img src="" class="card-img-top rounded-circle border-white"
               alt="Perfil">
            </div>
            <div class="d-block">
               <h2 class="h6">Hola, <?= $this->session->userdata('nombres') ?> <?= $this->session->userdata('primer_apellido') ?></h2>
               <a href="<?= base_url('index.php/Perfil') ?>" class="btn btn-secondary text-dark btn-xs">
                  <span class="me-2"><span class="far fa-user-circle"></span></span>Mi Perfil
               </a>
               <a href="<?= base_url('index.php/Home/logout') ?>" class="btn btn-secondary text-dark btn-xs">
                  <span class="me-2"><span class="fas fa-sign-out-alt"></span></span>Cerrar sesión
               </a>
            </div>
         </div>
         <div class="collapse-close d-md-none">
            <a href="#sidebarMenu" class="fas fa-times" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
            aria-controls="sidebarMenu" aria-expanded="true" aria-label="Ocultar/mostrar navegación"></a>
         </div>
      </div>
      <ul class="nav flex-column pt-3 pt-md-0">
         <?php $submenuActivo = FALSE; ?>
         <?php foreach ($menu as $key => $opcion): ?>
            <?php // Validar el tipo del menú
            if ( ! $opcion->submenu_id && $submenuActivo ){
               echo '      </ul>
                        </div>
                     </li>';
               $submenuActivo = FALSE;
            }
            if( ( $opcion->solo_admin == 1 && $this->session->userdata('tuser') == 1 ) ||   // Solo admin
                ( $opcion->solo_admin == 0 && $this->session->userdata('tuser') == 1 ) ||   // User admin  - acceso general
                ( $opcion->solo_admin == 0 && $this->session->userdata('tuser') != 1 )      // Acceso general
            ){
               switch ($opcion->clave) {
                  case 'EL':
                     ?>
                     <li class="nav-item">
                        <a href="<?= base_url($opcion->url) ?>" class="nav-link">
                           <span class="sidebar-icon"><span class="<?= $opcion->icono ?>"></span></span>
                           <span class="sidebar-text"><?= $opcion->menu ?></span>
                        </a>
                     </li>
                     <?php
                     break;
                  case 'EE':
                     ?>
                     <li class="nav-item">
                        <a href="$opcion->url" class="nav-link">
                           <span class="sidebar-icon"><span class="<?= $opcion->icono ?>"></span></span>
                           <span class="sidebar-text"><?= $opcion->menu ?></span>
                        </a>
                     </li>
                     <?php
                     break;
                  case 'SM':
                     ?>
                     <li class="nav-item">
                        <span class="nav-link collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#submenu-<?= $opcion->menu_id ?>">
                           <span>
                              <span class="sidebar-icon"><span class="<?= $opcion->icono ?>"></span></span>
                              <span class="sidebar-text"><?= $opcion->menu ?></span>
                           </span>
                           <span class="link-arrow"><span class="fas fa-chevron-right"></span></span>
                        </span>
                        <div class="multi-level collapse" role="list" id="submenu-<?= $opcion->menu_id ?>" aria-expanded="false">
                           <ul class="flex-column nav">
                     <?php $submenuActivo = TRUE;
                     break;
                  case 'AP':
                     ?>
                     <li class="nav-item">
                        <a href="#<?= $opcion->url ?>" data-url="<?= $opcion->url ?>" class="nav-link link-personalizado">
                           <span class="sidebar-icon"><span class="<?= $opcion->icono ?>"></span></span>
                           <span class="sidebar-text"><?= $opcion->menu ?></span>
                        </a>
                     </li>
                     <?php
                     break;
                  case 'SP':
                     ?>
                     <li role="separator" class="dropdown-divider mt-4 mb-3 border-black"></li>
                     <?php 
                     break;
               }
            }?>            
         <?php endforeach;
            if ( $submenuActivo ){
               echo '      </ul>
                        </div>
                     </li>';
               $submenuActivo = FALSE;
            }
         ?>
      </ul>
   </div>
</nav>