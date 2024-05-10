<?php
    $title = "Ultimos posts";
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
	
	// Definir campos y orden predeterminado
    $campos_validos = array("titulo", "id_autor", "fecha" );
    $orden_predeterminado = "fecha DESC"; // Ordenar por fecha descendente por defecto

    // Verificar si se ha pasado un campo y un orden a través de la URL
    $campo = isset($_GET['campo']) ? $_GET['campo'] : "";
    $orden = isset($_GET['orden']) ? $_GET['orden'] : "";

    // Verificar si el campo y el orden son válidos
    if (!empty($campo) && in_array($campo, $campos_validos)) {
        $orden = in_array(strtoupper($orden), array('ASC', 'DESC')) ? strtoupper($orden) : 'ASC'; // Verificar si el orden es válido (ASC o DESC)
        $orden_predeterminado = "$campo $orden";
    }

    // Consulta SQL
    $sql = "SELECT noticia.id, noticia.id_autor, noticia.titulo, noticia.fecha, usuario.nombre AS autor
			FROM noticia
			JOIN usuario ON noticia.id_autor = usuario.id ORDER BY $orden_predeterminado LIMIT 10;";

    $query = $db_functions->run_sql($sql);

    if (!(mysqli_num_rows($query) > 0)) {
        die("No hay registros.");
    }

    echo
        "<div class='container'>
		<table>
            <thead>
                <tr>
                    <th><a href='?campo=titulo&orden=" . ($campo == 'titulo' && $orden == 'ASC' ? 'DESC' : 'ASC') . "'>Titulo</a></th>
                    <th><a href='?campo=id_autor&orden=" . ($campo == 'id_autor' && $orden == 'ASC' ? 'DESC' : 'ASC') . "'>Autor</a></th>
                    <th><a href='?campo=fecha&orden=" . ($campo == 'fecha' && $orden == 'ASC' ? 'DESC' : 'ASC') . "'>Fecha de creación</a></th>
                </tr>
            </thead>
            <tbody>";

    while ($row = mysqli_fetch_array($query)) {
        echo
            "   <tr>
                    <td><a href='/src/noticia.php?id={$row['id']}'>{$row['titulo']}</a></td>
                    <td>{$row['autor']}</td>
                    <td>{$row['fecha']}</td>";
					// Verifica si el usuario ha iniciado sesión y si el usuario es el autor de la noticia
					if (isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] == $row['id_autor']) {
							// El usuario es el autor de la noticia, se muestran los botones de editar y borrar
							echo "
							<td>
								<form method='GET' action='/src/editar_noticia.php'>
									<input type='hidden' name='id_noticia' value='{$row['id']}'>
									<input type='submit' value='EDITAR'>
								</form>
							</td>
							<td>
								<form method='POST' action='/src/eliminar_noticia.php'>
									<input type='hidden' name='id_noticia' value='{$row['id']}'>
									<input type='submit' value='BORRAR'>
								</form>
							</td>";
						//} 
					}
                echo "</tr>";
    }

    echo "  </tbody>
        </table>
		</div>";
		
	// Verificar si se ha iniciado sesión para el botón de añadir
	if (isset($_SESSION['id_usuario'])) {
		echo
            "<div class='container'>
				<input type='button' value='AÑADIR' onclick=\"window.location.href='/src/form_noticias.php';\">
			</div>";
	}
	?>

<?php
    require_once("html_bottom.php");
?>