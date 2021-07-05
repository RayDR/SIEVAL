    <!-- Loader -->
    <div id="loader" class="loader-background">
        <span></span><span></span>
        <div class="text-white">Cargando</div>
    </div>
    <!-- Fin Loader -->

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/loader.css') ?>?<?= date('dmYHis') ?>" />
    <script type="text/javascript">
        $(document).ready(function() { loader(false); });
    </script>
