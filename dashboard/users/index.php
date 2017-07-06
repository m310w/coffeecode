<?php
require("../lib/page.php");
Page::header("Usuarios");
?>

<form method='post'>
	<div class='row'>
		<div class='input-field col s6 m4'>
			<i class='material-icons prefix'>search</i>
			<input id='buscar' type='text' name='buscar'/>
			<label for='buscar'>Buscar</label>
		</div>
		<div class='input-field col s6 m4'>
			<button type='submit' class='btn tooltipped waves-effect green' data-tooltip='Busca por nombres o apellidos'><i class='material-icons'>check_circle</i></button>
		</div>
		<div class='input-field col s12 m4'>
			<a href='save.php' class='btn waves-effect indigo'><i class='material-icons'>add_circle</i></a>
		</div>
	</div>
</form>

<?php
if(!empty($_POST))
{
	$search = trim($_POST['buscar']);
	$sql = "SELECT * FROM usuarios WHERE apellidos_usuairo LIKE ? OR nombres_usuairo LIKE ? ORDER BY apellidos_usuario";
	$params = array("%$search%", "%$search%");
}
else
{
	$sql = "SELECT * FROM usuarios ORDER BY apellidos_usuario";
	$params = null;
}
try
{
	$data = Database::getRows($sql, $params);
	if($data != null)
	{
		print("
			<table class='striped'>
				<thead>
					<tr>
						<th>APELLIDOS</th>
						<th>NOMBRES</th>
						<th>CORREO</th>
						<th>ALIAS</th>
						<th>ACCIÓN</th>
					</tr>
				</thead>
				<tbody>
		");
		foreach($data as $row)
		{
			print("
				<tr>
					<td>".$row['apellidos_usuario']."</td>
					<td>".$row['nombres_usuario']."</td>
					<td>".$row['correo_usuario']."</td>
					<td>".$row['alias_usuario']."</td>
					<td>
						<a href='save.php?id=".$row['id_usuario']."' class='blue-text'><i class='material-icons'>edit</i></a>
						<a href='delete.php?id=".$row['id_usuario']."' class='red-text'><i class='material-icons'>delete</i></a>
					</td>
				</tr>
			");
		}
		print("
			</tbody>
		</table>
		");
	}
	else
	{
		Page::showMessage(4, "No hay registros disponibles", "save.php");
	}
}
catch(Exception $error)
{
	Page::showMessage(2, $error->getMessage(), "../main/");
}
Page::footer();
?>