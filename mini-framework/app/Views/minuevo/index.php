<h1>Últimos Productos (¡Dinámicos!)</h1>

<p>Aquí tienes los productos más recientes directamente de nuestra base de datos:</p>

---

<div class="productos-container">
    <?php if (isset($datos['productos']) && !empty($datos['productos'])): ?>
        <?php foreach ($datos['productos'] as $producto): ?>
            <div class="producto">
                <h2><?php echo $this->e($producto['nombreProducto'] ?? 'Producto sin nombre'); ?></h2>
                <p><strong>Precio:</strong> $<?php echo $this->e($producto['precioProducto'] ?? '0'); ?></p>
                <p><strong>Descripción:</strong> <?php echo $this->e($producto['descripcionProducto'] ?? 'Sin descripción'); ?></p>
                <p><strong>Fecha de creación:</strong> <?php echo $this->e($producto['created_at'] ?? 'No disponible'); ?></p>
                <a href="/productos/<?php echo $this->e($producto['id']); ?>">Ver detalles</a>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No se encontraron productos en la base de datos.</p>
    <?php endif; ?>
</div>

---

<div class="debug-info">
    <h3>Información de debug:</h3>
    <p>Título: <?php echo $this->e($datos['mititulo'] ?? 'No disponible'); ?></p>
    <p>Otro dato: <?php echo $this->e($datos['miotrodato'] ?? 'No disponible'); ?></p>
    <p>Total productos: <?php echo count($datos['productos'] ?? []); ?></p>
</div>
