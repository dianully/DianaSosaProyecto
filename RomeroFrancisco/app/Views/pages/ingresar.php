<div class="main-section">
    <div class="login-container">
        <h3 class="h5">Iniciar Sesión</h3>
        <form class="login-form" method="post" action="<?= base_url('/ingresar/send') ?>">
            <!-- Mensajes de error dentro del contenedor -->
            <?php if (session()->has('error')): ?>
                <div class="form-error"><?= esc(session('error')) ?></div>
            <?php endif; ?>
            <?php if (isset($validation)): ?>
                <div class="form-error"><?= $validation->listErrors() ?></div>
            <?php endif; ?>
            <div>
                <label for="email">Correo Electrónico</label>
                <input type="email" name="email" id="email" value="<?= isset($email) ? esc($email) : set_value('email') ?>" required>
            </div>
            <div>
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Ingresar</button>
            <div class="register-link">
                ¿No tienes cuenta? <a href="<?= base_url('/registrar') ?>">Regístrate</a>
            </div>
        </form>
    </div>
</div>