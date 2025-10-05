<h2>Crear Nuevo Servicio</h2>

<?php if (isset($errors) && !empty($errors)): ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" style="max-width: 600px;">
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Título:</label>
        <input type="text" name="title" required 
               value="<?= htmlspecialchars($input['title'] ?? '') ?>"
               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Contenido:</label>
        <textarea name="content" required rows="10"
                  style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"><?= htmlspecialchars($input['content'] ?? '') ?></textarea>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Categoría:</label>
        <select name="category_id" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['category_id'] ?>" 
                        <?= (($input['category_id'] ?? '') == $categoria['category_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($categoria['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Crear Servicio
        </button>
        <a href="/post" style="padding: 10px 20px; background-color: #999; color: white; text-decoration: none; border-radius: 4px; display: inline-block; margin-left: 10px;">
            Cancelar
        </a>
    </div>
</form>
