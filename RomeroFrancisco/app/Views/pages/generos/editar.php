<section class="title-section">
    <img src="<?php echo base_url('public/assets/img/terminosyusos.png'); ?>" alt="Logo Game-Box" class="title-image">
</section>

<section class="container terminosyusos-fondo">
    <div class="row justify-content-center">
        <div class="col-md-7 terminosyusos-caja">

            <form method="POST" action="<?php echo base_url('generos/actualizar'); ?>" autocomplete="off"> 
            
                <input type="hidden" name="id_generos" value="<?php echo $datos['id_generos']; ?>">
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" 
                                value="<?php echo $datos['nombre'] ?? ''; ?>" autofocus required/>
                        </div>
                    </div>
                </div>

                <br> 
                <a href="<?php echo base_url('generos'); ?>" class="btn btn-primary">Regresar</a> 
                <button type="submit" class="btn btn-success">Actualizar</button> 
                </form>

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>