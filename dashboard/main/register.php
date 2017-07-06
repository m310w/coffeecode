<?php
require("../lib/page.php");

$sql = "SELECT * FROM usuarios";
$data = Database::getRows($sql, null);
if($data != null)
{
    header("location: login.php");
}

Page::header("Registrar primer usuario");
if(!empty($_POST))
{
    $_POST = Validator::validateForm($_POST);
  	$nombres = $_POST['nombres'];
  	$apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $alias = $_POST['alias'];
    $clave1 = $_POST['clave1'];
    $clave2 = $_POST['clave2'];

    try 
    {
      	if($nombres != "" && $apellidos != "")
        {
            if(Validator::validateEmail($correo))
            {
                if($alias != "")
                {
                    if($clave1 != "" && $clave2 != "")
                    {
                        if($clave1 == $clave2)
                        {
                            $clave = password_hash($clave1, PASSWORD_DEFAULT);
                            $sql = "INSERT INTO usuarios(nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario, clave_usuario) VALUES(?, ?, ?, ?, ?)";
                            $params = array($nombres, $apellidos, $correo, $alias, $clave);
                            if(Database::executeRow($sql, $params))
                            {
                                Page::showMessage(1, "Operación satisfactoria", "login.php");
                            }
                            else
                            {
                                throw new Exception(Database::$error);
                            }
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
else
{
    $nombres = null;
    $apellidos = null;
    $correo = null;
    $alias = null;
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
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>email</i>
            <input id='correo' type='email' name='correo' class='validate' value='<?php print($correo); ?>' required/>
            <label for='correo'>Correo</label>
        </div>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>person_pin</i>
            <input id='alias' type='text' name='alias' class='validate' value='<?php print($alias); ?>' required/>
            <label for='alias'>Alias</label>
        </div>
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
    <div class='row center-align'>
 	    <button type='submit' class='btn waves-effect'><i class='material-icons'>send</i></button>
    </div>
</form>

<?php
Page::footer();
?>