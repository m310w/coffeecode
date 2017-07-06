<!DOCTYPE html>
<html lang='es'>
<head>
	<meta charset='utf-8'>
	<title>CoffeeCode</title>
	<link type='text/css' rel='stylesheet' href='../css/materialize.min.css'/>
	<link type='text/css' rel='stylesheet' href='../css/icons.css'/>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'/>
</head>
<body>
	<!-- Menú del sitio público -->
	<div class='navbar-fixed'>
		<nav class='green'>
			<div class='nav-wrapper'>
				<a href='index.php' class='brand-logo'><img src='../img/logo.png' height='60'></a>
				<a href='#' data-activates='mobile' class='button-collapse'><i class='material-icons'>menu</i></a>
				<ul class='right hide-on-med-and-down'>
					<li><a href='#productos'><i class='material-icons left'>view_module</i>Productos</a></li>
					<li><a href='#'><i class='material-icons left'>shopping_cart</i>Compras</a></li>
					<li><a href='#acceder'><i class='material-icons left'>person</i>Acceder</a></li>
				</ul>
			</div>
		</nav>
	</div>
	<!-- Menú lateral para dispositivos móviles -->
	<ul class='side-nav' id='mobile'>
		<li><a href='#productos'><i class='material-icons left'>view_module</i>Productos</a></li>
		<li><a href='#'><i class='material-icons left'>shopping_cart</i>Compras</a></li>
		<li><a href='#acceder'><i class='material-icons left'>person</i>Acceder</a></li>
	</ul>

	<!-- Slider con subtítulos e indicadores y con una altura de 400px -->
	<div class='slider'>
		<ul class='slides'>
			<li>
				<img src='img/slider/img01.jpg' alt='Foto01'>
				<div class='caption center-align'>
					<h2>¿Sabías que...?</h2>
					<h4 class='white-text'>El café reduce el riesgo de padecer Alzheimer.</h4>
				</div>
			</li>
			<li>
				<img src='img/slider/img02.jpg' alt='Foto02'>
				<div class='caption left-align'>
					<h2>¿Preocupado por tu peso?</h2>
					<h4>El café contribuye a reducir esos kilos de más.</h4>
				</div>
			</li>
			<li>
				<img src='img/slider/img03.jpg' alt='Foto03'>
				<div class='caption right-align'>
					<h2>¿Sabías que...?</h2>
					<h4 class='white-text'>El café reduce el riesgo de cáncer.</h4>
				</div>
			</li>
			<li>
				<img src='img/slider/img04.jpg' alt='Foto04'>
				<div class='caption center-align'>
					<h2>¿Quieres lucir radiante?</h2>
					<h4 class='white-text'>El café ayuda a tener una piel más perfecta.</h4>
				</div>
			</li>
		</ul>
	</div>

	<!-- Sección de productos -->
	<div class='container' id='productos'>
	<?php
	require("../lib/database.php");
	$sql = "SELECT * FROM categorias";
	$categorias = Database::getRows($sql, null);
	if($categorias != null)
	{
		print("<h4 class='center-align'><i class='material-icons'>local_cafe</i>NUESTROS PRODUCTOS<i class='material-icons'>local_cafe</i></h4>");
		foreach($categorias as $categoria) 
		{
			$sql = "SELECT * FROM productos WHERE id_categoria = ? AND estado_producto = 1";
			$params = array($categoria['id_categoria']);
			$productos = Database::getRows($sql, $params);
			if($productos != null)
			{
				print("<h4 class='center-align brown-text'>$categoria[nombre_categoria]</h4>");
				print("<div class='row'>");
				foreach($productos as $producto) 
				{
					print("
						<div class='card hoverable col s12 m6 l4'>
							<div class='card-image waves-effect waves-block waves-light'>
								<img class='activator' src='../img/products/$producto[imagen_producto]'>
							</div>
							<div class='card-content'>
								<span class='card-title activator grey-text text-darken-4'>$producto[nombre_producto]<i class='material-icons right'>more_vert</i></span>
								<p><a href='#'><i class='material-icons left'>loupe</i>Seleccionar</a></p>
							</div>
							<div class='card-reveal'>
								<span class='card-title grey-text text-darken-4'>$producto[nombre_producto]<i class='material-icons right'>close</i></span>
								<p>$producto[descripcion_producto]</p>
								<p>Precio (US$) $producto[precio_producto]</p>
							</div>
						</div>
					");
				}
				print("</div>");
			}
		}
	}
	else
	{
		print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay registros disponibles en este momento.</div>");
	}
	?>
	</div><!-- Fin de container -->

	<!-- Efecto parallax con una altura de 500px -->
	<div class='parallax-container'>
		<div class='parallax'><img src='img/parallax/img01.jpg'></div>
	</div>

	<!-- Formularios para acceder -->
	<div class='container' id='acceder'>
		<h4 class='center-align'>ACCEDER</h4>
		<ul class='tabs center-align'>
			<li class='tab'><a href='#cuenta'>CREAR CUENTA</a></li>
			<li class='tab'><a href='#sesion'>INICIAR SESIÓN</a></li>
		</ul>
		<!-- Formulario para nueva cuenta -->
		<div id='cuenta'>
			<form>
				<div class='row'>
					<div class='input-field col s12 m6'>
						<i class='material-icons prefix'>account_box</i>
						<input type='text' id='nombres' class='validate'>
						<label for='nombres'>Nombres</label>
					</div>
					<div class='input-field col s12 m6'>
						<i class='material-icons prefix'>account_box</i>
						<input type='text' id='apellidos' class='validate'>
						<label for='apellidos'>Apellidos</label>
					</div>
					<div class='input-field col s12 m6'>
						<i class='material-icons prefix'>email</i>
						<input type='email' id='correo' class='validate'>
						<label for='correo' data-error='Error' data-success='Bien'>Correo</label>
					</div>
					<div class='input-field col s12 m6'>
						<i class='material-icons prefix'>phone</i>
						<input type='text' id='telefono' class='validate'>
						<label for='telefono' data-error='Error' data-success='Bien'>Teléfono</label>
					</div>
					<div class='input-field col s12 m6'>
						<i class='material-icons prefix'>security</i>
						<input type='password' id='clave1' class='validate'>
						<label for='clave1' data-error='Error' data-success='Bien'>Contraseña</label>
					</div>
					<div class='input-field col s12 m6'>
						<i class='material-icons prefix'>security</i>
						<input type='password' id='clave2' class='validate'>
						<label for='clave2' data-error='Error' data-success='Bien'>Confirmar contraseña</label>
					</div>
					<div class='input-field col s12'>
						<i class='material-icons prefix'>place</i>
						<textarea id='textarea1' class='materialize-textarea'></textarea>
						<label for='textarea1'>Dirección</label>
					</div>
				</div>
				<div class='row center-align'>
					<div class='col s12'>
						<input type='checkbox' id='terminos'>
						<label for='terminos'>Acepto <a href='#terminos'>términos y condiciones</a></label>
					</div>
					<div class='col s12'>
						<button type='submit' class='btn waves-effect blue'><i class='material-icons'>send</i></button>
					</div>
				</div>
			</form>
		</div>
		<!-- Formulario para iniciar sesión -->
		<div id='sesion'>
			<form>
				<div class='row'>
					<div class='input-field col s12 m6 offset-m3'>
						<i class='material-icons prefix'>email</i>
						<input type='email' id='correo' class='validate'>
						<label for='correo' data-error='Error' data-success='Bien'>Correo</label>
					</div>
					<div class='input-field col s12 m6 offset-m3'>
						<i class='material-icons prefix'>security</i>
						<input type='password' id='clave' class='validate'>
						<label for='clave' data-error='Error' data-success='Bien'>Contraseña</label>
					</div>
				</div>
				<div class='row center-align'>
					<button type='submit' class='btn waves-effect blue'><i class='material-icons'>send</i></button>
				</div>
			</form>
		</div>
	</div>

	<!-- Efecto parallax con una altura de 500px -->
	<div class='parallax-container'>
		<div class='parallax'><img src='img/parallax/img02.jpg'></div>
	</div>

	<!-- Ventana modal de términos y condiciones -->
	<div id='terminos' class='modal'>
		<div class='modal-content'>
			<h4 class='center-align'>TÉRMINOS Y CONDICIONES</h4>
			<p>Nuestra empresa ofrece los mejores productos a nivel nacional con una calidad garantizada y...</p>
		</div>
		<div class='divider'></div>
		<div class='modal-footer'>
			<a href='#!' class='modal-action modal-close btn waves-effect'><i class='material-icons'>done</i></a>
		</div>
	</div>

	<!-- Ventana modal para la misión -->
	<div id='mision' class='modal'>
		<div class='modal-content'>
			<h4 class='center-align'>MISIÓN</h4>
			<p>Ofrecer los mejores productos a nivel nacional para satisfacer a nuestros clientes y...</p>
		</div>
		<div class='divider'></div>
		<div class='modal-footer'>
			<a href='#!' class='modal-action modal-close btn waves-effect'><i class='material-icons'>done</i></a>
		</div>
	</div>

	<!-- Ventana modal para la visión -->
	<div id='vision' class='modal'>
		<div class='modal-content'>
			<h4 class='center-align'>VISIÓN</h4>
			<p>Ser la empresa lider en la región ofreciendo productos de calidad a precios accesibles y...</p>
		</div>
		<div class='divider'></div>
		<div class='modal-footer'>
			<a href='#!' class='modal-action modal-close btn waves-effect'><i class='material-icons'>done</i></a>
		</div>
	</div>

	<!-- Ventana modal para los valores -->
	<div id='valores' class='modal'>
		<div class='modal-content center-align'>
			<h4>VALORES</h4>
			<p>Responsabilidad</p>
			<p>Honestidad</p>
			<p>Seguridad</p>
			<p>Calidad</p>
		</div>
		<div class='divider'></div>
		<div class='modal-footer'>
			<a href='#!' class='modal-action modal-close btn waves-effect'><i class='material-icons'>done</i></a>
		</div>
	</div>

	<!-- Pie de pagina del sitio público -->
	<footer class='page-footer green'>
		<div class='container'>
			<div class='row'>
				<div class='col s12 m6 l6'>
					<h5 class='white-text'>Nosotros</h5>
					<p>
						<blockquote><a class='white-text' href='#mision'><b>Misión</b></a></blockquote>
						<blockquote><a class='white-text' href='#vision'><b>Visión</b></a></blockquote>
						<blockquote><a class='white-text' href='#valores'><b>Valores</b></a></blockquote>
					</p>
				</div>
				<div class='col s12 m6 l6'>
					<h5 class='white-text'>Contáctanos</h5>
					<p>
						<blockquote><a class='white-text' href='https://www.facebook.com/' target='_blank'><b>facebook</b></a></blockquote>
						<blockquote><a class='white-text' href='https://twitter.com/?lang=es' target='_blank'><b>twitter</b></a></blockquote>
						<blockquote><a class='white-text' href='https://www.youtube.com/' target='_blank'><b>youtube</b></a></blockquote>
					</p>
				</div>
			</div>
		</div>
		<div class='footer-copyright'>
			<div class='container'>
				<?php print('<span>©'.date(' Y ').'CoffeeCode, todos los derechos reservados.</span>') ?>
				<span class='grey-text text-lighten-4 right'>Diseñado con <b><a class='red-text text-accent-1' href='http://materializecss.com/' target='_blank'>Materialize</a></b></span>
			</div>
		</div>
	</footer>

	<!-- Importación de archivos JavaScript -->
	<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
	<script type='text/javascript' src='../js/materialize.min.js'></script>
	<script type='text/javascript' src='js/public.js'></script>
</body>
</html>