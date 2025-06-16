    <h2>Registro de Usuario</h2>
    
    <form method="POST" style="max-width: 400px;">
        <div>
            <label>Nombre:</label>
            <input type="text" name="name" required value="<?= $this->e($input['name'] ?? '') ?>">
        </div>
        
        <div>
            <label>Email:</label>
            <input type="email" name="email" required value="<?= $this->e($input['email'] ?? '') ?>">
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
    </form>
    
    <p>¿Ya tienes una cuenta? <a href="/login">Inicia sesión</a></p>

