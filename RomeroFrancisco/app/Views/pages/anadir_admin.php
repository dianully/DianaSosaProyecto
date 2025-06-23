<div class="main-section">
    <div class="login-container">
        <h3 class="h5">Añadir Nuevo Administrador</h3>
        <form class="login-form" method="post" action="<?= base_url('/anadir_admin/enviar') ?>">
            <div>
                <label for="correo">Correo Electrónico del Nuevo Administrador</label>
                <input type="email" name="correo" id="correo" required>
            </div>
            <button type="submit" class="btn btn-primary">Añadir</button>
            <!-- Mensaje flash debajo del botón con botón de cerrar en la esquina superior derecha -->
            <?php if (session()->has('error') || session()->has('success')): ?>
                <div class="alert <?php echo session()->has('error') ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert" style="max-width: 500px; margin-top: 10px; position: relative;">
                    <?= session()->has('error') ? esc(session('error')) : esc(session('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: absolute; top: 10px; right: 10px;"></button>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>