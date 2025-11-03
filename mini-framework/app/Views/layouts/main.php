<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Proyecto Utu 2025' ?></title>
    <link rel="stylesheet" href="/css/styles.css" />
</head>
<body>
    <header>
        <?php $this->component('navigation') ?>
    </header>

    <main class="container">
        <?php $this->component('flash-messages') ?>
        <?= $content ?>
    </main>
    
    <script src="/js/user-menu.js"></script>
</body>
</html>
