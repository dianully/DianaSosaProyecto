<?php /** @var array $producto */ ?>
<section class="container my-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-10 p-4 rounded" style="background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
            <div class="row">
                <!-- Imagen del producto -->
                <div class="col-md-5 text-center">
                    <?php if ($producto['url_imagen']) : ?>
                        <img src="<?= base_url('public/assets/img/productos_img/' . $producto['url_imagen']); ?>" alt="<?= esc($producto['nombre']) ?>" class="img-fluid rounded">
                    <?php else : ?>
                        <img src="<?= base_url('public/assets/img/no-imagen.png'); ?>" alt="Sin imagen" class="img-fluid rounded">
                    <?php endif; ?>
                </div>

                <!-- Detalles del producto -->
                <div class="col-md-7">
                    <h2 class="fw-bold mb-3"><?= esc($producto['nombre']) ?></h2>
                    <p><strong>Precio:</strong> <span class="text-success fw-bold">$<?= number_format($producto['precio_venta'], 2, ',', '.') ?></span></p>
                    <p><strong>Stock disponible:</strong> <?= esc($producto['cantidad']) ?></p>
                    <p><strong>Descripción:</strong><br> <?= esc($producto['descripcion']) ?></p>

                    <!-- Mensajes flash -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger mt-3"> <?= session()->getFlashdata('error') ?> </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success mt-3"> <?= session()->getFlashdata('success') ?> </div>
                    <?php endif; ?>

                    <!-- Formulario para agregar al carrito -->
                    <?php if ($producto['cantidad'] > 0): ?>
                        <form action="<?= base_url('catalogo/agregar') ?>" method="post" class="mt-4">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_producto" value="<?= esc($producto['id_producto']) ?>">
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number"
                                    id="cantidad"
                                    name="cantidad"
                                    class="form-control"
                                    min="1"
                                    max="<?= esc($producto['cantidad']) ?>"
                                    value="1"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-success">Agregar al Carrito</button>
                        </form>

                        <div id="mensajeRespuesta" class="mt-3"></div>
                    <?php else: ?>
                        <p class="alert alert-danger mt-4">Sin stock disponible</p>
                    <?php endif; ?>

                    <div class="mt-4">
                        <a href="<?= base_url('catalogo') ?>" class="btn btn-secondary">Volver al Catálogo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const form = document.getElementById('formAgregarCarrito');
    const mensaje = document.getElementById('mensajeRespuesta');

    form?.addEventListener('submit', async function(e) {
        e.preventDefault();
        mensaje.innerHTML = '';

        const data = {
            id_producto: form.id_producto.value,
            cantidad: form.cantidad.value
        };

        const response = await fetch("<?= base_url('catalogo/agregar') ?>", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "<?= csrf_hash() ?>"
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        if (result.success) {
            mensaje.innerHTML = '<div class="alert alert-success">Producto agregado al carrito exitosamente.</div>';
        } else {
            mensaje.innerHTML = '<div class="alert alert-danger">' + result.message + '</div>';
        }
    });
</script>
