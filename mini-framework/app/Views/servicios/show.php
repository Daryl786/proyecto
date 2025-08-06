<div class="main-content">
        <div class="container-servicio-detalle">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <div class="servicio-detalle">
                <div class="servicio-header-detalle">
                    <h1><?php echo htmlspecialchars($servicio['nombre']); ?></h1>
                    <div class="precio-principal">$<?php echo number_format($servicio['precio'], 2); ?></div>
                </div>
                
                <div class="servicio-info">
                    <div class="info-item">
                        <strong>Categoría:</strong>
                        <span class="categoria-badge">
                            <a href="/servicios/categoria/<?php echo $servicio['categoria_id']; ?>">
                                <?php echo htmlspecialchars($servicio['categoria_nombre']); ?>
                            </a>
                        </span>
                    </div>
                    
                    <div class="info-item">
                        <strong>Creado por:</strong>
                        <span><?php echo htmlspecialchars($servicio['usuario_creador']); ?></span>
                    </div>
                    
                    <div class="info-item">
                        <strong>Fecha de creación:</strong>
                        <span><?php echo date('d/m/Y H:i', strtotime($servicio['created_at'])); ?></span>
                    </div>
                    
                    <?php if ($servicio['updated_at'] !== $servicio['created_at']): ?>
                        <div class="info-item">
                            <strong>Última actualización:</strong>
                            <span><?php echo date('d/m/Y H:i', strtotime($servicio['updated_at'])); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="servicio-descripcion-completa">
                    <h3>Descripción del Servicio</h3>
                    <div class="descripcion-texto">
                        <?php echo nl2br(htmlspecialchars($servicio['descripcion'])); ?>
                    </div>
                </div>
                
                <div class="servicio-actions-detalle">
                    <a href="/servicios" class="btn btn-secondary">← Volver a Servicios</a>
                    <a href="/servicios/categoria/<?php echo $servicio['categoria_id']; ?>" class="btn btn-outline">
                        Ver más de <?php echo htmlspecialchars($servicio['categoria_nombre']); ?>
                    </a>
                    <a href="/listado" class="btn btn-outline">Ver Categorías</a>
                </div>
            </div>
        </div>
    </div>
