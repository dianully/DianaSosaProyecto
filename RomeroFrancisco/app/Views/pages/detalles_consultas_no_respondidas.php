<div class="main-section">
    <div class="register-container">
        <h3 class="h5">Detalles de Consulta No Respondida</h3>
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
            </table>

            <div class="mt-4">
                <h4>Responder Consulta</h4>
                <form id="responseForm" onsubmit="sendResponse(event, <?= $consulta['id_consulta'] ?>)">
                    <div class="mb-3">
                        <textarea class="form-control" name="respuesta" id="respuesta" rows="3" placeholder="Escribe tu respuesta aquí..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Enviar Respuesta</button>
                </form>
                <div id="responseMessage" class="mt-3"></div>
            </div>
        <?php else: ?>
            <p>No se encontró la consulta.</p>
        <?php endif; ?>
    </div>

    <script>
        function sendResponse(event, id) {
            event.preventDefault();
            const respuesta = document.getElementById('respuesta').value;
            if (!respuesta) {
                alert('Por favor, escribe una respuesta antes de enviar.');
                return;
            }

            fetch(`<?= base_url('contacto/sendResponse/') ?>${id}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'respuesta=' + encodeURIComponent(respuesta)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la solicitud');
                }
                return response.json();
            })
            .then(data => {
                const messageDiv = document.getElementById('responseMessage');
                messageDiv.innerHTML = `<div class="alert ${data.message.includes('éxito') ? 'alert-success' : 'alert-danger'}">${data.message}</div>`;
                if (data.message.includes('éxito')) {
                    setTimeout(() => {
                        window.location.href = '<?= base_url('ver_consultas?filter=respondidas') ?>';
                    }, 2000);
                }
            })
            .catch(error => {
                document.getElementById('responseMessage').innerHTML = '<div class="alert alert-danger">Error al enviar la respuesta. Intenta de nuevo.</div>';
            });
        }
    </script>
</div>