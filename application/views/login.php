<section class="d-flex align-items-center my-5 mt-lg-6 mb-lg-5">
    <div class="container">
        <div class="row justify-content-center form-bg-image" data-background-lg="<?= base_url('assets/img/illustrations/signin.svg') ?>">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <h1 class="mb-0 h3">Iniciar sesión</h1>
                    </div>
                    <form action="#" class="mt-4">
                        <?php $this->load->view(RUTA_TEMA_UTIL . '/alertas'); ?>
                        <!-- Form -->
                        <div class="form-group mb-4">
                            <label for="text">Número de Cuenta</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><span class="fas fa-user-tie"></span></span>
                                <input id="usuario" type="text" class="form-control" placeholder="Ej: 123450" maxlength="8" autofocus required>
                            </div>
                        </div>
                        <!-- End of Form -->
                        <div class="form-group">
                            <!-- Form -->
                            <div class="form-group mb-4">
                                <label for="password">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2"><span class="fas fa-unlock-alt"></span></span>
                                    <input type="password" placeholder="Ingrese su contraseña" class="form-control" id="password" maxlength="30" required>
                                </div>
                            </div>
                            <!-- End of Form -->
                            <div class="d-flex justify-content-between align-items-top mb-4">
                                <div><a href="<?= base_url('index.php/Home/recovery') ?>" class="small text-right">Recuperar contraseña</a></div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button id="do_login" type="submit" class="btn btn-dark">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url('assets/js/sing.js') ?>" type="text/javascript" charset="utf-8" async defer></script>