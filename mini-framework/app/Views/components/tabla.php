<?php 

if ( count( $datosTabla) > 0 ){

	if ( isset($datosTabla[0]) ){ 
			$columnas = array_keys($datosTabla[0]);

	}else  {
			$columnas = array_keys($datosTabla);
			$datosTabla = [ $datosTabla ];
	}
	
	// Detectar qué tipo de tabla es
	$esUsuarios = isset($datosTabla[0]['user_id']) && isset($datosTabla[0]['email']);
	$esPosts = isset($datosTabla[0]['post_id']);
	
	// Columnas a excluir
	$columnasExcluidas = ['password', 'precio', 'duracion', 'nombre_empresa', 'user_id', 'post_id', 'category_id', 'content', 'created_at', 'updated_at'];
	?>
    <table border="1">
        <thead>
            <tr>
                <?php foreach ($columnas as $col): ?>
                    <?php if (!in_array($col, $columnasExcluidas)): ?>
                        <th><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $col))) ?></th>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if ($esUsuarios || $esPosts): ?>
                    <th>Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datosTabla as $fila): ?>
                <tr>
                    <?php foreach ($columnas as $col): ?>
                        <?php if (!in_array($col, $columnasExcluidas)): ?>
                            <td>
                                <?php if ($col === 'rol'): ?>
                                    <span style="padding: 3px 8px; border-radius: 3px; font-weight: bold; 
                                                 <?= ($fila[$col] ?? 'usuario') === 'admin' ? 'background-color: #dc3545; color: white;' : 'background-color: #28a745; color: white;' ?>">
                                        <?= htmlspecialchars(ucfirst($fila[$col] ?? 'usuario')) ?>
                                    </span>
                                <?php elseif ($col === 'title' && $esPosts): ?>
                                    <a href="/post/ver/<?= $fila['post_id'] ?>" style="color: #0066cc; text-decoration: none; font-weight: 600;">
                                        <?= htmlspecialchars($fila[$col] ?? '') ?>
                                    </a>
                                <?php else: ?>
                                    <?= htmlspecialchars($fila[$col] ?? '') ?>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if ($esUsuarios || $esPosts): ?>
                        <td style="white-space: nowrap;">
                            <?php if ($esUsuarios): ?>
                                <a href="/usuarios/editar/<?= $fila['user_id'] ?>" 
                                   style="padding: 5px 10px; background-color: #0066cc; color: white; text-decoration: none; border-radius: 3px; display: inline-block; margin-right: 5px;">
                                    ✏️ Editar
                                </a>
                                <a href="/usuarios/eliminar/<?= $fila['user_id'] ?>" 
                                   onclick="return confirm('¿Estás seguro de eliminar este usuario?')"
                                   style="padding: 5px 10px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 3px; display: inline-block;">
                                    🗑️ Eliminar
                                </a>
                            <?php elseif ($esPosts): ?>
                                <a href="/post/ver/<?= $fila['post_id'] ?>" 
                                   style="padding: 5px 10px; background-color: #0066cc; color: white; text-decoration: none; border-radius: 3px; display: inline-block; margin-right: 5px;">
                                    👁️ Ver
                                </a>
                                <a href="/post/eliminar/<?= $fila['post_id'] ?>" 
                                   onclick="return confirm('¿Estás seguro de eliminar este servicio?')"
                                   style="padding: 5px 10px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 3px; display: inline-block;">
                                    🗑️ Eliminar
                                </a>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php } else { echo "<h1>SIN DATOS</h1>"; } ?>
