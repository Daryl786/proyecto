    <h1>Detalles de Usuario</h1>
    <p>ID de usuario: <?= $userId ?? 'N/A' ?></p>
    <p>Nombre: <?= htmlspecialchars($user['username']) ?></p>
    <p>Email: <?= htmlspecialchars($user['email']) ?></p>
    
    <p><a href="/dashboard">← Volver al dashboard</a></p>

