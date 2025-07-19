<html>
<body>
    
    <div class="main-content">
        <div class="container-servicios">
            <div class="header-servicios">
                <h1><?php echo isset($titulo) ? htmlspecialchars($titulo) : 'Servicios'; ?></h1>
                
                <?php if (isset($categoria)): ?>
                    <div class="categoria-info">
                        <p>Categoría: <strong><?php echo htmlspecialchars($categoria['nombre']); ?></strong></p>
                        <?php if (!empty($categoria['descripcion'])): ?>
                            <p class="categoria-descripcion"><?php echo htmlspecialchars($categoria['descripcion']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            
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
            
            <?php if (!empty($servicios)): ?>
                <div class="servicios-grid">
                    <?php foreach ($servicios as $servicio): ?>
                        <div class="servicio-card">
                            <div class="servicio-header">
                                <h3><?php echo htmlspecialchars($servicio['nombre']); ?></h3>
                                <span class="servicio-precio">$<?php echo number_format($servicio['precio'], 2); ?></span>
                            </div>
                            
                            <div class="servicio-categoria">
                                <span class="categoria-badge"><?php echo htmlspecialchars($servicio['categoria_nombre']); ?></span>
                            </div>
                            
                            <?php if (!empty($servicio['descripcion'])): ?>
                                <p class="servicio-descripcion">
                                    <?php echo htmlspecialchars($servicio['descripcion']); ?>
                                </p>
                            <?php endif; ?>
                            
                            <div class="servicio-meta">
                                <small>Por: <?php echo htmlspecialchars($servicio['usuario_creador']); ?></small>
                                <small>Creado: <?php echo date('d/m/Y', strtotime($servicio['created_at'])); ?></small>
                            </div>
                            
                            <div class="servicio-actions">
                                <a href="/servicios/<?php echo $servicio['id']; ?>" class="btn btn-primary">Ver Detalles</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>No hay servicios disponibles<?php echo isset($categoria) ? ' en esta categoría' : ''; ?>.</p>
                    <a href="/servicios/crear" class="btn btn-success">Crear Primer Servicio</a>
                </div>
            <?php endif; ?>
            
            <div class="action-buttons">
                <a href="/listado" class="btn btn-secondary">Ver Categorías</a>
                <a href="/servicios/crear" class="btn btn-success">Crear Nuevo Servicio</a>
                <?php if (isset($categoria)): ?>
                    <a href="/servicios" class="btn btn-outline">Ver Todos los Servicios</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
