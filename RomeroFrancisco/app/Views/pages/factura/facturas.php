<div class="container my-5">
    <h2 class="mb-4 text-center">Detalle de la Factura</h2>

    <?php if (empty($detalles)): ?>
        <div class="alert alert-warning text-center">No se encontró la información de la compra.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php $total = 0; ?>
                <?php foreach ($detalles as $detalle): ?>
                    <?php $subtotal = $detalle['cantidad'] * $detalle['precio']; ?>
                    <tr>
                        <td><?= esc($detalle['producto_nombre']) ?></td>
                        <td><?= esc($detalle['cantidad']) ?></td>
                        <td>$<?= number_format($detalle['precio'], 2, ',', '.') ?></td>
                        <td>$<?= number_format($subtotal, 2, ',', '.') ?></td>
                    </tr>
                    <?php $total += $subtotal; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-secondary text-end">
                    <th colspan="3">Total:</th>
                    <th>$<?= number_format($total, 2, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>
</div>
