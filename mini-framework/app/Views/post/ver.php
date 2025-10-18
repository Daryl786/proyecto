<div class="post-view-card">
    <!-- Título y Categoría -->
    <div class="post-title-section">
        <h1><?= htmlspecialchars($servicio['title'] ?? '') ?></h1>
        <?php if (isset($servicio['categoria_nombre']) && !empty($servicio['categoria_nombre'])): ?>
            <span class="badge badge-secondary" style="height: fit-content;">
                <?= htmlspecialchars($servicio['categoria_nombre']) ?>
            </span>
        <?php endif; ?>
    </div>
    
    <!-- Calificación Promedio -->
    <?php if (isset($servicio['promedio_rating']) && $servicio['total_ratings'] > 0): ?>
    <div style="text-align: center; padding: 1rem; background-color: var(--bg-tertiary); border-radius: 12px; margin-bottom: 1.5rem;">
        <div style="font-size: 2rem; font-weight: 700; color: #ffa500;">
            ⭐ <?= number_format($servicio['promedio_rating'], 1) ?> / 5
        </div>
        <div style="color: var(--text-secondary); font-size: 0.9rem;">
            <?= $servicio['total_ratings'] ?> <?= $servicio['total_ratings'] == 1 ? 'calificación' : 'calificaciones' ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Precio -->
    <?php if (isset($servicio['precio']) && $servicio['precio'] !== null && $servicio['precio'] !== ''): ?>
    <div class="post-price-box">
        <div class="post-price-label">💰 Precio</div>
        <div class="post-price-value">
            $<?= number_format((float)$servicio['precio'], 2) ?>
            <span class="post-price-currency">UYU</span>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Información del Servicio -->
    <div class="post-info-grid">
        <?php if (isset($servicio['duracion']) && !empty($servicio['duracion'])): ?>
        <div class="post-info-item">
            <div class="post-info-label">⏱️ Duración</div>
            <div class="post-info-value">
                <?= htmlspecialchars($servicio['duracion']) ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (isset($servicio['nombre_empresa']) && !empty($servicio['nombre_empresa'])): ?>
        <div class="post-info-item">
            <div class="post-info-label">🏢 Empresa</div>
            <div class="post-info-value">
                <?= htmlspecialchars($servicio['nombre_empresa']) ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Descripción -->
    <div class="post-description-section">
        <h3>📖 Descripción del Servicio</h3>
        <div class="post-description-content">
            <?= nl2br(htmlspecialchars($servicio['content'] ?? '')) ?>
        </div>
    </div>
    
    <!-- Información del Publicador -->
    <div class="post-publisher-section">
        <h3>👤 Publicado por</h3>
        <div class="post-publisher-info">
            <div class="post-publisher-name">
                <?= htmlspecialchars((isset($servicio['username']) ? $servicio['username'] : '') . ' ' . (isset($servicio['apellido']) ? $servicio['apellido'] : '')) ?>
            </div>
            <?php if (isset($servicio['email']) && !empty($servicio['email'])): ?>
            <div class="post-publisher-email">
                📧 <?= htmlspecialchars($servicio['email']) ?>
            </div>
            <?php endif; ?>
            
            <?php if ((isset($servicio['ciudad']) && !empty($servicio['ciudad'])) || (isset($servicio['pais']) && !empty($servicio['pais']))): ?>
            <div class="post-publisher-location">
                📍 <?= htmlspecialchars((isset($servicio['ciudad']) ? $servicio['ciudad'] : '') . ', ' . (isset($servicio['pais']) ? $servicio['pais'] : '')) ?>
            </div>
            <?php endif; ?>
            
            <?php if (isset($servicio['created_at']) && !empty($servicio['created_at'])): ?>
            <div class="post-publisher-date">
                Publicado el <?= date('d/m/Y', strtotime($servicio['created_at'])) ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Sistema de Calificaciones -->
    <div class="rating-section">
        <h3 style="margin-bottom: 1.5rem;">⭐ Calificaciones y Reseñas</h3>
        
        <!-- Formulario de Calificación -->
        <?php if ($auth['check'] && $servicio['user_id'] != $auth['user']['user_id']): ?>
            <div class="rating-form">
                <h4><?= $usuarioYaCalificó ? '✏️ Editar mi calificación' : '📝 Calificar este servicio' ?></h4>
                
                <form method="POST" action="/post/calificar/<?= $servicio['post_id'] ?>" id="ratingForm">
                    <div id="starContainer" style="display: flex; flex-direction: row-reverse; justify-content: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                        <input type="radio" id="star5" name="rating" value="5" <?= (isset($calificacionUsuario['rating']) && $calificacionUsuario['rating'] == 5) ? 'checked' : '' ?> required style="position: absolute; opacity: 0; width: 0; height: 0;">
                        <label for="star5" data-value="5" style="cursor: pointer; font-size: 3rem; color: #d4d4d4; margin: 0; padding: 0; line-height: 1; transition: all 0.2s;">★</label>
                        
                        <input type="radio" id="star4" name="rating" value="4" <?= (isset($calificacionUsuario['rating']) && $calificacionUsuario['rating'] == 4) ? 'checked' : '' ?> style="position: absolute; opacity: 0; width: 0; height: 0;">
                        <label for="star4" data-value="4" style="cursor: pointer; font-size: 3rem; color: #d4d4d4; margin: 0; padding: 0; line-height: 1; transition: all 0.2s;">★</label>
                        
                        <input type="radio" id="star3" name="rating" value="3" <?= (isset($calificacionUsuario['rating']) && $calificacionUsuario['rating'] == 3) ? 'checked' : '' ?> style="position: absolute; opacity: 0; width: 0; height: 0;">
                        <label for="star3" data-value="3" style="cursor: pointer; font-size: 3rem; color: #d4d4d4; margin: 0; padding: 0; line-height: 1; transition: all 0.2s;">★</label>
                        
                        <input type="radio" id="star2" name="rating" value="2" <?= (isset($calificacionUsuario['rating']) && $calificacionUsuario['rating'] == 2) ? 'checked' : '' ?> style="position: absolute; opacity: 0; width: 0; height: 0;">
                        <label for="star2" data-value="2" style="cursor: pointer; font-size: 3rem; color: #d4d4d4; margin: 0; padding: 0; line-height: 1; transition: all 0.2s;">★</label>
                        
                        <input type="radio" id="star1" name="rating" value="1" <?= (isset($calificacionUsuario['rating']) && $calificacionUsuario['rating'] == 1) ? 'checked' : '' ?> style="position: absolute; opacity: 0; width: 0; height: 0;">
                        <label for="star1" data-value="1" style="cursor: pointer; font-size: 3rem; color: #d4d4d4; margin: 0; padding: 0; line-height: 1; transition: all 0.2s;">★</label>
                    </div>
                    
                    <textarea name="comment" class="rating-comment" placeholder="Escribe tu opinión sobre este servicio (opcional)..."><?= isset($calificacionUsuario['comment']) ? htmlspecialchars($calificacionUsuario['comment']) : '' ?></textarea>
                    
                    <button type="submit" class="rating-submit">
                        <?= $usuarioYaCalificó ? '💾 Actualizar Calificación' : '✨ Enviar Calificación' ?>
                    </button>
                </form>
            </div>
        <?php elseif (!$auth['check']): ?>
            <div class="rating-form">
                <p style="text-align: center; color: var(--text-secondary);">
                    <a href="/login" style="color: #0066cc; font-weight: 600;">Inicia sesión</a> para calificar este servicio
                </p>
            </div>
        <?php endif; ?>
        
        <!-- Lista de Calificaciones -->
        <?php if (!empty($calificaciones)): ?>
            <div class="ratings-list">
                <?php foreach ($calificaciones as $rating): ?>
                    <div class="rating-item">
                        <div class="rating-header">
                            <div>
                                <span class="rating-user">
                                    <?= htmlspecialchars($rating['username'] . ' ' . ($rating['apellido'] ?? '')) ?>
                                </span>
                                <span class="rating-stars">
                                    <?= str_repeat('★', $rating['rating']) . str_repeat('☆', 5 - $rating['rating']) ?>
                                </span>
                            </div>

                                  <?php if (!empty($rating['comment'])): ?>
                            <div class="rating-comment-text">
                                <?= nl2br(htmlspecialchars($rating['comment'])) ?>
                            </div>
                        <?php endif; ?>                            

                            <span class="rating-date">
                                <?= date('d/m/Y', strtotime($rating['created_at'])) ?>
                            </span>
                        </div>
                      
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-ratings">
                <p>📝 Este servicio aún no tiene calificaciones. ¡Sé el primero en calificarlo!</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Botones de Acción -->
    <div class="post-action-buttons">
        <a href="/post" class="btn btn-secondary">← Volver a Servicios</a>
        
        <?php if ($auth['check'] && isset($servicio['user_id']) && $auth['user']['user_id'] == $servicio['user_id']): ?>
            <a href="/post/editar/<?= $servicio['post_id'] ?>" class="btn btn-success">✏️ Editar</a>
            <a href="/post/eliminar/<?= $servicio['post_id'] ?>" 
               onclick="return confirm('¿Estás seguro de eliminar este servicio?')"
               class="btn btn-primary">🗑️ Eliminar</a>
        <?php endif; ?>
    </div>
</div>
<script src="/js/ratings.js"></script>
