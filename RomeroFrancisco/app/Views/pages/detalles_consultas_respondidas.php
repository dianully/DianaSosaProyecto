<div class="main-section">
    <div class="register-container">
        <h3 class="h5">Detalles de Consulta Respondida</h3>
        <?php if (session()->has('message')): ?>
            <div class="form-success"><?= session('message') ?></div>
        <?php endif; ?>

        <?php if (isset($consulta)): ?>
            <table class="users-table">
                <tr>
                    <th>ID</th>
                    <td><?= esc($consulta['id_consulta']) ?></td>
                </tr>
                <tr>
                    <th>Usuario (ID)</th> <td>
                        <?= !empty($consulta['id_usuario']) ? esc($consulta['id_usuario']) : 'No tiene'; ?>
                    </td>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <td>
                        <?php
                        // Si la consulta tiene un id_usuario, muestra el nombre del usuario registrado.
                        // De lo contrario, muestra el nombre guardado directamente en la tabla consultas.
                        echo !empty($consulta['id_usuario']) ? esc($consulta['user_nombre']) : esc($consulta['nombre']);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Apellido</th>
                    <td>
                        <?php
                        // Similar al nombre.
                        echo !empty($consulta['id_usuario']) ? esc($consulta['user_apellido']) : esc($consulta['apellido']);
                        ?>
                    </td>
                </tr>
                 <tr>
                    <th>Email</th>
                    <td>
                        <?php
                        // Y también el email.
                        echo !empty($consulta['id_usuario']) ? esc($consulta['user_email']) : esc($consulta['email']);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Motivo</th>
                    <td><?= esc($consulta['motivoConsulta']) ?></td>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <td><?= esc($consulta['fecha']) ?></td>
                </tr>
                <tr>
                    <th>Comentario</th>
                    <td><?= esc($consulta['comentarioAdicional']) ?></td>
                </tr>
                <tr>
                    <th>Respuesta</th>
                    <td><?= esc($consulta['Respuesta']) ?></td>
                </tr>
                <?php if (!empty($consulta['id_usuario_responde'])): ?>
                <tr>
                    <th>Respondida por</th>
                    <td>
                        <?= esc($consulta['admin_nombre']) ?> <?= esc($consulta['admin_apellido']) ?> (ID: <?= esc($consulta['admin_id']) ?>)
                    </td>
                </tr>
                <?php endif; ?>
            </table>
        <?php else: ?>
            <p>No se encontró la consulta.</p>
        <?php endif; ?>
    </div>
</div>