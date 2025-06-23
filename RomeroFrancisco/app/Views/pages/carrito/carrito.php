<section class="title-section">
    <img src="<?= base_url('public/assets/img/terminosyusos.png'); ?>" alt="Logo Game-Box" class="title-image">
</section>

<section class="container terminosyusos-fondo">
    <div class="row justify-content-center">
        <div class="col-md-10 terminosyusos-caja">
            <h2>Carrito de Compras</h2>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('factura_id')): ?>
                <div class="text-center my-3">
                    <a href="<?= base_url('factura/ver/' . session()->getFlashdata('factura_id')) ?>" class="btn btn-warning">
                        Ver Factura
                    </a>
                </div>
            <?php endif; ?>


            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if (empty($items)): ?>
                <p class="text-center">Tu carrito está vacío.</p>
                <div class="text-end">
                    <a href="<?= base_url('catalogo'); ?>" class="btn btn-primary">Volver al Catálogo</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td>
                                        <?php if ($item['url_imagen']): ?>
                                            <img src="<?= base_url('public/assets/img/productos_img/' . esc($item['url_imagen'])) ?>" alt="<?= esc($item['nombre']) ?>" style="max-width: 50px; max-height: 50px;">
                                        <?php else: ?>
                                            Sin imagen
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['nombre']) ?></td>
                                    <td>$<?= number_format($item['precio_venta'], 2, ',', '.') ?></td>
                                    <td><?= esc($item['cantidad']) ?></td>
                                    <td>$<?= number_format($item['precio_venta'] * $item['cantidad'], 2, ',', '.') ?></td>
                                    <td>
                                        <a href="<?= base_url('carrito/eliminar/' . esc($item['id_productos'])) ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end"><strong>Total:</strong></td>
                                <td>$<?= number_format($total, 2, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="text-end mt-3">
                    <a href="<?= base_url('catalogo/catalogo_inicio'); ?>" class="btn btn-secondary">Seguir Comprando</a>
                    <a href="<?= base_url('carrito/comprar'); ?>" class="btn btn-success">Proceder al Pago</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
