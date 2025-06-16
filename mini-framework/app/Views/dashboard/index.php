   <h1>Dashboard</h1>
    <p>Bienvenido al área privada, <?= htmlspecialchars($user['username']) ?>.</p>
    
    <p>Datos del usuario:</p>
    <ul>
        <li>ID: <?= $user['id'] ?></li>
        <li>Email: <?= htmlspecialchars($user['email']) ?></li>
    </ul>
    
    <p><a href="/dashboard/<?= $user['id'] ?>">Ver detalles de mi perfil</a></p>

