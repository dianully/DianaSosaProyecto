<div class="main-section">
    <div class="register-container">
        <h3 class="h5">Editar Perfil</h3>
        <form id="edit-profile-form" method="post" action="<?= base_url('/perfil/guardar') ?>">
            <!-- Columna 1: Datos personales -->
            <div class="column">
                <div>
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?= esc($usuario['nombre'] ?? '') ?>" required>
                </div>
                <div>
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" value="<?= esc($usuario['apellido'] ?? '') ?>" required>
                </div>
                <div>
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni" value="<?= esc($usuario['dni'] ?? '') ?>" pattern="\d{8}" title="El DNI debe tener 8 digitos numericos">
                </div>
                <div>
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" value="<?= esc($usuario['telefono'] ?? '') ?>">
                </div>
                <div>
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" value="<?= esc($usuario['email'] ?? '') ?>" required>
                </div>
                <div>
                    <label for="domicilio">Domicilio</label>
                    <input type="text" name="domicilio" id="domicilio" value="<?= esc($usuario['domicilio'] ?? '') ?>" maxlength="100">
                </div>
            </div>
            <button type="submit">Guardar Cambios</button>
            <!-- Mostrar mensaje de éxito debajo del botón -->
            <?php if (session()->has('success')): ?>
                <div class="form-success">
                    <?= esc(session('success')) ?>
                </div>
            <?php endif; ?>
            <!-- Mostrar mensaje de error si existe -->
            <?php if (session()->has('error')): ?>
                <div class="form-error">
                    <?= esc(session('error')) ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>