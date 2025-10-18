<nav style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <a href="/" class="<?= ($currentUrl === '/' || $currentUrl === '') ? 'active' : '' ?>">Inicio</a>
        
        <?php if ($auth['check']): ?>
            <a href="/dashboard" class="<?= (strpos($currentUrl, '/dashboard') === 0) ? 'active' : '' ?>">Mi Perfil</a>
            
            <?php if (isset($auth['user']['rol']) && $auth['user']['rol'] === 'admin'): ?>
                <a href="/usuarios" class="<?= ($currentUrl === '/usuarios') ? 'active' : '' ?>">Usuarios</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="/login" class="<?= ($currentUrl === '/login') ? 'active' : '' ?>">Login</a>
        <?php endif; ?>

        <a href="/post" class="<?=($currentUrl === '/post')?'active': ''?>">Servicios</a>
    </div>
    
    <?php if ($auth['check']): ?>
        <div>
            <a href="/logout">Cerrar sesión</a>
        </div>
    <?php endif; ?>
</nav>
