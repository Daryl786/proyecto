<?php 

require 'tabla.php';
?>
    <div class="paginacion">
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="<?= $baseUrl . '/' . $i ?>" 
               <?= $i == $pagina ? 'style="font-weight: bold;"' : '' ?>>
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
	
