<?php
require("../lib/page.php");
if(empty($_GET['id'])) 
{
    Page::header("Agregar usuario");
    $id = null;
    $nombres = null;
    $apellidos = null;
    $correo = null;
    $alias = null;
}
else
{
    Page::header("Modificar usuario");
    $id = $_GET['id'];
    $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $nombres = $data['nombres'];
    $apellidos = $data['apellidos'];
    $correo = $data['correo'];
    $alias = $data['alias'];
}

if(!empty($_POST))
{
    $_POST = Validator::validateForm($_POST);
  	$nombres = $_POST['nombres'];
  	$apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];

    try 
    {
      	if($nombres != "" && $apellidos != "")
        {
            if(Validator::validateEmail($correo))
            {
                if($id == null)
                {
                    $alias = $_POST['alias'];
                    if($alias != "")
                    {
                        $clave1 = $_POST['clave1'];
                        $clave2 = $_POST['clave2'];
                        if($clave1 != "" && $clave2 != "")
                        {
                            if($clave1 == $clave2)
                            {
                                $clave = password_hash($clave1, PASSWORD_DEFAULT);
                                $sql = "INSERT INTO usuarios(nombres, apellidos, correo, alias, clave) VALUES(?, ?, ?, ?, ?)";
                                $params = array($nombres, $apellidos, $correo, $alias, $clave);
                            }
                            else
                            {
                                throw new Exception("Las contraseñas no coinciden");
                            }
                        }
                        else
                        {
                            throw new Exception("Debe ingresar ambas contraseñas");
                        }
                    }
                    else
                    {
                        throw new Exception("Debe ingresar un alias");
                    }
                }
                else
                {
                    $sql = "UPDATE usuarios SET nombres = ?, apellidos = ?, correo = ? WHERE id_usuario = ?";
                    $params = array($nombres, $apellidos, $correo, $id);
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
                throw new Exception("Debe ingresar un correo electrónico válido");
            }
        }
        else
        {
            throw new Exception("Debe ingresar el nombre completo");
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
          	<i class='material-icons prefix'>person</i>
          	<input id='nombres' type='text' name='nombres' class='validate' value='<?php print($nombres); ?>' required/>
          	<label for='nombres'>Nombres</label>
        </div>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>person</i>
            <input id='apellidos' type='text' name='apellidos' class='validate' value='<?php print($apellidos); ?>' required/>
            <label for='apellidos'>Apellidos</label>
        </div>
    </div>
    <div class='row'>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>email</i>
            <input id='correo' type='email' name='correo' class='validate' value='<?php print($correo); ?>' required/>
            <label for='correo'>Correo</label>
        </div>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>person_pin</i>
            <input id='alias' type='text' name='alias' class='validate' <?php print("value='$alias' "); print(($id == null)?"required":"disabled"); ?>/>
            <label for='alias'>Alias</label>
        </div>
    </div>
    <?php
    if($id == null)
    {
    ?>
    <div class='row'>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>security</i>
            <input id='clave1' type='password' name='clave1' class='validate' required/>
            <label for='clave1'>Contraseña</label>
        </div>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>security</i>
            <input id='clave2' type='password' name='clave2' class='validate' required/>
            <label for='clave2'>Confirmar contraseña</label>
        </div>
    </div>
    <?php
    }
    ?>
    <div class='row center-align'>
        <a href='index.php' class='btn waves-effect grey'><i class='material-icons'>cancel</i></a>
        <button type='submit' class='btn waves-effect blue'><i class='material-icons'>save</i></button>
    </div>
</form>

<?php
Page::footer();
?>