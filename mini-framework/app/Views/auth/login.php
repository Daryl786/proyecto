<div class="auth-container">
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>🔐 Iniciar Sesión</h2>
            <p class="auth-subtitle">Accede a tu cuenta para continuar</p>

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
                    <label for="email">📧 Email:</label>
                    <input type="email" id="email" name="email" required placeholder="tu@email.com">
                </div>
                
                <div class="form-group">
                    <label for="password">🔑 Contraseña:</label>
                    <input type="password" id="password" name="password" required placeholder="Ingresa tu contraseña">
                </div>
                
                <button type="submit" class="auth-button">Ingresar a mi cuenta</button>
                
                <div class="password-recovery">
                    <a href="/password">¿Olvidaste tu contraseña?</a>
                </div>
            </form>

            <div class="auth-footer">
                ¿Aún no tienes cuenta? <a href="/register">Crear una ahora</a>
            </div>
        </div>
    </div>
</div>
