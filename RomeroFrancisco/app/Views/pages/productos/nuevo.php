<section class="title-section">
    <img src="<?php echo base_url('public/assets/img/terminosyusos.png'); ?>" alt="Logo Game-Box" class="title-image">
</section>

<section class="container terminosyusos-fondo">
    <div class="row justify-content-center">
        <div class="col-md-7 terminosyusos-caja">

            <?php if (isset($validation)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $validation->listErrors() ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo base_url('productos/insertar'); ?>" autocomplete="off" enctype="multipart/form-data">
                <?= csrf_field() ?> 
                <div class="form-group mb-3">
                    <label for="nombre">Nombre</label>
                    <input class="form-control" id="nombre" name="nombre" type="text"
                        value="<?= set_value('nombre') ?>" autofocus required/>
                </div>

                <div class="form-group mb-3">
                    <label for="precio_venta">Precio Venta</label>
                    <input class="form-control" id="precio_venta" name="precio_venta" type="number" step="0.01"
                        value="<?= set_value('precio_venta') ?>" required/>
                </div>

                <div class="form-group mb-3">
                    <label for="cantidad">Cantidad</label>
                    <input class="form-control" id="cantidad" name="cantidad" type="number"
                        value="<?= set_value('cantidad') ?>" required/>
                </div>

                <div class="form-group mb-3">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= set_value('descripcion') ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="url_imagen">Imagen del Producto</label>
                    <input class="form-control" type="file" id="url_imagen" name="url_imagen" accept="image/*">
                    <?php if (isset($validation) && $validation->hasError('url_imagen')): ?>
                        <div class="text-danger">
                            <?= $validation->getError('url_imagen'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="id_generos">Género</label>
                    <select class="form-control" id="id_generos" name="id_generos" required>
                        <option value="">Seleccione un Género</option>
                        <?php foreach($generos as $genero): ?>
                            <option value="<?= esc($genero['id_generos']); ?>"
                                <?= set_select('id_generos', $genero['id_generos']) ?>>
                                <?= esc($genero['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <br> 
                <a href="<?php echo base_url(); ?>/Productos" class="btn btn-primary">Regresar</a> 
                <button type="submit" class="btn btn-success">Guardar</button>
            </form>

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>