<section class="title-section">
    <img src="<?php echo base_url('public/assets/img/terminosyusos.png'); ?>" alt="Logo Game-Box" class="title-image">
</section>

<section class="container terminosyusos-fondo">
    <div class="row justify-content-center">
        <div class="col-md-10 terminosyusos-caja">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <p>
                    <a href="<?php echo base_url(); ?>/productos/nuevo" class="btn btn-info">Agregar Producto</a>
                    <a href="<?php echo base_url(); ?>/productos/eliminados" class="btn btn-warning">Productos Eliminados</a>
                </p>
                <form method="GET" action="<?php echo base_url('Productos'); ?>" class="row g-3">
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
                        <input type="number" class="form-control" id="min_price" name="min_price" value="<?= $minPrice ?? '' ?>" step="0.01" min="0">
                    </div>
                    <div class="col-md-4">
                        <label for="max_price" class="form-label">Precio Máximo</label>
                        <input type="number" class="form-control" id="max_price" name="max_price" value="<?= $maxPrice ?? '' ?>" step="0.01" min="0">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                        <a href="<?php echo base_url('Productos'); ?>" class="btn btn-secondary">Limpiar Filtros</a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Precio Venta</th>
                            <th>Género</th>
                            <th>Cantidad</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($datos as $dato){ ?>
                            <tr>
                                <td>
                                    <?php if ($dato['url_imagen']): ?>
                                        <img src="<?php echo base_url('public/assets/img/productos_img/' . esc($dato['url_imagen'])); ?>" alt="<?php echo esc($dato['nombre']); ?>" style="max-width: 50px; max-height: 50px;">
                                    <?php else: ?>
                                        Sin imagen
                                    <?php endif; ?>
                                </td>
                                <td><?php echo esc($dato['nombre']); ?></td>
                                <td>$<?php echo number_format(esc($dato['precio_venta']), 2, ',', '.'); ?></td>
                                <td><?php echo esc($generosMap[$dato['id_generos']] ?? 'N/A'); ?></td>
                                <td><?php echo esc($dato['cantidad']); ?></td>
                                <td><a href="<?php echo base_url('productos/editar/' . esc($dato['id_producto'])); ?>" class="btn btn-warning btn-sm">Editar</a></td>
                                <td>
                                    <form action="<?php echo base_url('productos/eliminar/' . esc($dato['id_producto'])); ?>" method="post" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if (empty($datos)): ?>
                            <tr>
                                <td colspan="7" class="text-center">No hay productos activos para mostrar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>