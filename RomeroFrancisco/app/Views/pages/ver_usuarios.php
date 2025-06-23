<div class="main-section">
    <div class="users-container">
        <h3 class="h5">Lista de Usuarios</h3>
        <div class="table-responsive">
            <table class="users-table table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Rol</th>
                        <th>Correo</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Teléfono</th>
                        <th>Domicilio</th> <!-- Cambio de id_domicilio a domicilio -->
                        <th>Primer Login</th>
                        <th>Activo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <?php
                        $rolBuilder = \Config\Database::connect()->table('roles');
                        $rol = $rolBuilder->where('id_rol', $usuario['id_rol'])->get()->getRowArray();
                        $rolNombre = $rol ? $rol['nombre'] : 'Desconocido';
                        ?>
                        <tr>
                            <td><?= esc($usuario['id_usuario']) ?></td>
                            <td><?= esc($rolNombre) ?></td>
                            <td><?= esc($usuario['email']) ?></td>
                            <td><?= esc($usuario['nombre'] ?? '-') ?></td>
                            <td><?= esc($usuario['apellido'] ?? '-') ?></td>
                            <td><?= esc($usuario['dni'] ?? '-') ?></td>
                            <td><?= esc($usuario['telefono'] ?? '-') ?></td>
                            <td><?= esc($usuario['domicilio'] ?? '-') ?></td> <!-- Cambio a domicilio -->
                            <td><?= esc($usuario['primer_login'] ? 'Sí' : 'No') ?></td>
                            <td><?= esc($usuario['activo'] ? 'Sí' : 'No') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>