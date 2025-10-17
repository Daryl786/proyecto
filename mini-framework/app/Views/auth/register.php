<div class="auth-container">
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>📝 Crear Cuenta</h2>
            <p class="auth-subtitle">Únete a ServiceHub en menos de un minuto</p>

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
                <div class="form-group">
                    <label for="username">👤 Nombre:</label>
                    <input type="text" id="username" name="username" required 
                           value="<?= htmlspecialchars($input['username'] ?? '') ?>"
                           placeholder="Tu nombre">
                </div>
                
                <div class="form-group">
                    <label for="apellido">👥 Apellido:</label>
                    <input type="text" id="apellido" name="apellido" required 
                           value="<?= htmlspecialchars($input['apellido'] ?? '') ?>" 
                           placeholder="Tu apellido">
                </div>
                
                <div class="form-group">
                    <label for="cedula">🆔 Cédula:</label>
                    <input type="text" id="cedula" name="cedula" required 
                           value="<?= htmlspecialchars($input['cedula'] ?? '') ?>" 
                           placeholder="Ej: 12345678">
                </div>
                
                <div class="form-group">
                    <label for="email">📧 Email:</label>
                    <input type="email" id="email" name="email" required 
                           value="<?= htmlspecialchars($input['email'] ?? '') ?>"
                           placeholder="tu@email.com">
                </div>
                
                <div class="form-group">
                    <label for="pais">🌍 País:</label>
                    <select id="pais" name="pais" required>
                        <option value="">Selecciona tu país</option>
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
                
                <div class="form-group">
                    <label for="ciudad">🏘️ Ciudad:</label>
                    <input type="text" id="ciudad" name="ciudad" required 
                           value="<?= htmlspecialchars($input['ciudad'] ?? '') ?>" 
                           placeholder="Tu ciudad">
                </div>
                
                <div class="form-group">
                    <label for="password">🔐 Contraseña:</label>
                    <input type="password" id="password" name="password" required 
                           placeholder="Mínimo 6 caracteres">
                </div>
                
                <div class="form-group">
                    <label for="password_confirm">✓ Confirmar Contraseña:</label>
                    <input type="password" id="password_confirm" name="password_confirm" required 
                           placeholder="Repite tu contraseña">
                </div>
                
                <button type="submit" class="auth-button">Crear mi cuenta</button>
            </form>

            <div class="auth-footer">
                ¿Ya tienes cuenta? <a href="/login">Inicia sesión aquí</a>
            </div>
        </div>
    </div>
</div>
