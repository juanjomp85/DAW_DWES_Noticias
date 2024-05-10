<?php
  $title = "Editar noticia";
  require_once("html_top.php");
?>

  <?php
require_once('conexion.php');
require_once('funciones_bd.php');

	// Conectar a la base de datos
    $db_connect = new DB_Connect();
    $db_connect->create_connection();
    $db_connection = $db_connect->get_connection();
	
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//var_dump($_POST);
    // Verificar si se recibieron los datos del formulario
    if (isset($_POST['id_noticia'], $_POST['titulo'], $_POST['cuerpo'], $_POST['id_autor'])) {
        // Obtener los datos del formulario
        $id_noticia = $_POST['id_noticia'];
        $titulo = $_POST['titulo'];
        $cuerpo = $_POST['cuerpo'];
        $id_autor = $_POST['id_autor'];

        // Preparar la consulta SQL para actualizar la noticia
        $db_functions = new DB_Functions($db_connection);
        $sql = "UPDATE noticia SET titulo='$titulo', cuerpo='$cuerpo', id_autor='$id_autor' WHERE id='$id_noticia'";

        // Ejecutar la consulta SQL
        $query = $db_functions->run_sql($sql);

        // Verificar si la actualización fue exitosa
        if ($query) {
            // Si la actualización fue exitosa, redirigir a la página de inicio
            header("Location: /src/cuerpo.php");
            exit();
        } else {
            // Si hubo un error en la actualización, mostrar un mensaje de error
            echo "Error: No se pudo actualizar la noticia.";
            exit();
        }
    } else {
        // Si no se recibieron todos los datos del formulario, mostrar un mensaje de error
        echo "Error: Datos del formulario incompletos.";
        exit();
    }
}


// Verificar si se recibió un ID de noticia en la URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_noticia'])) {
    // Obtener el ID de la noticia
    $id_noticia = $_GET['id_noticia'];

    // Consultar la noticia específica
    $db_functions = new DB_Functions($db_connection);
    $sql = "SELECT * FROM noticia WHERE id = $id_noticia";
    $query = $db_functions->run_sql($sql);
    $noticia = mysqli_fetch_assoc($query);

    // Verificar si se encontró la noticia
    if ($noticia) {
        // Asignar valores a las variables
        $titulo = $noticia['titulo'];
        $cuerpo = $noticia['cuerpo'];
        $id_autor = $noticia['id_autor'];
    } else {
        // Si no se encontró la noticia, mostrar un mensaje de error o redirigir a otra página
        echo "Error: No se encontró la noticia.";
        exit(); // Salir del script
    }
} else {
    // Si no se recibió un ID de noticia, mostrar un mensaje de error o redirigir a otra página
    echo "Error: No se proporcionó un ID de noticia en el GET.";
    exit(); // Salir del script
}
?>

<div class="container">
    <form id="form_noticia" action="" method="post">
        <input type="hidden" name="id_noticia" value="<?php echo $id_noticia; ?>">
        <label for="titulo">Titulo</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo $titulo; ?>" required>

        <label for="cuerpo">Cuerpo</label>
        <textarea name="cuerpo" id="cuerpo" cols="30" rows="10" required><?php echo $cuerpo; ?></textarea>

        <!--<label for="id_autor">Autor</label>-->
        <input type="hidden" name="id_autor" id="id_autor" value="<?php echo $id_autor; ?>" required >

        <input type="submit" value="Actualizar">
    </form>
</div>
<div class="container">
	<input type="button" value="Volver" onclick="window.location.href='/src/cuerpo.php';">
</div>

<?php
  require_once("html_bottom.php");
?>