<div class="container text-center" style="padding: 3rem 0;">
    <div style="max-width: 800px; margin: 0 auto;">
        <!-- Logo -->
        <div style="margin-bottom: 2rem;">
            <img src="/img/logo.png" alt="Logo Proyecto UTU" width="200" style="border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">
        </div>
        
        <!-- Título principal -->
        <h1 style="font-size: 3rem; margin-bottom: 1.5rem; background: linear-gradient(135deg, #dc3545, #ff6b6b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            <?= $title ?>
        </h1>
        
        <!-- Descripción -->
        <p style="font-size: 1.2rem; color: var(--text-secondary); margin-bottom: 3rem; line-height: 1.8;">
            Plataforma de servicios donde puedes encontrar y publicar servicios por categorías. Conecta con proveedores y usuarios de forma simple y organizada.
        </p>
        
        <?php if ($auth['check']): ?>
            <!-- Usuario autenticado -->
            <div class="card" style="max-width: 500px; margin: 0 auto; padding: 2rem;">
                <h2 style="margin-bottom: 1rem;">¡Bienvenido de vuelta!</h2>
                <p style="font-size: 1.3rem; color: var(--color-primary); font-weight: 600; margin-bottom: 1.5rem;">
                    <?= htmlspecialchars($auth['user']['username']) ?>
                </p>
                
                <div class="flex-center" style="margin-top: 2rem;">
                    <a href="/post" class="btn btn-primary" style="width: auto;">
                        Ver Servicios
                    </a>
                    <a href="/post/crear" class="btn btn-success" style="width: auto;">
                        Publicar Servicio
                    </a>
                </div>
            </div>
            
        <?php else: ?>
            <!-- Usuario no autenticado -->
            <div style="background-color: var(--bg-secondary); padding: 3rem; border-radius: 20px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);">
                <h2 style="margin-bottom: 2rem;">Comienza ahora</h2>
                
                <div class="flex-center" style="gap: 1.5rem; margin-bottom: 2rem;">
                    <a href="/register" class="btn btn-primary" style="width: auto; font-size: 1.1rem; padding: 1.2rem 2.5rem;">
                        Registrarse
                    </a>
                    <a href="/login" class="btn btn-secondary" style="width: auto; font-size: 1.1rem; padding: 1.2rem 2.5rem;">
                        Iniciar Sesión
                    </a>
                </div>
                
                <p style="color: var(--text-tertiary); font-size: 0.95rem;">
                    Crea tu cuenta para publicar servicios y conectar con otros usuarios
                </p>
            </div>
            
            <!-- Características destacadas -->
            <div class="grid" style="margin-top: 4rem; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
                <div class="card">
                    <h3 style="color: var(--color-primary); margin-bottom: 1rem;">Publica Servicios</h3>
                    <p>Comparte tus servicios con la comunidad de forma rápida y sencilla</p>
                </div>
                
                <div class="card">
                    <h3 style="color: var(--color-primary); margin-bottom: 1rem;">Explora por Categorías</h3>
                    <p>Encuentra servicios organizados por categorías para facilitar tu búsqueda</p>
                </div>
                
                <div class="card">
                    <h3 style="color: var(--color-primary); margin-bottom: 1rem;">Gestión Completa</h3>
                    <p>Administra tus servicios publicados desde tu panel de usuario</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
