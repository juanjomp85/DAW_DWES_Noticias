<?php

require_once("datos_conexion.php");

class DB_Connect {
    
    public function create_connection() {
        $db_conn = new mysqli(HOST,USER,PASSWORD,DATABASE);

        if ($db_conn->connect_errno) {
            $message = "La conexión con base de datos ha fallado: {$db_conn->connect_error}";
            
            die($message);
        }

        $db_conn->set_charset("UTF8");

        $this->db_connection = $db_conn;
    }

    public function get_connection() {
        return $this->db_connection;
    }
}
?>