<div class="post-form-wrapper">
    <div class="post-form-card">
        <h2>🏷️ Crear Nueva Categoría</h2>

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
                <label for="name">📝 Nombre de la Categoría</label>
                <input type="text" id="name" name="name" required 
                       value="<?= htmlspecialchars($input['name'] ?? '') ?>"
                       placeholder="Ej: Diseño Gráfico, Programación, Marketing...">
            </div>
            
            <div class="post-form-group">
                <label for="description">📄 Descripción (Opcional)</label>
                <textarea id="description" name="description" 
                          placeholder="Describe brevemente esta categoría..."><?= htmlspecialchars($input['description'] ?? '') ?></textarea>
            </div>
            
            <button type="submit" class="post-submit-btn">✨ Crear Categoría</button>
            
            <div class="post-form-footer">
                <a href="/categoria">← Volver a Categorías</a>
            </div>
        </form>
    </div>
</div>
