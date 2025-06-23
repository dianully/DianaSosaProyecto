<section class="title-section">
    <img src="public/assets/img/terminosyusos.png" alt="Logo Game-Box" class="title-image">
</section>

<section class="container terminosyusos-fondo">
    <div class="row justify-content-center">
        <div class="col-md-7 terminosyusos-caja">

            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/Generos" class="btn btn-warning">Atras</a>
                </p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <tr>
                           <?php foreach($datos as $dato){ ?>
                                <tr>
                                    <td><?php echo $dato['nombre']; ?></td>
                                    <td><a href="<?php echo base_url(). '/generos/reingresar/'. $dato['id_generos']; ?>" class="btn btn-warning">Reingresar</a></td>
                                    
                                </tr>    

                           <?php } ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>