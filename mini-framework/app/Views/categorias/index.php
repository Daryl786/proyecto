<html>
<head>
    <title>Lista de Categorías</title>
</head>
<body>
    <h1>Categorías</h1>
    
    <?php if (!empty($categorias)): ?>
        <ul>
            <?php foreach ($categorias as $categoria): ?>
                <li><?php echo $categoria['nombre']; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay categorías disponibles.</p>
    <?php endif; ?>
</body>
</html>
