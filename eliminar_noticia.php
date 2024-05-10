<?php
// Imports
require_once('conexion.php');
require_once('funciones_bd.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se proporciona un ID de noticia
    if (isset($_POST['id_noticia'])) {
        // Obtener el ID de la noticia
        $id_noticia = $_POST['id_noticia'];

        // Conectar a la base de datos
        $db_connect = new DB_Connect();
        $db_connect->create_connection();
        $db_connection = $db_connect->get_connection();

        // Ejecutar la consulta de eliminación
        $db_functions = new DB_Functions($db_connection);
        $sql = "DELETE FROM noticia WHERE id = $id_noticia";
        $query = $db_functions->run_sql($sql);

        // Redirigir de vuelta a la página de inicio
        header("Location: /src/cuerpo.php");
        exit();
    } else {
        // Si no se proporciona un ID de noticia, redirigir a alguna página de error
        header("Location: /src/cuerpo.php");
        exit();
    }
} else {
    // Si no se envió una solicitud POST, redirigir a alguna página de error
    header("Location: /src/cuerpo.php");
    exit();
}
?>
