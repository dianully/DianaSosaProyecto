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
            
        <div>
            <p>
                <a href="<?php echo base_url(); ?>/Productos" class="btn btn-warning">Atrás</a>
            </p>
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
                            <td>
                                <form action="<?php echo base_url('productos/reingresar/' . esc($dato['id_producto'])); ?>" method="post" onsubmit="return confirm('¿Estás seguro de que quieres reingresar este producto?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-warning btn-sm">Reingresar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if (empty($datos)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay productos eliminados para mostrar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>