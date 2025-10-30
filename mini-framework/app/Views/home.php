<div class="container" style="padding: 2rem 0;">
    <!-- Sección Hero -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">🚀 ServiceHub</h1>
            <p class="hero-subtitle">
                La plataforma de servicios más rápida y confiable. Conecta con profesionales, 
                descubre servicios y crece tu negocio en un solo lugar.
            </p>
        </div>
    </div>

    <?php if ($auth['check']): ?>
        <!-- Usuario autenticado -->
        <div class="welcome-card">
            <h2>¡Bienvenido de vuelta! 👋</h2>
            <div class="username">
                <h2> <?= htmlspecialchars($auth['user']['username']) ?> </h2>
            </div>
            <p style="opacity: 0.9; margin-bottom: 1.5rem;">
                Continúa explorando servicios o publica uno nuevo
            </p>
            <div class="btn-group">
                <a href="/post" class="btn btn-primary" style="width: auto;">
                    📋 Ver Servicios
                </a>
                <a href="/post/crear" class="btn btn-light">
                    ➕ Publicar Servicio
                </a>
            </div>
        </div>

    <?php else: ?>
        <!-- Usuario no autenticado - CTA -->
        <div class="cta-section">
            <h2 style="color: #0066cc; margin-bottom: 1.5rem;">¿Listo para comenzar?</h2>
            <p style="color: var(--text-secondary); font-size: 1.1rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                Crea tu cuenta hoy y empieza a conectar con miles de usuarios. Es gratis y solo toma un minuto.
            </p>
            <div class="btn-group">
                <a href="/register" class="btn btn-primary" style="width: auto; font-size: 1.05rem; padding: 1rem 2.5rem;">
                    📝 Crear Cuenta
                </a>
                <a href="/login" class="btn btn-secondary" style="width: auto; font-size: 1.05rem; padding: 1rem 2.5rem;">
                    🔐 Iniciar Sesión
                </a>
            </div>
        </div>

        <!-- Características destacadas -->
        <div style="margin-top: 4rem;">
            <h2 style="text-align: center; margin-bottom: 0.5rem; color: #0066cc;">¿Por qué elegir ServiceHub?</h2>
            <p style="text-align: center; color: var(--text-secondary); margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                Descubre todas las ventajas de nuestra plataforma
            </p>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📤</div>
                    <h3>Publica al Instante</h3>
                    <p>Comparte tus servicios en segundos. Sin complicaciones, sin intermediarios. Tu negocio al alcance de todos.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h3>Encuentra Fácilmente</h3>
                    <p>Explora servicios organizados por categorías. Filtra, compara y elige el que mejor se adapte a tus necesidades.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">⚙️</div>
                    <h3>Gestión Total</h3>
                    <p>Administra tus servicios, edita precios, actualiza descripciones. Todo bajo tu control desde tu panel.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Comunidad Activa</h3>
                    <p>Conecta con proveedores y clientes profesionales. Construye tu red y expande tu alcance comercial.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🛡️</div>
                    <h3>Seguro y Confiable</h3>
                    <p>Tu información protegida. Transacciones seguras y usuarios verificados para tu tranquilidad.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">⭐</div>
                    <h3>Destaca tu Negocio</h3>
                    <p>Presenta tus servicios de forma profesional. Atrae clientes con descripciones detalladas e imágenes.</p>
                </div>
            </div>
        </div>

        <!-- Estadísticas o CTA final -->
        <div style="background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%); color: white; padding: 3rem; border-radius: 15px; margin-top: 4rem; text-align: center;">
            <h2 style="color: white; margin-bottom: 1rem;">¡Únete a nuestra comunidad!</h2>
            <p style="font-size: 1.1rem; margin-bottom: 2rem; opacity: 0.95;">
                Miles de usuarios ya confían en ServiceHub para conectar y crecer
            </p>
            <a href="/register" class="btn btn-light" style="width: auto; font-size: 1.05rem; padding: 1rem 2.5rem;">
                Comenzar Ahora
            </a>
        </div>

    <?php endif; ?>
</div>
