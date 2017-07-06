<?php
require("../lib/page.php");
if(empty($_GET['id'])) 
{
    Page::header("Agregar categoría");
    $id = null;
    $nombre = null;
    $descripcion = null;
}
else
{
    Page::header("Modificar categoría");
    $id = $_GET['id'];
    $sql = "SELECT * FROM categorias WHERE id_categoria = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $nombre = $data['nombre_categoria'];
    $descripcion = $data['descripcion_categoria'];
}

if(!empty($_POST))
{
    $_POST = Validator::validateForm($_POST);
  	$nombre = $_POST['nombre'];
  	$descripcion = $_POST['descripcion'];
    if($descripcion == "")
    {
        $descripcion = null;
    }

    try 
    {
      	if($nombre != "")
        {
            if($id == null)
            {
                $sql = "INSERT INTO categorias(nombre_categoria, descripcion_categoria) VALUES(?, ?)";
                $params = array($nombre, $descripcion);
            }
            else
            {
                $sql = "UPDATE categorias SET nombre_categoria = ?, descripcion_categoria = ? WHERE id_categoria = ?";
                $params = array($nombre, $descripcion, $id);
            }
            if(Database::executeRow($sql, $params))
            {
                Page::showMessage(1, "Operación satisfactoria", "index.php");
            }
            else
            {
                throw new Exception(Database::$error[1]);
            }
        }
        else
        {
            throw new Exception("Debe digitar un nombre");
        }
    }
    catch (Exception $error)
    {
        Page::showMessage(2, $error->getMessage(), null);
    }
}
?>

<form method='post'>
    <div class='row'>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>note_add</i>
            <input id='nombre' type='text' name='nombre' class='validate' value='<?php print($nombre); ?>' required/>
            <label for='nombre'>Nombre</label>
        </div>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>description</i>
            <input id='descripcion' type='text' name='descripcion' class='validate' value='<?php print($descripcion); ?>'/>
            <label for='descripcion'>Descripción</label>
        </div>
    </div>
    <div class='row center-align'>
        <a href='index.php' class='btn waves-effect grey'><i class='material-icons'>cancel</i></a>
        <button type='submit' class='btn waves-effect blue'><i class='material-icons'>save</i></button>
    </div>
</form>

<?php
Page::footer();
?>