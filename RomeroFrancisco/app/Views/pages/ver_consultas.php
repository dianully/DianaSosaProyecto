<div class="main-section">
    <div class="register-container">
        <h3 class="h5">Ver Consultas</h3>
        <?php if (session()->has('message')): ?>
            <div class="form-success"><?= session('message') ?></div>
        <?php endif; ?>

        <div class="btn-group mb-3">
            <a href="<?= base_url('ver_consultas?filter=por_responder') ?>" class="btn btn-primary <?= $filter == 0 ? 'active' : '' ?>">Por Responder (<?= $por_responder ?>)</a>
            <a href="<?= base_url('ver_consultas?filter=respondidas') ?>" class="btn btn-secondary <?= $filter == 1 ? 'active' : '' ?>">Respondidas (<?= $respondidas ?>)</a>
        </div>

        <?php if (!empty($consultas)): ?>
            <div class="table-responsive">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario (ID)</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Motivo</th>
                            <th>Fecha</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consultas as $consulta): ?>
                            <tr>
                                <td><?= esc($consulta['id_consulta']) ?></td>
                                <td>
                                    <?php
                                    echo !empty($consulta['id_usuario']) ? esc($consulta['id_usuario']) : 'No tiene';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo !empty($consulta['id_usuario']) ? esc($consulta['user_nombre']) : esc($consulta['consulta_nombre']);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo !empty($consulta['id_usuario']) ? esc($consulta['user_apellido']) : esc($consulta['consulta_apellido']);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo !empty($consulta['id_usuario']) ? esc($consulta['user_email']) : esc($consulta['consulta_email']);
                                    ?>
                                </td>
                                <td><?= esc($consulta['motivoConsulta']) ?></td>
                                <td><?= esc($consulta['fecha']) ?></td>
                                <td>
                                    <?php if ($consulta['Respondida'] == 0): ?>
                                        <a href="<?= base_url('contacto/detalles_no_respondidas/' . $consulta['id_consulta']) ?>" class="btn btn-info btn-sm">Detalles</a>
                                    <?php else: ?>
                                        <a href="<?= base_url('contacto/detalles_respondidas/' . $consulta['id_consulta']) ?>" class="btn btn-info btn-sm">Detalles</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No hay consultas <?= $filter == 1 ? 'respondidas' : 'por responder' ?>.</p>
        <?php endif; ?>
    </div>
</div>