<html>
<body>
    
    <div class="main-content">
        <div class="form-wrapper">
            <h2>Crear Nuevo Servicio</h2>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php 
            $errores = $_SESSION['errores'] ?? [];
            $form_data = $_SESSION['form_data'] ?? [];
            unset($_SESSION['errores'], $_SESSION['form_data']);
            ?>
            
            <form action="/servicios/store" method="POST" class="form-servicio">
                <div class="form-group">
                    <label for="nombre">Nombre del Servicio *</label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           value="<?php echo htmlspecialchars($form_data['nombre'] ?? ''); ?>"
                           placeholder="Ej: Desarrollo Web, Limpieza de Hogar..."
                           required>
                    <?php if (isset($errores['nombre'])): ?>
                        <div class="error-message"><?php echo $errores['nombre']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="categoria_id">Categoría *</label>
                    <select id="categoria_id" name="categoria_id" required>
                        <option value="">Selecciona una categoría</option>
                        <?php if (!empty($categorias)): ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo $categoria['id']; ?>" 
                                        <?php echo (isset($form_data['categoria_id']) && $form_data['categoria_id'] == $categoria['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?php if (isset($errores['categoria_id'])): ?>
                        <div class="error-message"><?php echo $errores['categoria_id']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="precio">Precio *</label>
                    <input type="number" 
                           id="precio" 
                           name="precio" 
                           step="0.01" 
                           min="0"
                           value="<?php echo htmlspecialchars($form_data['precio'] ?? ''); ?>"
                           placeholder="0.00"
                           required>
                    <small>Precio en tu moneda local</small>
                    <?php if (isset($errores['precio'])): ?>
                        <div class="error-message"><?php echo $errores['precio']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción *</label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              rows="4"
                              placeholder="Describe tu servicio detalladamente..."
                              required><?php echo htmlspecialchars($form_data['descripcion'] ?? ''); ?></textarea>
                    <small>Explica qué incluye tu servicio, duración, requisitos, etc.</small>
                    <?php if (isset($errores['descripcion'])): ?>
                        <div class="error-message"><?php echo $errores['descripcion']; ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Crear Servicio</button>
                    <a href="/servicios" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
            
            <div class="form-links">
                <div><a href="/servicios">← Volver a Servicios</a></div>
                <div><a href="/listado">Ver Categorías</a></div>
            </div>
        </div>
    </div>
</body>
</html>
