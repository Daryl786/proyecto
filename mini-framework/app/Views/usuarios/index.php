
<?php if ( count($datosTabla) == 0): ?>
<h1>NO HAY CLIENTES </h1>
<?php else: ?>

<h1> Usuarios </h1>

<?php 
	$tb =  BASE_PATH . "/app/Views/components/tabla.php";
	require  "$tb";
?>

<?php endif ?>

</p>


