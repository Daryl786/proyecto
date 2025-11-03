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
        <div class="post-price-label">💰 Precio(dia)</div>
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
    
    <!-- Botón de Contratación -->
    <?php if ($auth['check'] && $servicio['user_id'] != $auth['user']['user_id']): ?>
        <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 2rem; border-radius: 15px; margin-bottom: 2rem; text-align: center; color: white; box-shadow: 0 8px 20px rgba(40, 167, 69, 0.2);">
            <h3 style="color: white; margin-bottom: 1rem;">💼 ¿Te interesa este servicio?</h3>
            <p style="opacity: 0.95; margin-bottom: 1.5rem; font-size: 1.05rem;">
                Contrata ahora y empieza a disfrutar de este servicio profesional
            </p>
            
            <?php 
            $contratacionModel = new \App\Models\Contratacion();
            $yaContratado = $contratacionModel->usuarioYaContrato($servicio['post_id'], $auth['user']['user_id']);
            ?>
            
            <?php if ($yaContratado): ?>
                <div style="background-color: rgba(255, 255, 255, 0.2); padding: 1rem; border-radius: 10px;">
                    <p style="margin: 0; font-weight: 600; font-size: 1.1rem;">
                        ✅ Ya tienes una contratación activa de este servicio
                    </p>
                    <a href="/dashboard" style="color: white; text-decoration: underline; margin-top: 0.5rem; display: inline-block;">
                        Ver mis contrataciones
                    </a>
                </div>
            <?php else: ?>
                <a href="/post/contratar/<?= $servicio['post_id'] ?>" 
                   onclick="return confirm('¿Confirmas que deseas contratar este servicio por $<?= number_format($servicio['precio'], 2) ?> UYU?')"
                   class="btn btn-light" 
                   style="background-color: white; color: #28a745; font-size: 1.1rem; padding: 1rem 3rem; width: auto; font-weight: 700; border: 2px solid white;">
                    🤝 Contratar Servicio
                </a>
            <?php endif; ?>
        </div>
    <?php elseif (!$auth['check']): ?>
        <div style="background-color: var(--bg-tertiary); padding: 2rem; border-radius: 15px; margin-bottom: 2rem; text-align: center; border: 2px dashed var(--border-color);">
            <h3 style="color: var(--text-primary); margin-bottom: 1rem;">🔒 Contrata este servicio</h3>
            <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
                <a href="/login" style="color: #0066cc; font-weight: 600;">Inicia sesión</a> 
                o 
                <a href="/register" style="color: #0066cc; font-weight: 600;">regístrate</a> 
                para contratar este servicio
            </p>
        </div>
    <?php endif; ?>
    
    <!-- Sistema de Calificaciones -->
    <div class="rating-section">
        <h3 style="margin-bottom: 1.5rem;">⭐ Calificaciones y Reseñas</h3>
        
        <!-- Formulario de Calificación - SOLO PARA QUIENES HAN CONTRATADO -->
        <?php if ($auth['check'] && $servicio['user_id'] != $auth['user']['user_id']): ?>
            <?php if ($usuarioHaContratado): ?>
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
                        
                        <textarea name="comment" class="rating-comment" placeholder="Escribe tu opinión sobre este servicio (opcional)..." style="width: 100%; padding: 1rem; border: 2px solid var(--border-color); border-radius: 10px; background-color: var(--bg-tertiary); color: var(--text-primary); font-size: 1rem; font-family: inherit; min-height: 100px; resize: vertical; margin-bottom: 1rem;"><?= isset($calificacionUsuario['comment']) ? htmlspecialchars($calificacionUsuario['comment']) : '' ?></textarea>
                        
                        <button type="submit" class="rating-submit" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%); color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 1rem; cursor: pointer; transition: all 0.3s ease;">
                            <?= $usuarioYaCalificó ? '💾 Actualizar Calificación' : '✨ Enviar Calificación' ?>
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div class="rating-form" style="background-color: #fff3cd; padding: 1.5rem; border-radius: 12px; border-left: 4px solid #ffc107;">
                    <p style="text-align: center; color: #856404; font-weight: 600; margin: 0;">
                        🛒 Debes contratar este servicio para poder calificarlo
                    </p>
                </div>
            <?php endif; ?>
        <?php elseif (!$auth['check']): ?>
            <div class="rating-form">
                <p style="text-align: center; color: var(--text-secondary);">
                    <a href="/login" style="color: #0066cc; font-weight: 600;">Inicia sesión</a> para calificar este servicio
                </p>
            </div>
        <?php endif; ?>
        
        <!-- Lista de Calificaciones -->
        <?php if (!empty($calificaciones)): ?>
            <div class="ratings-list" style="margin-top: 2rem;">
                <?php foreach ($calificaciones as $rating): ?>
                    <div class="rating-item" style="background-color: var(--bg-tertiary); padding: 1.5rem; border-radius: 12px; margin-bottom: 1rem;">
                        <div class="rating-header" style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                                <div>
                                    <span class="rating-user" style="font-weight: 600; color: var(--text-primary); margin-right: 1rem;">
                                        <?= htmlspecialchars($rating['username'] . ' ' . ($rating['apellido'] ?? '')) ?>
                                    </span>
                                    <span class="rating-stars" style="color: #ffc107; font-size: 1.2rem;">
                                        <?= str_repeat('★', $rating['rating']) . str_repeat('☆', 5 - $rating['rating']) ?>
                                    </span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <span class="rating-date" style="color: var(--text-tertiary); font-size: 0.85rem;">
                                        <?= date('d/m/Y', strtotime($rating['created_at'])) ?>
                                    </span>
                                    
                                    <?php if ($auth['check'] && ($auth['user']['rol'] === 'admin' || $servicio['user_id'] == $auth['user']['user_id'])): ?>
                                        <a href="/post/eliminar-calificacion/<?= $rating['rating_id'] ?>" 
                                           onclick="return confirm('¿Estás seguro de eliminar esta calificación?')"
                                           style="padding: 0.4rem 0.8rem; background-color: #dc3545; color: white; text-decoration: none; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">
                                            🗑️ Eliminar
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if (!empty($rating['comment'])): ?>
                            <div class="rating-comment-text" style="color: var(--text-secondary); line-height: 1.6; padding-top: 0.5rem; border-top: 1px solid var(--border-color);">
                                <?= nl2br(htmlspecialchars($rating['comment'])) ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-ratings" style="text-align: center; padding: 2rem; background-color: var(--bg-tertiary); border-radius: 12px; margin-top: 2rem;">
                <p style="color: var(--text-secondary); font-size: 1.1rem;">📝 Este servicio aún no tiene calificaciones. ¡Sé el primero en calificarlo!</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Sistema de Comentarios -->
    <div class="comments-section" style="margin-top: 3rem; padding-top: 2rem; border-top: 2px solid var(--border-color);">
        <h3 style="margin-bottom: 1.5rem;">💬 Comentarios (<?= $totalComentarios ?>)</h3>
        
        <!-- Formulario para agregar comentario -->
        <?php if ($auth['check']): ?>
            <div class="comment-form" style="background-color: var(--bg-tertiary); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem;">
                <h4 style="margin-bottom: 1rem;">📝 Agregar un comentario</h4>
                <form method="POST" action="/post/agregar-comentario/<?= $servicio['post_id'] ?>">
                    <textarea name="comment_text" 
                              class="comment-textarea" 
                              placeholder="Escribe tu comentario aquí... (mínimo 3 caracteres, máximo 1000)"
                              required
                              style="width: 100%; min-height: 100px; padding: 1rem; border: 2px solid var(--border-color); border-radius: 10px; font-family: inherit; font-size: 1rem; resize: vertical;"></textarea>
                    <button type="submit" 
                            class="btn btn-primary" 
                            style="margin-top: 1rem; width: auto; padding: 0.75rem 2rem;">
                        📤 Publicar Comentario
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div style="background-color: var(--bg-tertiary); padding: 2rem; border-radius: 12px; text-align: center; margin-bottom: 2rem;">
                <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                    <a href="/login" style="color: #0066cc; font-weight: 600;">Inicia sesión</a> 
                    para dejar un comentario
                </p>
            </div>
        <?php endif; ?>
        
        <!-- Lista de comentarios -->
        <?php if (!empty($comentarios)): ?>
            <div class="comments-list">
                <?php foreach ($comentarios as $comentario): ?>
                    <div class="comment-item" style="background-color: var(--bg-secondary); padding: 1.5rem; border-radius: 12px; margin-bottom: 1rem; border-left: 4px solid #0066cc;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                            <div>
                                <span style="font-weight: 600; color: var(--text-primary); font-size: 1rem;">
                                    <?= htmlspecialchars($comentario['username'] . ' ' . ($comentario['apellido'] ?? '')) ?>
                                </span>
                                <?php if ($comentario['rol'] === 'admin'): ?>
                                    <span class="badge badge-danger" style="margin-left: 0.5rem; font-size: 0.75rem;">ADMIN</span>
                                <?php endif; ?>
                                <div style="color: var(--text-tertiary); font-size: 0.85rem; margin-top: 0.25rem;">
                                    <?= date('d/m/Y H:i', strtotime($comentario['created_at'])) ?>
                                </div>
                            </div>
                            
                            <?php if ($auth['check']): ?>
                                <?php 
                                $canDelete = false;
                                if ($auth['user']['rol'] === 'admin' || 
                                    $servicio['user_id'] == $auth['user']['user_id'] || 
                                    $comentario['user_id'] == $auth['user']['user_id']) {
                                    $canDelete = true;
                                }
                                ?>
                                
                                <?php if ($canDelete): ?>
                                    <a href="/post/eliminar-comentario/<?= $comentario['comment_id'] ?>" 
                                       onclick="return confirm('¿Estás seguro de eliminar este comentario?')"
                                       style="color: #dc3545; text-decoration: none; font-size: 0.9rem; font-weight: 600; padding: 0.25rem 0.75rem; border-radius: 5px;">
                                        🗑️ Eliminar
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        
                        <div style="color: var(--text-primary); line-height: 1.6; white-space: pre-wrap; word-wrap: break-word;">
                            <?= nl2br(htmlspecialchars($comentario['comment_text'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 2rem; background-color: var(--bg-tertiary); border-radius: 12px;">
                <p style="color: var(--text-secondary);">📝 No hay comentarios todavía. ¡Sé el primero en comentar!</p>
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

<style>
.comment-textarea:focus {
    outline: none;
    border-color: #0066cc;
    box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
}

.comment-item:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
    transition: all 0.3s;
}
</style>

<script src="/js/ratings.js"></script>
