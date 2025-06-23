<section class="terminosyusos-fondo">
    <div class="container my-5">
        <?php foreach ($generos as $genero): ?>
            <div class="mb-5 terminosyusos-caja">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="bg-dark text-white py-2 px-4 rounded"> <?= esc($genero['nombre']) ?> </h3>
                    <a href="<?= base_url('catalogo/genero/' . $genero['id_generos']) ?>" class="btn btn-outline-secondary">Ver más</a>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <?php $productos = $productosPorGenero[$genero['nombre']] ?? []; ?>
                    <?php for ($i = 0; $i < 3; $i++): ?>
                        <?php $producto = $productos[$i] ?? null; ?>
                        <div class="game-card">
                            <?php if ($producto): ?>
                                <a href="<?= base_url('catalogo/detalle/' . $producto['id_producto']) ?>">
                                    <img src="<?= base_url('public/assets/img/productos_img/' . esc($producto['url_imagen'] ?? 'producto_ejemplo.png')) ?>"
                                         class="section-image mb-2"
                                         alt="<?= esc($producto['nombre']) ?>">
                                </a>
                                <p class="section-title mb-0"><?= esc($producto['nombre']) ?></p>
                                <p class="section-price price-text mb-2">$<?= number_format($producto['precio_venta'], 2, ',', '.') ?></p>
                                <?php if ($producto['cantidad'] > 0): ?>
                                    <a href="<?= base_url('catalogo/detalle/' . $producto['id_producto']) ?>" class="btn btn-success btn-sm">Agregar al Carrito</a>
                                <?php else: ?>
                                    <span class="btn btn-secondary btn-sm disabled">Sin stock</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <img src="<?= base_url('public/assets/img/productos_img/producto_ejemplo.png') ?>"
                                     class="section-image mb-2"
                                     alt="Producto de prueba">
                                <p class="section-title mb-0">Producto de prueba</p>
                                <p class="section-price price-text mb-2">$0.00</p>
                                <span class="btn btn-secondary btn-sm disabled">Sin stock</span>
                            <?php endif; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
