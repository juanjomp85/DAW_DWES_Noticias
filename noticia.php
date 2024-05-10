<?php
    $title = "Detalles de la Noticia";
    require_once("html_top.php");
?>
    <?php
    // Imports
    require_once('conexion.php');
    require_once('funciones_bd.php');

    $db_connect = new DB_Connect();
    $db_connect->create_connection();
    $db_connection = $db_connect->get_connection();

    $db_functions = new DB_Functions($db_connection);

    // Code
	$id_noticia = $_GET['id'];
	
    //$sql = "SELECT * FROM noticia where id=$id_noticia;";
	$sql = "SELECT noticia.id, noticia.id_autor, noticia.titulo, noticia.cuerpo,  noticia.fecha, usuario.nombre AS autor
			FROM noticia
			JOIN usuario ON noticia.id_autor = usuario.id where noticia.id=$id_noticia;";

    $query = $db_functions->run_sql($sql);

    if (!(mysqli_num_rows($query) > 0)) {
        die("No hay registros con esa identificación.");
    }

    echo
        "<div class='container'>
		<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Cuerpo</th>
                    <th>Autor</th>
                    <th>Fecha de creacion</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = mysqli_fetch_array($query)) {
        echo
            "   <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['titulo']}</td>
                    <td>{$row['cuerpo']}</td>
                    <td>{$row['autor']}</td>
                    <td>{$row['fecha']}</td>
                </tr>";
    }

    echo "  </tbody>
        </table>
		</div>";
    ?>
	<div class="container">
		<input type="button" value="Volver" onclick="window.location.href='/src/cuerpo.php';">
	</div>
<?php
    require_once("html_bottom.php");
?>