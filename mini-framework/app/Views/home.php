    <h1><?= $title ?></h1>
    <p>Este es un framework educativo para aprender los conceptos fundamentales de PHP MVC.</p>
    
    <?php if ($auth['check']): ?>
        <p>Bienvenido <?= htmlspecialchars($auth['user']['username']) ?></p>
    <?php else: ?>
        <p>Por favor <a href="/login">inicia sesión</a> para acceder al dashboard.</p>
    <?php endif; ?>

