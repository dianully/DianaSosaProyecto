<div class="main-section">
    <div class="register-container">
        <h3 class="h5">Panel de Administrador</h3>
        <?php if (session()->has('success')): ?>
            <div class="temp-password-message">
                <?php
                $success = session('success');
                if (strpos($success, 'Contraseña temporal') !== false) {
                    preg_match('/ID: (\d+)/', $success, $idMatch);
                    preg_match('/Contraseña temporal: <strong>(.*?)<\/strong>/', $success, $passMatch);
                    $id = $idMatch[1] ?? '';
                    $password = $passMatch[1] ?? '';
                    $emailMatch = preg_match('/Administrador de correo electrónico (.*?)( añadido|$)/', $success, $emailMatch);
                    $email = $emailMatch ? $emailMatch[1] : '';
                    echo "Administrador de correo electrónico '$email' añadido exitosamente. ID: $id. Su contraseña temporal es: <b>$password</b>. Copia la contraseña y compártela con el nuevo administrador.";
                }
                ?>
            </div>
        <?php endif; ?>
        <p>Selecciona una opción:</p>
        <div class="button-group">
            <a href="<?= base_url('administrar_usuarios') ?>" class="btn btn-primary">Administrar Usuarios</a>
            <a href="<?= base_url('Productos') ?>" class="btn btn-primary">Administrar Juegos</a>
            <a href="<?= base_url('facturas_cliente') ?>" class="btn btn-primary">Ver Facturas</a>
            <a href="<?= base_url('ver_consultas') ?>" class="btn btn-primary">Ver Consultas</a>
        </div>
    </div>
</div>

<style>
.button-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 20px;
}
.btn-primary {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    text-align: center;
}
.btn-primary:hover {
    background-color: #0056b3;
}
</style>