<div class="form-wrapper">
    <h2>Registro de Usuario</h2>
    
    <form method="POST">
        <div>
            <label>Nombre:</label>
            <input type="text" name="username" required value="<?= $this->e($input['username'] ?? '') ?>">
        </div>
        
        <div>
            <label>Apellido:</label>
            <input type="text" name="apellido" required value="<?= $this->e($input['apellido'] ?? '') ?>" placeholder="Ingrese su apellido">
        </div>
        
        <div>
            <label>Cédula:</label>
            <input type="text" name="cedula" required value="<?= $this->e($input['cedula'] ?? '') ?>" placeholder="Ej: 12345678">
        </div>
        
        <div>
            <label>Email:</label>
            <input type="email" name="email" required value="<?= $this->e($input['email'] ?? '') ?>">
        </div>
        
        <div>
            <label>País:</label>
            <select name="pais" required>
                <option value="">Seleccione un país</option>
                <option value="Uruguay" <?= (($input['pais'] ?? '') == 'Uruguay') ? 'selected' : '' ?>>Uruguay</option>
                <option value="Argentina" <?= (($input['pais'] ?? '') == 'Argentina') ? 'selected' : '' ?>>Argentina</option>
                <option value="Brasil" <?= (($input['pais'] ?? '') == 'Brasil') ? 'selected' : '' ?>>Brasil</option>
                <option value="Chile" <?= (($input['pais'] ?? '') == 'Chile') ? 'selected' : '' ?>>Chile</option>
                <option value="Paraguay" <?= (($input['pais'] ?? '') == 'Paraguay') ? 'selected' : '' ?>>Paraguay</option>
                <option value="Colombia" <?= (($input['pais'] ?? '') == 'Colombia') ? 'selected' : '' ?>>Colombia</option>
                <option value="Perú" <?= (($input['pais'] ?? '') == 'Perú') ? 'selected' : '' ?>>Perú</option>
                <option value="México" <?= (($input['pais'] ?? '') == 'México') ? 'selected' : '' ?>>México</option>
                <option value="otro" <?= (($input['pais'] ?? '') == 'otro') ? 'selected' : '' ?>>Otro</option>
            </select>
        </div>
        
        <div>
            <label>Ciudad:</label>
            <input type="text" name="ciudad" required value="<?= $this->e($input['ciudad'] ?? '') ?>" placeholder="Ingrese su ciudad">
        </div>
        
        <div>
            <label>Contraseña:</label>
            <input type="password" name="password" required>
        </div>
        
        <div>
            <label>Confirmar Contraseña:</label>
            <input type="password" name="password_confirm" required>
        </div>
        
        <button type="submit">Registrarse</button>
        
        <p>
            ¿Ya tienes una cuenta? <a href="/login">Inicia sesión</a>
        </p>
    </form>
</div>
