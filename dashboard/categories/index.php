<?php
require("../lib/page.php");
Page::header("Categorías");
?>

<form method='post'>
	<div class='row'>
		<div class='input-field col s6 m4'>
			<i class='material-icons prefix'>search</i>
			<input id='buscar' type='text' name='buscar'/>
			<label for='buscar'>Buscar</label>
		</div>
		<div class='input-field col s6 m4'>
			<button type='submit' class='btn tooltipped waves-effect green' data-tooltip='Busca por nombre'><i class='material-icons'>check_circle</i></button>
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
	$sql = "SELECT * FROM categorias WHERE nombre_categoria LIKE ? ORDER BY nombre_categoria";
	$params = array("%$search%");
}
else
{
	$sql = "SELECT * FROM categorias ORDER BY nombre_categoria";
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
						<th>NOMBRE</th>
						<th>DESCRIPCIÓN</th>
						<th>ACCIÓN</th>
					</tr>
				</thead>
				<tbody>
		");
		foreach($data as $row)
		{
			print("
				<tr>
					<td>".$row['nombre_categoria']."</td>
					<td>".$row['descripcion_categoria']."</td>
					<td>
						<a href='save.php?id=".$row['id_categoria']."' class='blue-text'><i class='material-icons'>edit</i></a>
						<a href='delete.php?id=".$row['id_categoria']."' class='red-text'><i class='material-icons'>delete</i></a>
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