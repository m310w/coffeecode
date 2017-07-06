<?php
require("../lib/page.php");

$sql = "SELECT * FROM usuarios";
$data = Database::getRows($sql, null);
if($data == null)
{
    header("location: register.php");
}

Page::header("Iniciar sesión");
if(!empty($_POST))
{
	$_POST = validator::validateForm($_POST);
  	$alias = $_POST['alias'];
  	$clave = $_POST['clave'];
  	try
    {
      	if($alias != "" && $clave != "")
  		{
  			$sql = "SELECT * FROM usuarios WHERE alias_usuario = ?";
		    $params = array($alias);
		    $data = Database::getRow($sql, $params);
		    if($data != null)
		    {
		    	$hash = $data['clave_usuario'];
		    	if(password_verify($clave, $hash)) 
		    	{
					$_SESSION['id_usuario'] = $data['id_usuario'];
			      	$_SESSION['nombre_usuario'] = $data['nombres_usuario']." ".$data['apellidos_usuario'];
			      	Page::showMessage(1, "Autenticación correcta", "index.php");
				}
				else 
				{
					throw new Exception("La clave ingresada es incorrecta");
				}
		    }
		    else
		    {
		    	throw new Exception("El alias ingresado no existe");
		    }
	  	}
	  	else
	  	{
	    	throw new Exception("Debe ingresar un alias y una clave");
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
		<div class='input-field col s12 m6 offset-m3'>
			<i class='material-icons prefix'>person_pin</i>
			<input id='alias' type='text' name='alias' class='validate' required/>
	    	<label for='alias'>Usuario</label>
		</div>
		<div class='input-field col s12 m6 offset-m3'>
			<i class='material-icons prefix'>security</i>
			<input id='clave' type='password' name='clave' class="validate" required/>
			<label for='clave'>Contraseña</label>
		</div>
	</div>
	<div class='row center-align'>
		<button type='submit' class='btn waves-effect'><i class='material-icons'>send</i></button>
	</div>
</form>

<?php
Page::footer();
?>