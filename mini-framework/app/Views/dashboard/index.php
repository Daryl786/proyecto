<div class="container">
    <h1>Mi Perfil</h1>
    
    <!-- Estadísticas -->
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 3rem;">
        <div class="card text-center">
            <h3 style="color: var(--text-secondary);">Servicios Contratados</h3>
            <h3 style="color: var(--color-success); font-size: 2.5rem; margin-bottom: 0.5rem;">
                <?= $totalContrataciones ?>
            </h3>
        </div>
        
        <div class="card text-center">
            <h3 style="color: var(--text-secondary);">Contrataciones Activas</h3>
            <h3 style="color: #ffa500; font-size: 2.5rem; margin-bottom: 0.5rem;">
                <?= $contratacionesActivas ?>
            </h3>
        </div>
        
        <div class="card text-center">
            <h3 style="color: var(--text-secondary);">Servicios Publicados</h3>
            <h3 style="color: var(--color-primary); font-size: 2.5rem; margin-bottom: 0.5rem;">
                <?= $totalServicios ?>
            </h3>
        </div>
        
        <div class="card text-center">
            <h3 style="color: var(--text-secondary);">Tipo de Usuario</h3>
            <h3 style="color: var(--color-secondary); font-size: 1.5rem; margin-bottom: 0.5rem;">
                <?= htmlspecialchars($user['rol'] ?? 'usuario') ?>
            </h3>
        </div>
    </div>
    
    <!-- Tabs para organizar contenido -->
    <div style="margin-bottom: 2rem; border-bottom: 2px solid var(--border-color);">
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <button onclick="mostrarTab('contrataciones')" id="tab-contrataciones" class="tab-button active">
                Servicios Contratados
            </button>
            <button onclick="mostrarTab('misServicios')" id="tab-misServicios" class="tab-button">
                Servicios Publicados
            </button>
            <?php if (!empty($serviciosContratados)): ?>
            <button onclick="mostrarTab('ventas')" id="tab-ventas" class="tab-button">
                Mis Ventas
            </button>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Tab: Servicios Contratados (PRIMERO) -->
    <div id="content-contrataciones" class="tab-content active">
        <h2 style="margin-bottom: 1.5rem;">Servicios Contratados</h2>
        
        <?php if (empty($misContrataciones)): ?>
            <div class="card text-center" style="padding: 3rem;">
                <p style="font-size: 1.2rem; color: var(--text-tertiary); margin-bottom: 1.5rem;">
                    No has contratado ningún servicio aún
                </p>
                <a href="/post" class="btn btn-primary">Explorar Servicios</a>
            </div>
        <?php else: ?>
            <div class="grid">
                <?php foreach ($misContrataciones as $contratacion): ?>
                    <div class="card">
                        <div class="flex-between mb-2">
                            <h3 style="margin: 0;"><?= htmlspecialchars($contratacion['title']) ?></h3>
                            <?php 
                            $estadoClass = $contratacion['estado'] === 'activo' ? 'badge-success' : 
                                          ($contratacion['estado'] === 'finalizado' ? 'badge-secondary' : 'badge-danger');
                            ?>
                            <span class="badge <?= $estadoClass ?>">
                                <?= ucfirst($contratacion['estado']) ?>
                            </span>
                        </div>
                        
                        <?php if (isset($contratacion['categoria_nombre'])): ?>
                            <div style="margin-bottom: 0.5rem;">
                                <span class="badge badge-secondary">
                                    <?= htmlspecialchars($contratacion['categoria_nombre']) ?>
                                </span>
                            </div>
                        <?php endif; ?>
                        
                        <p style="color: var(--text-secondary); margin-bottom: 1rem; font-size: 0.95rem;">
                            <?= htmlspecialchars(substr($contratacion['content'], 0, 80)) ?>...
                        </p>
                        
                        <div style="background-color: var(--bg-tertiary); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                <span style="font-weight: 600; color: var(--text-primary);">💼 Proveedor:</span>
                                <span style="color: var(--text-secondary);">
                                    <?= htmlspecialchars($contratacion['proveedor_username'] . ' ' . ($contratacion['proveedor_apellido'] ?? '')) ?>
                                </span>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                <span style="font-weight: 600; color: var(--text-primary);">💰 Precio:</span>
                                <span style="color: var(--color-success); font-weight: 700;">
                                    $<?= number_format($contratacion['precio'], 2) ?> UYU
                                </span>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                <span style="font-weight: 600; color: var(--text-primary);">📅 Contratado:</span>
                                <span style="color: var(--text-secondary);">
                                    <?= date('d/m/Y', strtotime($contratacion['fecha_contratacion'])) ?>
                                </span>
                            </div>
                            
                            <?php if ($contratacion['estado'] === 'activo'): ?>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                                    <span style="font-weight: 600; color: var(--text-primary);">⏱️ Tiempo restante:</span>
                                    <span style="font-size: 1.2rem; font-weight: 700; color: <?= $contratacion['dias_restantes'] < 7 ? '#dc3545' : '#ffa500' ?>;">
                                        <?php
                                        $diasRestantes = $contratacion['dias_restantes'];
                                        if ($diasRestantes > 0) {
                                            echo $diasRestantes . ($diasRestantes == 1 ? ' día' : ' días');
                                        } else if ($diasRestantes == 0) {
                                            echo 'Hoy finaliza';
                                        } else {
                                            echo 'Vencido';
                                        }
                                        ?>
                                    </span>
                                </div>
                            <?php else: ?>
                                <div style="text-align: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color); color: var(--text-tertiary);">
                                    Finalizado el <?= date('d/m/Y', strtotime($contratacion['fecha_finalizacion'])) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <a href="/post/ver/<?= $contratacion['post_id'] ?>" class="btn btn-secondary" style="width: 100%;">
                            Ver Detalles del Servicio
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Tab: Mis Servicios Publicados (SEGUNDO) -->
    <div id="content-misServicios" class="tab-content" style="display: none;">
        <h2 style="margin-bottom: 1.5rem;">Servicios Publicados</h2>
        
        <div class="flex-center mb-4">
            <a href="/post/crear" class="btn btn-success">+ Publicar Nuevo Servicio</a>
            <a href="/post" class="btn btn-secondary">Ver Todos los Servicios</a>
        </div>
        
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
                            <a href="/post/ver/<?= $servicio['post_id'] ?>" class="btn btn-secondary" style="flex: 1; padding: 0.5rem;">
                                Ver
                            </a>
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
    
    <!-- Tab: Mis Ventas (servicios que otros han contratado) -->
    <?php if (!empty($serviciosContratados)): ?>
    <div id="content-ventas" class="tab-content" style="display: none;">
        <h2 style="margin-bottom: 1.5rem;">Mis Ventas (Servicios Contratados por Otros)</h2>
        
        <div class="grid">
            <?php foreach ($serviciosContratados as $venta): ?>
                <div class="card">
                    <div class="flex-between mb-2">
                        <h3 style="margin: 0;"><?= htmlspecialchars($venta['title']) ?></h3>
                        <?php 
                        $estadoClass = $venta['estado'] === 'activo' ? 'badge-success' : 
                                      ($venta['estado'] === 'finalizado' ? 'badge-secondary' : 'badge-danger');
                        ?>
                        <span class="badge <?= $estadoClass ?>">
                            <?= ucfirst($venta['estado']) ?>
                        </span>
                    </div>
                    
                    <div style="background-color: var(--bg-tertiary); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="font-weight: 600; color: var(--text-primary);">👤 Cliente:</span>
                            <span style="color: var(--text-secondary);">
                                <?= htmlspecialchars($venta['cliente_username'] . ' ' . ($venta['cliente_apellido'] ?? '')) ?>
                            </span>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="font-weight: 600; color: var(--text-primary);">📧 Email:</span>
                            <span style="color: var(--text-secondary); font-size: 0.9rem;">
                                <?= htmlspecialchars($venta['cliente_email']) ?>
                            </span>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="font-weight: 600; color: var(--text-primary);">📅 Contratado:</span>
                            <span style="color: var(--text-secondary);">
                                <?= date('d/m/Y', strtotime($venta['fecha_contratacion'])) ?>
                            </span>
                        </div>
                        
                        <?php if ($venta['estado'] === 'activo'): ?>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                                <span style="font-weight: 600; color: var(--text-primary);">⏱️ Días restantes:</span>
                                <span style="font-size: 1.2rem; font-weight: 700; color: <?= $venta['dias_restantes'] < 7 ? '#dc3545' : '#28a745' ?>;">
                                    <?php
                                    $diasRestantes = $venta['dias_restantes'];
                                    if ($diasRestantes > 0) {
                                        echo $diasRestantes . ($diasRestantes == 1 ? ' día' : ' días');
                                    } else if ($diasRestantes == 0) {
                                        echo 'Hoy finaliza';
                                    } else {
                                        echo 'Vencido';
                                    }
                                    ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.tab-button {
    padding: 1rem 1.5rem;
    background-color: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    color: var(--text-secondary);
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
}

.tab-button:hover {
    color: var(--color-primary);
}

.tab-button.active {
    color: var(--color-primary);
    border-bottom-color: var(--color-primary);
}

.tab-content {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
function mostrarTab(tabName) {
    // Ocultar todos los contenidos
    document.querySelectorAll('.tab-content').forEach(content => {
        content.style.display = 'none';
    });
    
    // Desactivar todos los botones
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    
    // Activar el tab seleccionado
    document.getElementById('content-' + tabName).style.display = 'block';
    document.getElementById('tab-' + tabName).classList.add('active');
}

// Actualizar contrataciones vencidas cada 5 minutos
setInterval(() => {
    fetch('/api/actualizar-contrataciones', { method: 'POST' })
        .catch(err => console.log('Error actualizando contrataciones:', err));
}, 300000);
</script>
