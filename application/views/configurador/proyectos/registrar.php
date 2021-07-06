<div class="py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span></a></li>
            <li class="breadcrumb-item"><a href="#">Programas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Registrar Programa</h1>
            <p class="mb-0">Rellene el siguiente formulario</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-light shadow-sm components-section">
            <div class="card-body">
                <h2 class="h5 mb-4">Ejercicio <strong>2021</strong></h2>
                <div class="mb-4">
                    <label class="my-1 me-2" for="departamento">Departamento</label>
                    <select class="form-select" id="departamento" aria-label="Default select example">
                        <option selected="">Seleccione una opción</option>
                        <option value="1">Departamento 1</option>
                        <option value="2">Departamento 2</option>
                        <option value="3">Departamento 3</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="my-1 me-2" for="proyecto">Proyecto</label>
                    <select class="form-select" id="proyecto" aria-label="Default select example">
                        <option selected="">Seleccione una opción</option>
                        <option value="1">Proyecto 1</option>
                        <option value="2">Proyecto 2</option>
                        <option value="3">Proyecto 3</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="my-1 me-2" for="estrategia">Estrategia</label>
                    <select class="form-select" id="estrategia" aria-label="Default select example">
                        <option selected="">Seleccione una opción</option>
                        <option value="1">Estrategia 1</option>
                        <option value="2">Estrategia 2</option>
                        <option value="3">Estrategia 3</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="my-1 me-2" for="estrategia">Fuente de Financiamiento</label>
                    <select class="form-select" id="estrategia" aria-label="Default select example">
                        <option selected="">Seleccione una opción</option>
                        <option value="1">Fuente 1</option>
                        <option value="2">Fuente 2</option>
                        <option value="3">Fuente 3</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="firstName">Objetivo</label>
                    <input type="text" class="form-control" id="firstName" placeholder="Rellene este campo" value="" required="">
                    <div class="valid-feedback">
                        Correcto
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-dark">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?= base_url('assets/js/configurador/configurador.js') ?>?<?= date('dmYHis') ?>" type="text/javascript" charset="utf-8" async defer></script>