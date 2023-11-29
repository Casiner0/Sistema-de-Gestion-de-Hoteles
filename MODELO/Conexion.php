<?php

/**
 * Class conexion
 *
 * Esta clase esta hecha con los metodos de "mysqli_" para asegurar compatibilidad con PHP 7.0+
 */

class Conexion{

    public $conexion;

    /**
     * @var mysqli
     */
    private $conn;

    private $host;
    private $user;
    private $password;
    private $baseName;
    private $port;

    function __construct()
    {
        $this->conn = false;
        $this->host = "localhost"; // host
        $this->user = "root"; // usuario
        $this->password = ""; // password
        $this->baseName = "hotel"; // nombre de la BD
        $this->port = 3306; 
        $this->conectar();
    }

    function conectar()
    {
        if (!$this->conn) {

            $this->conn = mysqli_connect($this->host, $this->user, $this->password);
            mysqli_select_db($this->conn, $this->baseName);

            if (!$this->conn) {
                $this->status_fatal = true;
                throw new Exception('Error en conexi&oacute;n con BD. Compruebe que su BD cargado el fichero hotel.sql correctamente y que la configuraci&oacute;n de la aplicaci&oacute;n sea correcta.');
            } else {
                $this->status_fatal = false;
            }


        }
    }

    function ejecutarConsulta($sql)
    {
        // Con mysql_ se ponen los parametros de forma inversa
        // el parametro de la conexion es opcional
        $r = mysqli_query($this->conn, $sql);


        return $r;
    }

    function devolverResultados($sql)
    {
        $r = $this->ejecutarConsulta($sql);
        $output = array();

        while ($r != false && $record = mysqli_fetch_assoc($r)) {
            $output[] = $record;
        }

        return $output;
    }


    function cerrarConexion()
    {
        // Con mysql_ el parametro de la conexion es opcional
        mysqli_close($this->conn);
    }

}

?>
