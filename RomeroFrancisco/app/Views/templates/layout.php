<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Game-Box') ?></title>
    <link rel="icon" href="<?= base_url('public/assets/img/logo.png') ?>" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-bootstrap.css">

    <link href="<?= base_url('public/assets/css/bootstrap.min.css') ?>" rel="stylesheet">

    <link href="<?= base_url('public/assets/css/mycustom.css') ?>" rel="stylesheet">
</head>
<body>
    <?= view('components/header') ?>

    <main>
        <!-- Comentar o eliminar este bloque para evitar que los mensajes aparezcan arriba -->
        <?php /* if (session()->has('success')): ?>
            <?php
                $successMessage = session('success');
                log_message('debug', 'Flashdata success content: ' . $successMessage);
            ?>
            <div class="alert alert-success alert-dismissible fade show mx-auto mt-3" role="alert" style="max-width: 500px;">
                <?= $successMessage ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->has('error')): ?>
            <?php
                $errorMessage = session('error');
                log_message('debug', 'Flashdata error content: ' . $errorMessage);
            ?>
            <div class="alert alert-danger alert-dismissible fade show mx-auto mt-3" role="alert" style="max-width: 500px;">
                <?= esc($errorMessage) ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->has('info')): ?>
            <?php
                $infoMessage = session('info');
                log_message('debug', 'Flashdata info content: ' . $infoMessage);
            ?>
            <div class="alert alert-info alert-dismissible fade show mx-auto mt-3" role="alert" style="max-width: 500px;">
                <?= esc($infoMessage) ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; */ ?>

        <?= $content ?? '' ?>
    </main>

    <?= view('components/footer') ?>

    <script src="<?= base_url('public/assets/js/bootstrap.bundle.min.js') ?>"></script>

</body>
</html>