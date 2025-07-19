<div class="dash">
    <div class="user-info">
        <h1>Detalles de Usuario</h1>
        <p><strong>ID de usuario:</strong> <?= $userId ?? 'N/A' ?></p>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        
        <p><a href="/dashboard">← Volver al dashboard</a></p>
    </div>
</div>
