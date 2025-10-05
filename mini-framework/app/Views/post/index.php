<?php if ($auth['check']): ?>
    <div style="margin-bottom: 20px;">
        <a href="/post/crear" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px; display: inline-block;">
            + Crear Nuevo Servicio
        </a>
    </div>
<?php endif; ?>

<div style="margin-bottom: 20px;">
    <form method="GET" action="/post" style="display: flex; gap: 10px; align-items: center;">
        <label for="categoria">Filtrar por categoría:</label>
        <select name="categoria" id="categoria" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <option value="">Todas las categorías</option>
            <?php if (isset($categorias) && is_array($categorias)): ?>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>" <?= (isset($categoriaSeleccionada) && $categoriaSeleccionada == $cat['category_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <button type="submit" style="padding: 8px 16px; background-color: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Buscar
        </button>
        <?php if (isset($categoriaSeleccionada) && $categoriaSeleccionada): ?>
            <a href="/post" style="padding: 8px 16px; background-color: #999; color: white; text-decoration: none; border-radius: 4px;">
                Limpiar
            </a>
        <?php endif; ?>
    </form>
</div>

<?php
echo "<h1> $titulo </h1>";

require BASE_PATH . "/app/Views/components/paginar.php";
?>
