<?php
require("../lib/page.php");
Page::header("Productos");
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
	$sql = "SELECT * FROM productos, categorias WHERE productos.id_categoria = categorias.id_categoria AND nombre_producto LIKE ? ORDER BY nombre_producto";
	$params = array("%$search%");
}
else
{
	$sql = "SELECT * FROM productos, categorias WHERE productos.id_categoria = categorias.id_categoria ORDER BY nombre_producto";
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
						<th>IMAGEN</th>
						<th>NOMBRE</th>
						<th>PRECIO (US$)</th>
						<th>CATEGORÍA</th>
						<th>ESTADO</th>
						<th>ACCIÓN</th>
					</tr>
				</thead>
				<tbody>
		");
		foreach($data as $row)
		{
			print("
				<tr>
					<td><img src='../../img/products/".$row['imagen_producto']."' class='materialboxed' width='100' height='100'></td>
					<td>".$row['nombre_producto']."</td>
					<td>".$row['precio_producto']."</td>
					<td>".$row['nombre_categoria']."</td>
					<td>
			");
			if($row['estado_producto'] == 1)
			{
				print("<i class='material-icons'>visibility</i>");
			}
			else
			{
				print("<i class='material-icons'>visibility_off</i>");
			}
			print("
					</td>
					<td>
						<a href='save.php?id=".$row['id_producto']."' class='blue-text'><i class='material-icons'>mode_edit</i></a>
						<a href='delete.php?id=".$row['id_producto']."&image=".$row['imagen_producto']."' class='red-text'><i class='material-icons'>delete</i></a>
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