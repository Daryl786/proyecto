<div class="container">
    <h1>Mi Perfil</h1>
    
    <!-- Estadísticas -->
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 3rem;">
        <div class="card text-center">
            
            <h3 style="color: var(--text-secondary);">Servicios Publicados</h3>

            <h3 style="color: var(--color-primary); font-size: 2.5rem; margin-bottom: 0.5rem;">
                <?= $totalServicios ?>
            </h3>

        </div>
        
        <div class="card text-center">
            <h3 style="color: var(--text-secondary);">Tipo de Usuario</h3>
            
            <h3 style="color: var(--color-success); font-size: 2.5rem; margin-bottom: 0.5rem;">
                <?= htmlspecialchars($user['rol'] ?? 'usuario') ?>
            </h3>

        </div>
        
        <div class="card text-center">
            
            <h3 style="color: var(--text-secondary);">Miembro desde</h3>

            <h3 style="color: var(--color-secondary); font-size: 1.2rem; margin-bottom: 0.5rem;">
                <?= date('d/m/Y', strtotime($user['created_at'])) ?>
            </h3>
        </div>
    </div>
    
    <!-- Acciones rápidas -->
    <div class="flex-center mb-4">
        <a href="/post/crear" class="btn btn-success">+ Publicar Nuevo Servicio</a>
        <a href="/post" class="btn btn-secondary">Ver Todos los Servicios</a>
    </div>
    
    <!-- Mis Servicios -->
    <h2 style="margin-bottom: 1.5rem;">Mis Servicios</h2>
    
    <?php if (empty($misServicios)): ?>
        <div class="card text-center" style="padding: 3rem;">
            <p style="font-size: 1.2rem; color: var(--text-tertiary); margin-bottom: 1.5rem;">
                Aún no has publicado ningún servicio
            </p>
            <a href="/post/crear" class="btn btn-primary">Publicar mi primer servicio</a>
        </div>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($misServicios as $servicio): ?>
                <div class="card">
                    <div class="flex-between mb-2">
                        <h3 style="margin: 0;"><?= htmlspecialchars($servicio['title']) ?></h3>
                        <?php if (isset($servicio['categoria_nombre'])): ?>
                            <span class="badge badge-secondary">
                                <?= htmlspecialchars($servicio['categoria_nombre']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                        <?= htmlspecialchars(substr($servicio['content'], 0, 100)) ?>...
                    </p>
                    
                    <div style="font-size: 0.9rem; color: var(--text-tertiary); margin-bottom: 1rem;">
                        Publicado el <?= date('d/m/Y', strtotime($servicio['created_at'])) ?>
                    </div>
                    
                    <div class="flex" style="gap: 0.5rem;">
                        <a href="/post/editar/<?= $servicio['post_id'] ?>" class="btn btn-secondary" style="flex: 1; padding: 0.5rem;">
                            Editar
                        </a>
                        <a href="/post/eliminar/<?= $servicio['post_id'] ?>" 
                           onclick="return confirm('¿Estás seguro de eliminar este servicio?')"
                           class="btn btn-primary" style="flex: 1; padding: 0.5rem;">
                            Eliminar
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
