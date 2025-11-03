<style>
/* Estilos del menú desplegable */
.user-menu {
    position: relative;
    display: inline-block;
    z-index: 1000;
}

.user-menu-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background-color: rgba(255, 255, 255, 0.15);
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    font-family: inherit;
}

.user-menu-button:hover {
    background-color: rgba(255, 255, 255, 0.25);
}

.user-menu-button .user-icon {
    width: 32px;
    height: 32px;
    background-color: white;
    color: #0066cc;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
}

.user-menu-button .arrow {
    font-size: 0.7rem;
    transition: transform 0.3s ease;
}

.user-menu-button.active .arrow {
    transform: rotate(180deg);
}

.user-dropdown {
    position: absolute !important;
    top: calc(100% + 0.5rem) !important;
    right: 0 !important;
    background-color: white !important;
    border-radius: 10px !important;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15) !important;
    min-width: 250px !important;
    z-index: 1001 !important;
    overflow: hidden !important;
    display: none !important;
    opacity: 0;
    transform: translateY(-10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.user-dropdown.show {
    display: block !important;
    opacity: 1 !important;
    transform: translateY(0) !important;
}

.user-dropdown-header {
    padding: 1.25rem;
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
    color: white;
    border-bottom: 2px solid rgba(255, 255, 255, 0.2);
}

.user-dropdown-header .user-name {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.user-dropdown-header .user-email {
    font-size: 0.85rem;
    opacity: 0.9;
    word-break: break-all;
}

.user-dropdown-header .user-role {
    display: inline-block;
    margin-top: 0.5rem;
    padding: 0.25rem 0.75rem;
    background-color: rgba(255, 255, 255, 0.25);
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.user-dropdown-menu {
    list-style: none;
    padding: 0.5rem 0;
    margin: 0;
}

.user-dropdown-item {
    margin: 0;
}

.user-dropdown-item a {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.85rem 1.25rem;
    color: #1a1a1a;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.user-dropdown-item a:hover {
    background-color: #f0f2f5;
    color: #0066cc;
}

.user-dropdown-item a .icon {
    font-size: 1.2rem;
    width: 24px;
    text-align: center;
}

.user-dropdown-divider {
    height: 1px;
    background-color: #e0e0e0;
    margin: 0.5rem 0;
}

.user-dropdown-item.logout a {
    color: #dc3545;
}

.user-dropdown-item.logout a:hover {
    background-color: rgba(220, 53, 69, 0.1);
}

@media (max-width: 768px) {
    .user-dropdown {
        min-width: 220px !important;
    }
    
    .user-dropdown-header {
        padding: 1rem;
    }
    
    .user-dropdown-item a {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }
}
</style>

<nav style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <a href="/" class="<?= ($currentUrl === '/' || $currentUrl === '') ? 'active' : '' ?>">Inicio</a>
        
        <?php if ($auth['check']): ?>
            <a href="/dashboard" class="<?= (strpos($currentUrl, '/dashboard') === 0) ? 'active' : '' ?>">Mi Perfil</a>
            
            <?php if (isset($auth['user']['rol']) && $auth['user']['rol'] === 'admin'): ?>
                <a href="/usuarios" class="<?= ($currentUrl === '/usuarios') ? 'active' : '' ?>">Usuarios</a>
                <a href="/categoria" class="<?= (strpos($currentUrl, '/categoria') === 0) ? 'active' : '' ?>">Categorías</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="/login" class="<?= ($currentUrl === '/login') ? 'active' : '' ?>">Iniciar Sesión</a>
        <?php endif; ?>

        <a href="/post" class="<?= ($currentUrl === '/post') ? 'active' : '' ?>">Servicios</a>
    </div>
    
    <?php if ($auth['check']): ?>
        <div class="user-menu">
            <button class="user-menu-button" id="userMenuButton">
                <div class="user-icon">
                    <?= strtoupper(substr($auth['user']['username'], 0, 1)) ?>
                </div>
                <span><?= htmlspecialchars($auth['user']['username']) ?></span>
                <span class="arrow">▼</span>
            </button>
            
            <div class="user-dropdown" id="userDropdown">
                <div class="user-dropdown-header">
                    <div class="user-name">
                        <?= htmlspecialchars($auth['user']['username'] . ' ' . ($auth['user']['apellido'] ?? '')) ?>
                    </div>
                    <div class="user-email">
                        <?= htmlspecialchars($auth['user']['email']) ?>
                    </div>
                    <span class="user-role">
                        <?= htmlspecialchars($auth['user']['rol'] ?? 'usuario') ?>
                    </span>
                </div>
                
                <ul class="user-dropdown-menu">
                    <li class="user-dropdown-item">
                        <a href="/dashboard">
                            <span class="icon">👤</span>
                            <span>Mi Perfil</span>
                        </a>
                    </li>
                    
                    <li class="user-dropdown-item">
                        <a href="/dashboard/editar-perfil">
                            <span class="icon">✏️</span>
                            <span>Editar Perfil</span>
                        </a>
                    </li>
                    
                    <li class="user-dropdown-item">
                        <a href="/post">
                            <span class="icon">🔍</span>
                            <span>Explorar Servicios</span>
                        </a>
                    </li>
                    
                    <li class="user-dropdown-item">
                        <a href="/post/crear">
                            <span class="icon">➕</span>
                            <span>Publicar Servicio</span>
                        </a>
                    </li>
                    
                    <?php if (isset($auth['user']['rol']) && $auth['user']['rol'] === 'admin'): ?>
                        <div class="user-dropdown-divider"></div>
                        
                        <li class="user-dropdown-item">
                            <a href="/usuarios">
                                <span class="icon">👥</span>
                                <span>Gestionar Usuarios</span>
                            </a>
                        </li>
                        
                        <li class="user-dropdown-item">
                            <a href="/categoria">
                                <span class="icon">📁</span>
                                <span>Categorías</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <div class="user-dropdown-divider"></div>
                    
                    <li class="user-dropdown-item logout">
                        <a href="/logout">
                            <span class="icon">🚪</span>
                            <span>Cerrar Sesión</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</nav>
