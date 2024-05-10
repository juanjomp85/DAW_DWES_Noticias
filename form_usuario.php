<?php
  $title = "Formulario usuario";
  require_once("html_top.php");
?>
  <div class="container" >
  <form id="form_usuario" action="" method="post">

      <label for="nombre">Nombre</label>
      <input type="text" name="nombre" id="nombre" maxlength="20" required />

      <label for="password">Password</label>
      <input type="password" name="contrasena" id="contrasena" maxlength="20" required />

      <label for="email">Email</label>
      <input type="email" name="email" id="email" maxlength="40" />

      <input type="submit" value="Enviar" />
  </form>
  </div>
  <div class="container">
	<input type="button" value="Volver" onclick="window.location.href='/src/cuerpo.php';">
  </div>
  <?php
  // Imports
  require_once('conexion.php');
  require_once('funciones_bd.php');

  $db_connect = new DB_Connect();
  $db_connect->create_connection();
  $db_connection = $db_connect->get_connection();

  $db_functions = new DB_Functions($db_connection);


  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nombre = $email = $contrasena  = "";
      $error_message_required_form_data = "Por favor, introduce todos los datos requeridos del formulario.";

      if (!empty($_POST["nombre"])) {
        $nombre = "\"{$_POST["nombre"]}\"";
      } else {
          die($error_message_required_form_data);
      }
	  
	  if (!empty($_POST["email"])) {
        $email = "\"{$_POST["email"]}\"";
      } else {
          die($error_message_required_form_data);
      }

      if (!empty($_POST["contrasena"])) {
        $contrasena = "\"{$_POST["contrasena"]}\"";
      } else {
          die($error_message_required_form_data);
      }
      
      // Code
      $sql = "INSERT INTO usuario (nombre, email, contrasena) VALUES ({$nombre}, {$email}, {$contrasena});";

      $query = $db_functions->run_sql($sql);

      echo "Enviado correctamente.";
  }
  ?>

<?php
  require_once("html_bottom.php");
?>