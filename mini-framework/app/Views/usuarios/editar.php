<h2>Editar Usuario</h2>

<?php if (isset($errors) && !empty($errors)): ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" style="max-width: 500px;">
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nombre de usuario:</label>
        <input type="text" name="username" required 
               value="<?= htmlspecialchars($usuario['username'] ?? '') ?>"
               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Apellido:</label>
        <input type="text" name="apellido" required 
               value="<?= htmlspecialchars($usuario['apellido'] ?? '') ?>"
               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email:</label>
        <input type="email" name="email" required 
               value="<?= htmlspecialchars($usuario['email'] ?? '') ?>"
               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Cédula:</label>
        <input type="text" name="cedula" required 
               value="<?= htmlspecialchars($usuario['cedula'] ?? '') ?>"
               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">País:</label>
        <select name="pais" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <option value="">Seleccione un país</option>
            <option value="Uruguay" <?= ($usuario['pais'] ?? '') == 'Uruguay' ? 'selected' : '' ?>>Uruguay</option>
            <option value="Argentina" <?= ($usuario['pais'] ?? '') == 'Argentina' ? 'selected' : '' ?>>Argentina</option>
            <option value="Brasil" <?= ($usuario['pais'] ?? '') == 'Brasil' ? 'selected' : '' ?>>Brasil</option>
            <option value="Chile" <?= ($usuario['pais'] ?? '') == 'Chile' ? 'selected' : '' ?>>Chile</option>
            <option value="Paraguay" <?= ($usuario['pais'] ?? '') == 'Paraguay' ? 'selected' : '' ?>>Paraguay</option>
            <option value="Colombia" <?= ($usuario['pais'] ?? '') == 'Colombia' ? 'selected' : '' ?>>Colombia</option>
            <option value="otro" <?= ($usuario['pais'] ?? '') == 'otro' ? 'selected' : '' ?>>Otro</option>
        </select>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Ciudad:</label>
        <input type="text" name="ciudad" required 
               value="<?= htmlspecialchars($usuario['ciudad'] ?? '') ?>"
               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Rol:</label>
        <select name="rol" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <option value="usuario" <?= ($usuario['rol'] ?? 'usuario') == 'usuario' ? 'selected' : '' ?>>Usuario Normal</option>
            <option value="admin" <?= ($usuario['rol'] ?? '') == 'admin' ? 'selected' : '' ?>>Administrador</option>
        </select>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;">
            💾 Guardar Cambios
        </button>
        <a href="/usuarios" style="padding: 10px 20px; background-color: #999; color: white; text-decoration: none; border-radius: 4px; display: inline-block;">
            ❌ Cancelar
        </a>
    </div>
</form>
