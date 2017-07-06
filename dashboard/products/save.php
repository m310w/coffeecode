<?php
require("../lib/page.php");
if(empty($_GET['id'])) 
{
    Page::header("Agregar producto");
    $id = null;
    $nombre = null;
    $descripcion = null;
    $precio = null;
    $imagen = null;
    $estado = 1;
    $categoria = null;
}
else
{
    Page::header("Modificar producto");
    $id = $_GET['id'];
    $sql = "SELECT * FROM productos WHERE id_producto = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $nombre = $data['nombre_producto'];
    $descripcion = $data['descripcion_producto'];
    $precio = $data['precio_producto'];
    $imagen = $data['imagen_producto'];
    $estado = $data['estado_producto'];
    $categoria = $data['id_categoria'];
}

if(!empty($_POST))
{
    $_POST = Validator::validateForm($_POST);
  	$nombre = $_POST['nombre'];
  	$descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $archivo = $_FILES['archivo'];
    $estado = $_POST['estado'];
    $categoria = $_POST['categoria'];
    $imagen = $_POST['imagen'];

    try 
    {
        if($nombre != "")
        {
            if($precio != "")
            {
                if($precio > 0)
                {
                    if($descripcion != "")
                    {
                        if($categoria != "")
                        {
                            if(is_uploaded_file($archivo['tmp_name']))
                            {
                                $imagen = Validator::validateImage($archivo, $imagen, 1200, 1200);
                                $subir = true;
                            }
                            else
                            {
                                if($imagen == null)
                                {
                                    throw new Exception("Debe seleccionar un archivo de imagen");
                                }
                            }
                            if($id == null)
                            {
                                $sql = "INSERT INTO productos(nombre_producto, descripcion_producto, precio_producto, imagen_producto, estado_producto, id_categoria) VALUES(?, ?, ?, ?, ?, ?)";
                                $params = array($nombre, $descripcion, $precio, $imagen, $estado, $categoria);
                            }
                            else
                            {
                                $sql = "UPDATE productos SET nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, imagen_producto = ?, estado_producto = ?, id_categoria = ? WHERE id_producto = ?";
                                $params = array($nombre, $descripcion, $precio, $imagen, $estado, $categoria, $id);
                            }
                            if(Database::executeRow($sql, $params))
                            {
                                if($subir)
                                {
                                    if(Validator::uploadImage($archivo['tmp_name'], "../../img/products/", $imagen))
                                    {
                                        $mensaje = "Operación satisfactoria. Se guardo la imagen";
                                    }
                                    else
                                    {
                                        $mensaje = "Operación realizada. No se guardo la imagen";
                                    }
                                }
                                else
                                {
                                    $mensaje = "Operación satisfactoria";
                                }
                                Page::showMessage(1, $mensaje, "index.php");
                            }
                            else
                            {
                                throw new Exception(Database::$error[1]);
                            }
                        }
                        else
                        {
                            throw new Exception("Debe seleccionar una categoría");
                        }
                    }
                    else
                    {
                        throw new Exception("Debe digitar una descripción");
                    }
                }
                else
                {
                    throw new Exception("El precio debe ser mayor que 0.00");
                }
            }
            else
            {
                throw new Exception("Debe ingresar el precio");
            }
        }
        else
        {
            throw new Exception("Debe digitar el nombre");
        }
    }
    catch (Exception $error)
    {
        Page::showMessage(2, $error->getMessage(), null);
    }
}
?>

<form method='post' enctype='multipart/form-data'>
    <input type='hidden' name='imagen' value='<?php print($imagen); ?>'/>
    <div class='row'>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>note_add</i>
          	<input id='nombre' type='text' name='nombre' class='validate' value='<?php print($nombre); ?>' required/>
          	<label for='nombre'>Nombre</label>
        </div>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>shopping_cart</i>
          	<input id='precio' type='number' name='precio' class='validate' max='999.99' min='0.01' step='any' value='<?php print($precio); ?>' required/>
          	<label for='precio'>Precio ($)</label>
        </div>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>description</i>
          	<input id='descripcion' type='text' name='descripcion' class='validate' value='<?php print($descripcion); ?>'/>
          	<label for='descripcion'>Descripción</label>
        </div>
        <div class='input-field col s12 m6'>
            <?php
            $sql = "SELECT id_categoria, nombre_categoria FROM categorias";
            Page::setCombo("Categoría", "categoria", $categoria, $sql);
            ?>
        </div>
      	<div class='file-field input-field col s12 m6'>
            <div class='btn waves-effect'>
                <span><i class='material-icons'>image</i></span>
                <input type='file' name='archivo' <?php print(($imagen == null)?"required":""); ?>/>
            </div>
            <div class='file-path-wrapper'>
                <input class='file-path validate' type='text' placeholder='Seleccione una imagen'/>
            </div>
        </div>
        <div class='input-field col s12 m6'>
            <span>Estado:</span>
            <input id='activo' type='radio' name='estado' class='with-gap' value='1' <?php print(($estado == 1)?"checked":""); ?>/>
            <label for='activo'><i class='material-icons left'>visibility</i></label>
            <input id='inactivo' type='radio' name='estado' class='with-gap' value='0' <?php print(($estado == 0)?"checked":""); ?>/>
            <label for='inactivo'><i class='material-icons left'>visibility_off</i></label>
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