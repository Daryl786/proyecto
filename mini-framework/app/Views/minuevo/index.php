    <h1>Últimos Artículos (¡Dinámicos!)</h1>

    <p>Aquí tienes los artículos más recientes directamente de nuestra base de datos:</p>

    ---

    <div class="article">
        <?php if (isset($articleData1)): ?>
            <h2><?php echo $this->e($articleData1['title']); ?></h2>
            <p><strong>Fecha:</strong> <?php echo $this->e($articleData1['date']); ?> | <strong>Autor:</strong> <?php echo $this->e($articleData1['author']); ?></p>
            <p><?php echo $this->e($articleData1['content']); ?></p>
            <a href="/article/<?php echo $this->e($articleData1['title']); ?>">Leer más</a>
        <?php else: ?>
            <p>No se encontró el Artículo 1.</p>
        <?php endif; ?>
    </div>

    ---

    <div class="article">
        <?php if (isset($articleData2)): ?>
            <h2><?php echo $this->e($articleData2['title']); ?></h2>
            <p><strong>Fecha:</strong> <?php echo $this->e($articleData2['date']); ?> | <strong>Autor:</strong> <?php echo $this->e($articleData2['author']); ?></p>
            <p><?php echo $this->e($articleData2['content']); ?></p>
            <a href="/article/<?php echo $this->e($articleData2['title']); ?>">Leer más</a>
        <?php else: ?>
            <p>No se encontró el Artículo 2.</p>
        <?php endif; ?>
    </div>

    ---

    <div class="article">
        <?php if (isset($articleData3)): ?>
            <h2><?php echo $this->e($articleData3['title']); ?></h2>
            <p><strong>Fecha:</strong> <?php echo $this->e($articleData3['date']); ?> | <strong>Autor:</strong> <?php echo $this->e($articleData3['author']); ?></p>
            <p><?php echo $this->e($articleData3['content']); ?></p>
            <a href="/article/<?php echo $this->e($articleData3['title']); ?>">Leer más</a>
        <?php else: ?>
            <p>No se encontró el Artículo 3.</p>
        <?php endif; ?>
    </div>
    ---

