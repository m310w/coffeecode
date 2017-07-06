<?php
require("../lib/page.php");
Page::header("Eliminar producto");

if(!empty($_GET['id']) && !empty($_GET['image'])) 
{
    $id = $_GET['id'];
	$image = $_GET['image'];
}
else
{
    header("location: index.php");
}

if(!empty($_POST))
{
	$id = $_POST['id'];
	try 
	{
		$sql = "DELETE FROM productos WHERE id_producto = ?";
		$params = array($id);
	    if(Database::executeRow($sql, $params))
		{
			if(Validator::deleteImage("../../img/products/", $image))
			{
				$mensaje = "Operación satisfactoria. Se borro la imagen";
			}
			else
			{
				$mensaje = "Operación realizada. No se borro la imagen";
			}
			Page::showMessage(1, $mensaje, "index.php");
		}
		else
		{
			throw new Exception(Database::$error[1]);
		}
	}
	catch (Exception $error) 
	{
		Page::showMessage(2, $error->getMessage(), "index.php");
	}
}
?>

<form method='post'>
	<div class='row center-align'>
		<input type='hidden' name='id' value='<?php print($id); ?>'/>
		<a href='index.php' class='btn waves-effect grey'><i class='material-icons'>cancel</i></a>
		<button type='submit' class='btn waves-effect red'><i class='material-icons'>remove_circle</i></button>
	</div>
</form>

<?php
Page::footer();
?>