<nav class="navbar custom-nav">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="<?= base_url(); ?>">
            <img src="<?= base_url('public/assets/img/Logo.png') ?>" alt="Logo Game-Box" class="nav-logo">
        </a>
        <ul class="navbar-nav d-flex flex-row justify-content-end align-items-center">
            <li class="nav-item me-3">
                <a class="nav-link" href="<?= base_url('QuienesSomos'); ?>">Quienes Somos</a>
            </li>
            <li class="nav-item me-3">
                <a class="nav-link" href="<?= base_url('Comercializacion'); ?>">Comercialización</a>
            </li>
            <?php if (!session()->has('id_rol') || (session()->has('id_rol') && session()->get('id_rol') != 1)): ?>
                <li class="nav-item me-3">
                    <a class="nav-link" href="<?= base_url('informacionContacto'); ?>">Información de Contacto</a>
                </li>
            <?php endif; ?>
            <li class="nav-item me-3">
                <a class="nav-link" href="<?= base_url('TerminosYUsos'); ?>">Términos y Usos</a>
            </li>

            <!-- Icono de carrito SOLO para clientes -->
            <?php if ((session()->has('id_usuario')) && (session()->get('id_rol') == 2)): ?>
                <li class="nav-item me-3">
                    <a class="nav-link" href="<?= base_url('carrito') ?>">
                        <i class="fas fa-shopping-cart" style="font-size: 22px;"></i>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Notificaciones (campana) -->
            <?php if (session()->get('id_rol') == 2): ?>
                <?php
                    $db = \Config\Database::connect();
                    $builder = $db->table('consultas');
                    $current_user_id = session()->get('id_usuario');
                    $respuestas_pendientes_cliente = $builder->where('id_usuario', $current_user_id)
                        ->where('Respondida', 1)
                        ->where('vista_por_cliente', 0)
                        ->countAllResults();
                ?>
                <li class="nav-item me-3 position-relative">
                    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell" style="font-size: 24px;"></i>
                        <?php if ($respuestas_pendientes_cliente > 0): ?>
                            <span class="badge bg-danger" style="position: absolute; top: -5px; right: -5px;"><?= $respuestas_pendientes_cliente ?></span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end custom-dropdown" aria-labelledby="notificationDropdown">
                        <?php
                            $all_consultas = $builder->select('id_consulta, motivoConsulta, Respuesta, fecha, Respondida')
                                ->where('id_usuario', $current_user_id)
                                ->orderBy('fecha', 'DESC')
                                ->get()
                                ->getResultArray();
                            if (!empty($all_consultas)):
                                foreach ($all_consultas as $consulta): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('contacto/ver_mi_consulta_respondida/' . $consulta['id_consulta']) ?>">
                                            <strong>Consulta:</strong> <?= esc($consulta['motivoConsulta']) ?><br>
                                            <?php if ($consulta['Respondida'] == 0): ?>
                                                "Aún no hay respuesta" (<?= esc($consulta['fecha']) ?>)
                                            <?php else: ?>
                                                "<?= substr(esc($consulta['Respuesta']), 0, 50) . (strlen(esc($consulta['Respuesta'])) > 50 ? '...' : '') ?>" (<?= esc($consulta['fecha']) ?>)
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endforeach;
                            else: ?>
                                <li><a class="dropdown-item" href="#">No has realizado consultas.</a></li>
                            <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <!-- Icono de usuario -->
            <?php if (session()->has('id_rol')): ?>
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle user-icon-container" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle" style="font-size: 24px;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end custom-dropdown" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('editar_perfil'); ?>">Editar Perfil</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('cerrar_sesion'); ?>">Cerrar Sesión</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <!-- Botones para no logueado -->
                <li class="nav-item me-3">
                    <a class="btn" href="<?= base_url('ingresar'); ?>" style="background-color: #6D8EAD; color: white; border-radius: 10px; border: none; padding: 8px 15px;">Iniciar Sesión</a>
                </li>
                <li class="nav-item">
                    <a class="btn" href="<?= base_url('registrar'); ?>" style="background-color: #6D8EAD; color: white; border-radius: 10px; border: none; padding: 8px 15px;">Registrarse</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<!-- Asegurate que esta línea esté en tu <head> o layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
