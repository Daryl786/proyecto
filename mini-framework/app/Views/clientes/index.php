
<?php if ( count($clientes) == 0): ?>
<h1>NO HAY CLIENTES </h1>
<?php else: ?>

<h1> clientes </h1>
<table class="tabla">
<tr>
	<th>rut</th>
	<th>razon Social</th>
	<th>Calle</th>
	<th>numero</th>
	<th>telefono</th>
	<th>email</th>
</tr>
<?php foreach( $clientes as $indice => $valor): ?>
<tr>
	<td><?= $valor["rut"]?></td>
	<td><?= $valor["razonsocial"]?></td>
	<td><?= $valor["calle"]?></td>
	<td><?= $valor["numero"]?></td>
	<td><?= $valor["telefono"]?></td>
	<td><?= $valor["email"]?></td>
</tr>

<?php endforeach; ?>

</table>
<?php endif ?>

</p>


