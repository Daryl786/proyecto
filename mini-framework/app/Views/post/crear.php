<div class="post-form-wrapper">
    <div class="post-form-card">
        <h2>📝 Crear Nuevo Servicio</h2>

        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="post-form-group">
                <label for="title">💼 Título del Servicio</label>
                <input type="text" id="title" name="title" required 
                       value="<?= htmlspecialchars($input['title'] ?? '') ?>"
                       placeholder="Ej: Desarrollo de sitios web">
            </div>
            
            <div class="post-form-group">
                <label for="content">📝 Descripción</label>
                <textarea id="content" name="content" required 
                          placeholder="Describe detalladamente tu servicio..."><?= htmlspecialchars($input['content'] ?? '') ?></textarea>
            </div>
            
            <div class="post-form-group">
                <label for="precio">💰 Precio (UYU)</label>
                <input type="number" id="precio" name="precio" required step="0.01" min="0"
                       value="<?= htmlspecialchars($input['precio'] ?? '') ?>"
                       placeholder="Ej: 5000">
            </div>
            
            <div class="post-form-group">
                <label for="duracion">⏱️ Duración del Servicio</label>
                <input type="text" id="duracion" name="duracion" required 
                       value="<?= htmlspecialchars($input['duracion'] ?? '') ?>"
                       placeholder="Ej: 2 semanas, 1 mes, 3 días">
            </div>
            
            <div class="post-form-group">
                <label for="nombre_empresa">🏢 Nombre de la Empresa (Opcional)</label>
                <input type="text" id="nombre_empresa" name="nombre_empresa" 
                       value="<?= htmlspecialchars($input['nombre_empresa'] ?? '') ?>"
                       placeholder="Ej: Mi Empresa S.A.">
            </div>
            
            <div class="post-form-group">
                <label for="category_id">🏷️ Categoría</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Selecciona una categoría</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['category_id'] ?>" 
                                <?= (($input['category_id'] ?? '') == $categoria['category_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categoria['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="post-submit-btn">✨ Publicar Servicio</button>
            
            <div class="post-form-footer">
                <a href="/post">← Volver atrás</a>
            </div>
        </form>
    </div>
</div>
