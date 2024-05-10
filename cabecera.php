<div class="container">
    <h1 class="header">PERIÓDICO ONLINE</h1>
</div>
<div class="container" id="login-container">
<form id="form_login" action="" method="get" >
	  <label for="email">Email</label><br>
	  <input type="email" name="email" id="email" maxlength="40" required/>
	  <br>
	  <label for="password">Password</label><br>
	  <input type="password" name="contrasena" id="contrasena" maxlength="20" required />
	  <br>
	  <input type="submit" value="Inicio"/>
	  <br>
	  <input type="button" value="Si no estás registrado, pulsa aquí." onclick="window.location.href='/src/form_usuario.php';">
</form>
</div>
<?php
session_start(); // Iniciar la sesión

// Ocultar div para la página de registro
if (basename($_SERVER['PHP_SELF']) === 'form_usuario.php') {
	echo "<style>#login-container { display: none; }</style>";
}

// Verificar si se ha iniciado sesión
if (isset($_SESSION['id_usuario'])) {
	// Si hay una sesión activa, mostrar un mensaje de bienvenida y el botón de logout
	echo "<form id='form_logout' action='' method='post'>
		<div ><p>Bienvenido! </p>
		<input type='submit' name='logout' value='Cerrar sesión' >
		</form></div>";
		
	// Ocultar div si está iniciada la sesión
	echo "<style>#login-container { display: none; }</style>";

	// Verificar si se ha enviado una solicitud POST para cerrar sesión
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
		// Eliminar todas las variables de sesión
		session_unset();
		// Destruir la sesión
		session_destroy();
		// Redirigir a la página de inicio
		header("Location: /src/cuerpo.php");
		exit();
	}
}
// Imports
require_once('conexion.php');
require_once('funciones_bd.php');

// Conectar a la base de datos
$db_connect = new DB_Connect();
$db_connect->create_connection();
$db_connection = $db_connect->get_connection();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	// Verificar si se proporciona un ID de usuario
	if (isset($_GET['email'], $_GET['contrasena'])) {
		// Obtener el ID de la usuario
		$email = $_GET['email'];
		$contrasena = $_GET['contrasena'];

		// Ejecutar la consulta
		$db_functions = new DB_Functions($db_connection);//Caguen
		$sql = "SELECT id, nombre FROM usuario WHERE email = '$email' AND contrasena= '$contrasena'";
		$query = $db_functions->run_sql($sql);
		
		if (!(mysqli_num_rows($query) > 0)) {
			echo ("No hay registros con esa identificación.");
		} else {
			$result = mysqli_fetch_assoc($query);
			$_SESSION['id_usuario'] = $result['id'];// Almacenar el id en la sesión
			$user_session = $result['nombre']; // Obtener el nombre del usuario
			echo ("{$user_session}");
			header("Location: /src/cuerpo.php");
		}
	
	}
	
}
?>