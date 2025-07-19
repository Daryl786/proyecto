
<html>
<body>

    <div class="main-content">
        <div class="container-categorias">
            <h1>Categorías de Servicios</h1>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($categorias)): ?>
                <div class="categorias-grid">
                    <?php foreach ($categorias as $categoria): ?>
                        <div class="categoria-card">
                            <div class="categoria-header">
                                <h3><?php echo htmlspecialchars($categoria['nombre']); ?></h3>
                                <span class="servicios-count"><?php echo $categoria['total_servicios']; ?> servicios</span>
                            </div>
                            
                            <?php if (!empty($categoria['descripcion'])): ?>
                                <p class="categoria-descripcion">
                                    <?php echo htmlspecialchars($categoria['descripcion']); ?>
                                </p>
                            <?php endif; ?>
                            
                            <div class="categoria-actions">
                                <a href="/servicios/categoria/<?php echo $categoria['id']; ?>" class="btn btn-primary">
                                    Ver Servicios
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>No hay categorías disponibles.</p>
                </div>
            <?php endif; ?>
            
            <div class="action-buttons">
                <a href="/servicios" class="btn btn-secondary">Ver Todos los Servicios</a>
                <a href="/servicios/crear" class="btn btn-success">Crear Nuevo Servicio</a>
            </div>
        </div>
    </div>
</body>
</html>
