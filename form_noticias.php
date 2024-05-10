<?php
  $title = "Formulario noticia";
  require_once("html_top.php");
?>
  <div class="container">
  <form id="form_usuario" action="" method="post">

      <label for="titulo">Titulo</label>
      <input type="text" name="titulo" id="titulo" maxlength="60" required />

      <label for="cuerpo">Cuerpo</label>
      <textarea name="cuerpo" id="cuerpo" cols="30" rows="10" maxlength="300" required></textarea>

      <!--<label for="id_autor">Autor</label>-->
      <input type="hidden" name="id_autor" id="id_autor" maxlength="20" value="" required />

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
      $titulo = $cuerpo = $id_autor = $fecha = "";
      $error_message_required_form_data = "Por favor, introduce todos los datos requeridos del formulario.";

      if (!empty($_POST["titulo"])) {
        $titulo = "\"{$_POST["titulo"]}\"";
      } else {
          die($error_message_required_form_data);
      }

      if (!empty($_POST["cuerpo"])) {
        $cuerpo = "\"{$_POST["cuerpo"]}\"";
      } else {
          die($error_message_required_form_data);
      }

      if (!empty($_POST["id_autor"])) {
        $id_autor = "\"{$_POST["id_autor"]}\"";
      } else {
		  $id_autor = $_SESSION['id_usuario'];
      }

      if (!empty($_POST["fecha"])) {
        $fecha = "\"{$_POST["fecha"]}\"";
      } else {
          $fecha = "CURRENT_TIMESTAMP";
      }
      
      // Code
      $sql = "INSERT INTO noticia (titulo, cuerpo, id_autor, fecha) VALUES ({$titulo}, {$cuerpo}, {$id_autor}, {$fecha});";

      $query = $db_functions->run_sql($sql);

      echo "Enviado correctamente.";
  }
  ?>

<?php
  require_once("html_bottom.php");
?>