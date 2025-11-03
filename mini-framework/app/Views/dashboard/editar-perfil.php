<div class="container">
    <div class="post-form-wrapper">
        <div class="post-form-card">
            <h2>✏️ Editar Mi Perfil</h2>
            
            <?php if (isset($errors) && !empty($errors)): ?>
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="/dashboard/editar-perfil">
                <div class="post-form-group">
                    <label for="username">Nombre *</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        value="<?= htmlspecialchars($usuario['username'] ?? '') ?>"
                        placeholder="Tu nombre"
                        required
                    >
                </div>
                
                <div class="post-form-group">
                    <label for="apellido">Apellido *</label>
                    <input 
                        type="text" 
                        id="apellido" 
                        name="apellido" 
                        value="<?= htmlspecialchars($usuario['apellido'] ?? '') ?>"
                        placeholder="Tu apellido"
                        required
                    >
                </div>
                
                <div class="post-form-group">
                    <label for="email">Email *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="<?= htmlspecialchars($usuario['email'] ?? '') ?>"
                        placeholder="tu@email.com"
                        required
                    >
                    <small>Este email se usará para notificaciones y contacto</small>
                </div>
                
                <div class="post-form-group">
                    <label for="cedula">Cédula *</label>
                    <input 
                        type="text" 
                        id="cedula" 
                        name="cedula" 
                        value="<?= htmlspecialchars($usuario['cedula'] ?? '') ?>"
                        placeholder="12345678"
                        required
                    >
                </div>
                
                <div class="post-form-group">
                    <label for="pais">País *</label>
                    <input 
                        type="text" 
                        id="pais" 
                        name="pais" 
                        value="<?= htmlspecialchars($usuario['pais'] ?? '') ?>"
                        placeholder="Uruguay"
                        required
                    >
                </div>
                
                <div class="post-form-group">
                    <label for="ciudad">Ciudad *</label>
                    <input 
                        type="text" 
                        id="ciudad" 
                        name="ciudad" 
                        value="<?= htmlspecialchars($usuario['ciudad'] ?? '') ?>"
                        placeholder="Montevideo"
                        required
                    >
                </div>
                
                <div style="border-top: 2px solid var(--border-color); margin: 2rem 0; padding-top: 2rem;">
                    <h3 style="margin-bottom: 1rem; color: var(--text-primary); font-size: 1.2rem;">
                        🔒 Cambiar Contraseña (Opcional)
                    </h3>
                    <p style="color: var(--text-secondary); margin-bottom: 1.5rem; font-size: 0.95rem;">
                        Deja estos campos vacíos si no deseas cambiar tu contraseña
                    </p>
                    
                    <div class="post-form-group">
                        <label for="password_actual">Contraseña Actual</label>
                        <input 
                            type="password" 
                            id="password_actual" 
                            name="password_actual"
                            placeholder="Tu contraseña actual"
                        >
                        <small>Requerida solo si deseas cambiar tu contraseña</small>
                    </div>
                    
                    <div class="post-form-group">
                        <label for="password_nueva">Nueva Contraseña</label>
                        <input 
                            type="password" 
                            id="password_nueva" 
                            name="password_nueva"
                            placeholder="Mínimo 6 caracteres"
                        >
                    </div>
                    
                    <div class="post-form-group">
                        <label for="password_confirmar">Confirmar Nueva Contraseña</label>
                        <input 
                            type="password" 
                            id="password_confirmar" 
                            name="password_confirmar"
                            placeholder="Repite la nueva contraseña"
                        >
                    </div>
                </div>
                
                <button type="submit" class="post-submit-btn">
                    💾 Guardar Cambios
                </button>
            </form>
            
            <div class="post-form-footer">
                <a href="/dashboard">← Volver a Mi Perfil</a>
            </div>
        </div>
    </div>
</div>

<style>
.post-form-wrapper {
    margin-top: 2rem;
    margin-bottom: 3rem;
}

.alert ul {
    list-style-position: inside;
}
</style>
