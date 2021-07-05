<?php header('Access-Control-Allow-Origin: *'); ?>
<?php $this->load->view( RUTA_TEMA_ALT . 'header' ); ?>

<body id="body-extendido">
	<main style="min-height: 100vh;">
		<!-- Vista dinámica -->
		<?php $this->load->view($view);?>
		<!-- Fin vista dinámica -->

        <div id="modales">
            <?php $this->load->view(RUTA_TEMA_EXTRAS .'/modales/modal_generico'); ?>
        </div>
	</main>

    <input type="hidden" id="base_url" value="<?=base_url()?>">

    <!-- Fontawesome JS -->
    <script src="https://kit.fontawesome.com/8cca2ecc5a.js" crossorigin="anonymous"></script>
    <!-- Core -->
    <script src="<?= base_url('vendor/@popperjs/core/dist/umd/popper.min.js') ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <!-- Vendor JS -->
    <script src="<?= base_url('vendor/onscreen/dist/on-screen.umd.min.js') ?>"></script>
    <!-- Slider -->
    <script src="<?= base_url('vendor/nouislider/distribute/nouislider.min.js') ?>"></script>
    <!-- Smooth scroll -->
    <script src="<?= base_url('vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') ?>"></script>
    <!-- Charts -->
    <script src="<?= base_url('vendor/chartist/dist/chartist.min.js') ?>"></script>
    <script src="<?= base_url('vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') ?>"></script>
    <!-- Datepicker -->
    <script src="<?= base_url('vendor/vanillajs-datepicker/dist/js/datepicker.min.js') ?>"></script>
    <!-- Sweet Alerts 2 -->
    <script src="<?= base_url('vendor/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
    <!-- Moment JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <!-- Vanilla JS Datepicker -->
    <script src="<?= base_url('vendor/vanillajs-datepicker/dist/js/datepicker.min.js') ?>"></script>
    <!-- Notyf -->
    <script src="<?= base_url('vendor/notyf/notyf.min.js') ?>"></script>
    <!-- Simplebar -->
    <script src="<?= base_url('vendor/simplebar/dist/simplebar.min.js') ?>"></script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Volt JS -->
    <script src="<?= base_url('assets/js/volt.js') ?>"></script>
    <!-- Utilerias JS -->
    <script src="<?= base_url('assets/js/utilerias.js') ?>" type="text/javascript" charset="utf-8" async defer></script>
</body>
</html>
