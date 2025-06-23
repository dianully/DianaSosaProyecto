<section class="container terminosyusos-fondo mt-4">
    <div id="alert-container"></div>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="bg-white p-4 rounded shadow">
                <form method="GET" action="<?= base_url('catalogo'); ?>" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="genres" class="form-label">Filtrar por Género</label>
                        <select class="form-select" id="genres" name="genres[]" multiple>
                            <?php foreach ($generos as $genero): ?>
                                <option value="<?= esc($genero['id_generos']) ?>" <?= in_array($genero['id_generos'], $selectedGenres ?? []) ? 'selected' : '' ?>>
                                    <?= esc($genero['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="min_price" class="form-label">Precio Mínimo</label>
                        <input type="number" class="form-control" id="min_price" name="min_price" value="<?= esc($minPrice ?? '') ?>" step="0.01" min="0">
                    </div>
                    <div class="col-md-4">
                        <label for="max_price" class="form-label">Precio Máximo</label>
                        <input type="number" class="form-control" id="max_price" name="max_price" value="<?= esc($maxPrice ?? '') ?>" step="0.01" min="0">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                        <a href="<?= base_url('catalogo'); ?>" class="btn btn-secondary">Limpiar Filtros</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Género</th>
                                <th>Cantidad</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($datos)): ?>
                                <?php foreach ($datos as $dato): ?>
                                    <?php $idProducto = $dato['id_producto']; ?>
                                    <tr>
                                        <td>
                                            <?php if ($dato['url_imagen']): ?>
                                                <img src="<?= base_url('public/assets/img/productos_img/' . esc($dato['url_imagen'])) ?>" alt="<?= esc($dato['nombre']) ?>" style="max-width: 50px; max-height: 50px;">
                                            <?php else: ?>
                                                Sin imagen
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($dato['nombre']) ?></td>
                                        <td>$<?= number_format($dato['precio_venta'], 2, ',', '.') ?></td>
                                        <td><?= esc($generosMap[$dato['id_generos']] ?? 'N/A') ?></td>
                                        <td><?= esc($dato['cantidad']) ?></td>
                                        <td>
                                            <?php if ($dato['cantidad'] > 0): ?>
                                                <form class="d-flex agregar-carrito-form align-items-center gap-1" data-id="<?= esc($dato['id_producto']) ?>" data-nombre="<?= esc($dato['nombre']) ?>">
                                                    <input type="number" name="cantidad" value="1" min="1" max="<?= esc($dato['cantidad']) ?>" class="form-control form-control-sm" style="width: 60px;">
                                                    <button type="submit" class="btn btn-sm btn-primary">Agregar</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">Sin stock</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No hay productos activos para mostrar.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-3">
                    <a href="<?= base_url('carrito'); ?>" class="btn btn-info">Ver Carrito</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const alertContainer = document.getElementById('alert-container');

    document.querySelectorAll('.agregar-carrito-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const cantidad = this.querySelector('input[name="cantidad"]').value;

            fetch('<?= base_url('catalogo/agregar') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    id_producto: id,
                    cantidad: cantidad
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const alertHtml = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Se agregó <strong>${cantidad}x "${nombre}"</strong> al carrito correctamente.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                            </div>
                        `;
                        alertContainer.innerHTML = alertHtml;
                    } else {
                        alert(data.message || 'Error al agregar al carrito.');
                    }
                })
                .catch(error => {
                    alert('Error al conectar con el servidor.');
                    console.error(error);
                });
        });
    });
});
</script>
