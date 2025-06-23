<section class="title-section">
    <img src="<?= base_url('public/assets/img/terminosyusos.png'); ?>" alt="Logo Game-Box" class="title-image">
</section>

<section class="container terminosyusos-fondo">
    <div class="row justify-content-center">
        <div class="col-md-10 terminosyusos-caja">
            <h3 class="mb-4 text-center">Género: <?= esc($genero['nombre']) ?></h3>

            <div class="d-flex flex-wrap justify-content-between">
                <?php if (empty($productos)): ?>
                    <div class="alert alert-warning text-center w-100">No hay productos en este género.</div>
                <?php else: ?>
                    <?php foreach ($productos as $producto): ?>
                        <div class="game-card">
                            <a href="<?= base_url('catalogo/detalle/' . $producto['id_producto']) ?>" style="text-decoration: none; color: inherit;">
                                <img src="<?= base_url('public/assets/img/productos_img/' . esc($producto['url_imagen'])) ?>" class="img-fluid section-image mb-2" alt="<?= esc($producto['nombre']) ?>">
                                <h6 class="section-title"><?= esc($producto['nombre']) ?></h6>
                                <p class="section-price price-text">$<?= number_format($producto['precio_venta'], 2, ',', '.') ?></p>
                                <?php if ($producto['cantidad'] > 0): ?>
                                    <span class="badge bg-success">Disponible</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Sin stock</span>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="text-center mt-4">
                <a href="<?= base_url('/catalogo') ?>" class="btn btn-secondary">Volver al inicio</a>
            </div>
        </div>
    </div>
</section>
