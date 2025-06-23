<section class="title-section">
    <img src="<?php echo base_url('public/assets/img/terminosyusos.png'); ?>" alt="Logo Game-Box" class="title-image">
</section>

<section class="container terminosyusos-fondo">
    <div class="row justify-content-center">
        <div class="col-md-10 terminosyusos-caja">
            <h2 class="text-center mb-4">¡Compra Realizada con Éxito!</h2>

            <?php if (session()->has('message')): ?>
                <div class="alert alert-success mt-3"><?php echo session()->getFlashdata('message'); ?></div>
            <?php endif; ?>
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger mt-3"><?php echo session()->getFlashdata('error'); ?></div>
            <?php endif; ?>

            <?php if (isset($factura)): ?>
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        Detalles de la Factura #<?php echo esc($factura['id_factura']); ?>
                    </div>
                    <div class="card-body">
                        <p><strong>Fecha de Compra:</strong> <?php echo esc($factura['fecha_compra']); ?></p>
                        <p><strong>Total de la Compra:</strong> $<?php echo number_format(esc($factura['total']), 2, ',', '.'); ?></p>
                        <p><strong>Estado:</strong> <?php echo esc(ucfirst($factura['estado'])); ?></p>
                        <hr>
                        <h4>Productos Comprados:</h4>
                        <?php if (!empty($detalles)): ?>
                            <ul class="list-group">
                                <?php foreach ($detalles as $detalle): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><?php echo esc($detalle['nombre_producto']); ?> (x<?php echo esc($detalle['cantidad']); ?>)</span>
                                        <span>$<?php echo number_format(esc($detalle['subtotal']), 2, ',', '.'); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No se encontraron detalles para esta factura.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-center">No se pudo encontrar la información de la factura.</p>
            <?php endif; ?>

            <div class="text-center mt-4">
                <a href="<?php echo base_url('catalogo'); ?>" class="btn btn-primary">Volver al Catálogo</a>
                <a href="<?php echo base_url('mis-compras'); ?>" class="btn btn-info">Ver Mis Compras</a> </div>
        </div>
    </div>
</section>