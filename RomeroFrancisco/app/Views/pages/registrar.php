<div class="main-section">
    <div class="register-container">
        <h3 class="h5">Registrarse</h3>
        <form id="register-form" method="post" action="<?= base_url('/registrar/save') ?>">
            <!-- Mensajes de error dentro del contenedor -->
            <?php if (session()->has('error')): ?>
                <div class="form-error">
                    <?php
                    $error = session('error');
                    if (is_string($error) && strpos($error, '{') === 0) {
                        $errorData = json_decode($error, true);
                        if (json_last_error() === JSON_ERROR_NONE && isset($errorData['email'])) {
                            echo esc($errorData['email']);
                        } else {
                            echo esc($error);
                        }
                    } else {
                        echo esc($error);
                    }
                    ?>
                </div>
            <?php endif; ?>
            <?php if (isset($validation)): ?>
                <div class="form-error"><?= $validation->listErrors() ?></div>
            <?php endif; ?>
            <!-- Columna 1: Datos personales -->
            <div class="column">
                <div>
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?= set_value('nombre') ?>" required>
                </div>
                <div>
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" value="<?= set_value('apellido') ?>" required>
                </div>
                <div>
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni" value="<?= set_value('dni') ?>" pattern="\d{8}" title="El DNI debe tener 8 dígitos numéricos" required>
                </div>
                <div>
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" value="<?= set_value('telefono') ?>" required>
                </div>
                <div>
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" value="<?= set_value('email') ?>" required>
                </div>
                <div>
                    <label for="domicilio">Domicilio</label>
                    <input type="text" name="domicilio" id="domicilio" value="<?= set_value('domicilio') ?>" maxlength="100">
                </div>
                <div>
                    <label for="contrasena">Contraseña</label>
                    <input type="password" name="contrasena" id="contrasena" required>
                </div>
                <div>
                    <label for="confirmar_contrasena">Confirmar Contraseña</label>
                    <input type="password" name="confirmar_contrasena" id="confirmar_contrasena" required>
                </div>
            </div>
            <button type="submit">Registrarse</button>
            <div class="register-link">
                ¿Ya tienes cuenta? <a href="<?= base_url('/ingresar') ?>">Inicia Sesión</a>
            </div>
        </form>
        <p class="optional-message">Puedes editar tu perfil más tarde para añadir información adicional.</p>
        <?php if (session()->has('id_rol')): ?>
            <a href="<?= base_url('editar_perfil') ?>" class="edit-profile-link">Completar o editar perfil</a>
        <?php endif; ?>
    </div>
</div>

<script>
document.getElementById('register-form').addEventListener('submit', function(event) {
    const contrasena = document.getElementById('contrasena').value;
    const confirmarContrasena = document.getElementById('confirmar_contrasena').value;
    if (contrasena !== confirmarContrasena) {
        event.preventDefault();
        alert('Las contraseñas no coinciden. Por favor, inténtelo de nuevo.');
    }
});
</script>