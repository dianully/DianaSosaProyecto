<section class="title-section">
    <img src="<?= base_url('public/assets/img/informaciondecontacto.png') ?>" alt="Logo Game-Box" class="title-image">
</section>

<section class="container-fluid main-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 content-box-quienes p-4">

                <?php if (session()->has('message')): ?>
                    <div class="form-success"><?= session('message') ?></div>
                <?php endif; ?>

                <?php if (isset($validation)): ?>
                    <div class="form-error">
                        <ul>
                            <?php foreach ($validation->getErrors() as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="custom-card mb-4 p-3">
                    <div class="card-body-custom">
                        <p>Este espacio está dedicado a responder tus preguntas y aclarar cualquier duda que puedas tener sobre nuestros servicios. Ya sea que quieras saber más sobre cómo podemos ayudarte a alcanzar tus objetivos, necesites asistencia técnica o simplemente quieras explorar nuestras opciones, no dudes en contactarnos. Explica tu consulta de la manera más detallada posible para que podamos brindarte la respuesta más precisa y útil. ¡Esperamos saber de ti!</p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn-consulta toggle-button" type="button" data-bs-toggle="collapse" data-bs-target="#consultaForm" aria-expanded="false" aria-controls="consultaForm">
                            Realizar consulta
                        </button>
                    </div>
                </div>

                <div class="collapse mt-4" id="consultaForm">
                    <form class="form-contacto" action="<?= base_url('contacto/send') ?>" method="post">
                        <?php if (!isset($session_has_id_usuario) || !$session_has_id_usuario): ?>
                            <div class="mb-3">
                                <label class="form-label" for="nombreUsuario">Nombre</label>
                                <input type="text" id="nombreUsuario" name="nombre" class="form-contacto-input" placeholder="Ingresa tu nombre" value="<?= set_value('nombre') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="apellidoUsuario">Apellido</label>
                                <input type="text" id="apellidoUsuario" name="apellido" class="form-contacto-input" placeholder="Ingresa tu apellido" value="<?= set_value('apellido') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="correoElectronico">Correo Electrónico</label>
                                <input type="email" id="correoElectronico" name="email" class="form-contacto-input" placeholder="Ingresa tu correo electrónico" value="<?= set_value('email') ?>" required>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label" for="motivoConsulta">Motivo</label>
                            <select id="motivoConsulta" name="motivoConsulta" class="form-contacto-input" required>
                                <option value="">Seleccione un motivo</option>
                                <option value="Problemas con Pedido" <?= set_select('motivoConsulta', 'Problemas con Pedido') ?>>Problemas con Pedido</option>
                                <option value="Consultas de Productos" <?= set_select('motivoConsulta', 'Consultas de Productos') ?>>Consultas de Productos</option>
                                <option value="Soporte Técnico" <?= set_select('motivoConsulta', 'Soporte Técnico') ?>>Soporte Técnico</option>
                                <option value="Problemas de Pago" <?= set_select('motivoConsulta', 'Problemas de Pago') ?>>Problemas de Pago</option>
                                <option value="Otras Razones" <?= set_select('motivoConsulta', 'Otras Razones') ?>>Otras Razones</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="comentarioAdicional">Comentario Adicional</label>
                            <textarea id="comentarioAdicional" name="comentarioAdicional" class="form-contacto-input" rows="4" placeholder="Detalla tu problema aquí" required><?= set_value('comentarioAdicional') ?></textarea>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn-enviar">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.querySelectorAll('.toggle-button').forEach(button => {
        const targetSelector = button.getAttribute('data-bs-target');
        const collapseElement = document.querySelector(targetSelector);
        const collapse = new bootstrap.Collapse(collapseElement, { toggle: false });

        // cuando se muestra el formulario cambia el texto del boton
        collapseElement.addEventListener('show.bs.collapse', function () {
            button.textContent = 'Cancelar consulta';
        });

        // cuando se esconde el formulario cambia el texto del boton
        collapseElement.addEventListener('hide.bs.collapse', function () {
            button.textContent = 'Realizar consulta';
        });

        // al hacer clic en el boton se muestra o esconde el formulario
        button.addEventListener('click', function () {
            collapse.toggle();
        });
    });
</script>