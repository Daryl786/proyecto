<nav>
    <a href="/" class="<?= ($currentUrl === '/' || $currentUrl === '') ? 'active' : '' ?>">Inicio</a>
    
    <?php if ($auth['check']): ?>
	<a href="/dashboard" class="<?= (strpos($currentUrl, '/dashboard') === 0) ? 'active' : '' ?>">Dashboard</a>
	<a href="/listado" class="<?= ($currentUrl === '/listado') ? 'active' : '' ?>">Categorías</a>
	<a href="/servicios" class="<?= (strpos($currentUrl, '/servicios') === 0) ? 'active' : '' ?>">Servicios</a>
    <a href="/logout">Cerrar sesión</a>
    <?php else: ?>
    <a href="/login" class="<?= ($currentUrl === '/login') ? 'active' : '' ?>">Login</a>
    <a href="/clientes" class="<?= ($currentUrl === '/clientes') ? 'active' : '' ?>">Clientes</a>
    <a href="/minuevo" class="<?=($currentUrl === '/minuevo')?'active': ''?>">MiControlador</a>
    <a href="/listado" class="<?= ($currentUrl === '/listado') ? 'active' : '' ?>">Categorías</a>
    <a href="/servicios" class="<?= (strpos($currentUrl, '/servicios') === 0) ? 'active' : '' ?>">Servicios</a>
 

  <?php endif; ?>
</nav>
