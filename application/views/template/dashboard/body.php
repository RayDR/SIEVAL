<?php $this->load->view( RUTA_TEMA . 'header' ); ?>

<body id="body-dashboard">
    <?php $this->load->view( RUTA_TEMA_MENUS . '/menu_movil', ['menu' => $menu] ); ?>
    <main class="content" style="min-height: 70vh;">
        <?php $this->load->view( RUTA_TEMA_MENUS . '/menu_superior' ); ?>
        <?php $this->load->view( RUTA_TEMA_MENUS . '/menu_lateral', ['menu' => $menu] ); ?>
        <!-- Vista dinámica -->
        <div id="ajax-html">
            <?php $this->load->view($view); ?>
        </div>
        <?php $this->load->view( RUTA_TEMA_UTIL . '/toast'); ?>
        <!-- Fin vista dinámica -->
        <div id="modales">
            <?php $this->load->view(RUTA_TEMA_EXTRAS .'/modales/modal_generico'); ?>
        </div>
        <?php $this->load->view( RUTA_TEMA_UTIL . '/chambianding'); ?>
    </main>

    <input type="hidden" id="base_url" value="<?=base_url()?>">
</body>
</html>
