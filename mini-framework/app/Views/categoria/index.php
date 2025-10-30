<div class="container">
    <div class="post-list-header">
        <h1 style="margin: 0;">🏷️ Gestión de Categorías</h1>
        <?php if ($auth['check'] && isset($auth['user']['rol']) && $auth['user']['rol'] === 'admin'): ?>
            <a href="/categoria/crear" class="post-create-btn">
                ➕ Crear Nueva Categoría
            </a>
        <?php endif; ?>
    </div>

    <?php if (empty($categorias)): ?>
        <div style="text-align: center; padding: 3rem; background: white; border-radius: 15px;">
            <p style="color: var(--text-secondary); font-size: 1.1rem;">No hay categorías registradas</p>
        </div>
    <?php else: ?>
        <div style="background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); overflow: hidden;">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Total Servicios</th>
                        <th>Fecha Creación</th>
                        <?php if ($auth['check'] && $auth['user']['rol'] === 'admin'): ?>
                            <th>Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td style="font-weight: 600; color: #0066cc;">
                                <?= htmlspecialchars($categoria['name']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($categoria['description'] ?? 'Sin descripción') ?>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge badge-secondary">
                                    <?= $categoria['total_posts'] ?> servicio<?= $categoria['total_posts'] != 1 ? 's' : '' ?>
                                </span>
                            </td>
                            <td>
                                <?= date('d/m/Y', strtotime($categoria['created_at'])) ?>
                            </td>
                            <?php if ($auth['check'] && $auth['user']['rol'] === 'admin'): ?>
                                <td style="white-space: nowrap;">
                                    <a href="/categoria/editar/<?= $categoria['category_id'] ?>" 
                                       style="padding: 5px 10px; background-color: #0066cc; color: white; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 5px;">
                                        ✏️ Editar
                                    </a>
                                    <?php if ($categoria['total_posts'] == 0): ?>
                                        <a href="/categoria/eliminar/<?= $categoria['category_id'] ?>" 
                                           onclick="return confirm('¿Estás seguro de eliminar esta categoría?')"
                                           style="padding: 5px 10px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 5px; display: inline-block;">
                                            🗑️ Eliminar
                                        </a>
                                    <?php else: ?>
                                        <span style="padding: 5px 10px; background-color: #999; color: white; border-radius: 5px; display: inline-block; cursor: not-allowed;" 
                                              title="No se puede eliminar porque tiene servicios asociados">
                                            🔒 Bloqueada
                                        </span>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
