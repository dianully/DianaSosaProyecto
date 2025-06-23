<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnalix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Encabezado -->
    <header class="py-2">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center">
                <!-- Logo al lado de la barra de búsqueda -->
                <a class="navbar-brand me-3" href="<?php echo base_url(); ?>">
                    <img src="https://via.placeholder.com/100x40?text=Logo" alt="Logo">
                </a>
                <form class="d-flex w-75"> <!-- Cambié max-width por w-75 -->
                    <input class="form-control me-2" type="search" placeholder="Buscar" style="width: 100%;">
                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </header>

    <!-- Menú de navegación actualizado -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>/QuienesSomos">Quienes Somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Servicios</a><!-- Mantener si no hay página -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Usuario</a><!-- Mantener si no hay página -->
                    </li>
                </ul>
            </div>
        </div>
    </nav>
