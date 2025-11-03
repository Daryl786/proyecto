<div class="auth-container">
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>🔐 Recuperar Contraseña</h2>
            <p class="auth-subtitle">Ingresa tu cédula para verificar tu identidad</p>

            <?php if (isset($errors) && !empty($errors)): ?>
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="/password/verify">
                <div class="form-group">
                    <label for="cedula">🆔 Número de Cédula:</label>
                    <input 
                        type="text" 
                        id="cedula" 
                        name="cedula" 
                        required 
                        placeholder="Ej: 12345678"
                        value="<?= htmlspecialchars($input['cedula'] ?? '') ?>"
                        autofocus
                    >
                    <small style="color: #666; font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                        Ingresa la cédula que registraste en tu cuenta
                    </small>
                </div>
                
                <button type="submit" class="auth-button">Verificar y Continuar</button>
            </form>

            <div class="auth-footer">
                ¿Recordaste tu contraseña? <a href="/login">Volver al inicio de sesión</a>
            </div>
        </div>
    </div>
</div>
