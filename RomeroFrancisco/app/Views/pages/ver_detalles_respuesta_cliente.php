<div class="main-section">
    <div class="register-container">
        <h3 class="h5">Detalles de Tu Consulta <?= $consulta['Respondida'] == 1 ? 'Respondida' : 'No Respondida' ?></h3>
        <?php if (session()->has('message')): ?>
            <div class="form-success"><?= session('message') ?></div>
        <?php endif; ?>
        <?php if (session()->has('error')): ?>
            <div class="form-error"><?= session('error') ?></div>
        <?php endif; ?>

        <?php if (isset($consulta)): ?>
            <table class="users-table">
                <tr>
                    <th>ID de Consulta</th>
                    <td><?= esc($consulta['id_consulta']) ?></td>
                </tr>
                <tr>
                    <th>Tu Usuario (ID)</th>
                    <td><?= !empty($consulta['id_usuario']) ? esc($consulta['id_usuario']) : 'No registrado'; ?></td>
                </tr>
                <tr>
                    <th>Tu Nombre</th>
                    <td>
                        <?php
                        echo !empty($consulta['id_usuario']) ? esc($consulta['user_nombre']) : esc($consulta['nombre']);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Tu Apellido</th>
                    <td>
                        <?php
                        echo !empty($consulta['id_usuario']) ? esc($consulta['user_apellido']) : esc($consulta['apellido']);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Tu Email</th>
                    <td>
                        <?php
                        echo !empty($consulta['id_usuario']) ? esc($consulta['user_email']) : esc($consulta['email']);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Motivo de Consulta</th>
                    <td><?= esc($consulta['motivoConsulta']) ?></td>
                </tr>
                <tr>
                    <th>Tu Comentario</th>
                    <td><?= esc($consulta['comentarioAdicional']) ?></td>
                </tr>
                <tr>
                    <th>Fecha de Consulta</th>
                    <td><?= esc($consulta['fecha']) ?></td>
                </tr>
                <tr>
                    <th>Respuesta del Administrador</th>
                    <td><?= $consulta['Respondida'] == 1 ? esc($consulta['Respuesta']) : 'Aún no hay respuesta' ?></td>
                </tr>
                <?php if ($consulta['Respondida'] == 1 && !empty($consulta['id_usuario_responde'])): ?>
                    <tr>
                        <th>Respondida por</th>
                        <td>
                            <?= esc($consulta['admin_nombre']) ?> <?= esc($consulta['admin_apellido']) ?> (ID: <?= esc($consulta['admin_id']) ?>)<br>
                            Email: <?= esc($consulta['admin_email']) ?>
                        </td>
                    </tr>
                <?php elseif ($consulta['Respondida'] == 0): ?>
                    <tr>
                        <th>Respondida por</th>
                        <td>-</td>
                    </tr>
                <?php endif; ?>
            </table>
            <div class="mt-4">
                <a href="<?= base_url(); ?>" class="btn btn-primary">Volver al Inicio</a>
                <a href="<?= base_url('informacionContacto'); ?>" class="btn btn-secondary">Hacer otra consulta</a>
            </div>
        <?php else: ?>
            <p>No se encontró la consulta o no tienes permiso para verla.</p>
            <div class="mt-4">
                <a href="<?= base_url(); ?>" class="btn btn-primary">Volver al Inicio</a>
            </div>
        <?php endif; ?>
    </div>
</div>