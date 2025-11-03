<div class="auth-container">
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>🔑 Nueva Contraseña</h2>
            <p class="auth-subtitle">Configura tu nueva contraseña de acceso</p>

            <!-- Información del usuario verificado -->
            <div class="alert alert-success" style="margin-bottom: 1.5rem;">
                <strong>✓ Usuario verificado:</strong><br>
                <span style="font-size: 0.95rem;">
                    👤 <?= htmlspecialchars($username ?? '') ?><br>
                    📧 <?= htmlspecialchars($email ?? '') ?>
                </span>
            </div>

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
                    <label for="new_password">🔒 Nueva Contraseña:</label>
                    <input 
                        type="password" 
                        id="new_password" 
                        name="new_password" 
                        required 
                        minlength="4"
                        placeholder="Mínimo 4 caracteres"
                        autofocus
                    >
                    <small style="color: #666; font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                        Elige una contraseña segura que recuerdes fácilmente
                    </small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">✅ Confirmar Contraseña:</label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        required 
                        minlength="4"
                        placeholder="Repite la contraseña"
                    >
                </div>
                
                <button type="submit" class="auth-button">Actualizar Contraseña</button>
            </form>

            <div class="auth-footer">
                <a href="/password/cancel">Cancelar y volver al inicio</a>
            </div>
        </div>
    </div>
</div>

<script>
// Validación en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');
    const submitButton = document.querySelector('.auth-button');
    
    function validatePasswords() {
        if (confirmPassword.value === '') {
            confirmPassword.setCustomValidity('');
            return;
        }
        
        if (newPassword.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Las contraseñas no coinciden');
            confirmPassword.style.borderColor = '#dc3545';
        } else {
            confirmPassword.setCustomValidity('');
            confirmPassword.style.borderColor = '#28a745';
        }
    }
    
    newPassword.addEventListener('input', validatePasswords);
    confirmPassword.addEventListener('input', validatePasswords);
});
</script>
