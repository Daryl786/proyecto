<div class="form-wrapper">
    <h2>Editar Servicio</h2>

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
        <div>
            <label>Título del Servicio:</label>
            <input type="text" name="title" required 
                   value="<?= htmlspecialchars($input['title'] ?? '') ?>"
                   placeholder="Ej: Desarrollo de sitios web">
        </div>
        
        <div>
            <label>Descripción:</label>
            <textarea name="content" required 
                      placeholder="Describe detalladamente tu servicio..."><?= htmlspecialchars($input['content'] ?? '') ?></textarea>
        </div>
        
        <div>
            <label>Precio (UYU):</label>
            <input type="number" name="precio" required step="0.01" min="0"
                   value="<?= htmlspecialchars($input['precio'] ?? '') ?>"
                   placeholder="Ej: 5000">
        </div>
        
        <div>
            <label>Duración del Servicio:</label>
            <input type="text" name="duracion" required 
                   value="<?= htmlspecialchars($input['duracion'] ?? '') ?>"
                   placeholder="Ej: 2 semanas, 1 mes, 3 días">
        </div>
        
        <div>
            <label>Nombre de la Empresa (Opcional):</label>
            <input type="text" name="nombre_empresa" 
                   value="<?= htmlspecialchars($input['nombre_empresa'] ?? '') ?>"
                   placeholder="Ej: Mi Empresa S.A.">
        </div>
        
        <div>
            <label>Categoría:</label>
            <select name="category_id" required>
                <option value="">Seleccione una categoría</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['category_id'] ?>" 
                            <?= (($input['category_id'] ?? '') == $categoria['category_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($categoria['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit">Actualizar Servicio</button>
        
        <p>
            <a href="/post/ver/<?= $servicio['post_id'] ?>">Cancelar</a>
        </p>
    </form>
</div>
