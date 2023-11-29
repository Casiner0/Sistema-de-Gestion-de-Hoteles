<?php
include 'Conexion.php';

class daoTurOperador
{
    private $nacionalidad;

    private $nombre;

    private $codigo;


    function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if ($i > 0) {
            call_user_func_array(array($this, '__constructArg'), $a);
        } else {
            call_user_func_array(array($this, '__constructEmpty'), $a);
        }
    }

    //constructor que será invocado si no se le pasan argumentos al llamar esta clase
    function __constructEmpty()
    {

    }

    //constructor que será invocado si se le pasan argumentos al llamar esta clase
    function __constructArg($nombre,$nacionalidad,$codigo)
    {
        $this->nombre = $nombre;
        $this->nacionalidad = $nacionalidad;
        $this->codigo = $codigo;
    }

    function obtenerTurOperador(){
        $sql = "SELECT * FROM turoperador where nombre=$this->nombre and nacionalidad=$this->nacionalidad and codigo=$this->codigo;";
        $con = new Conexion();
        return $con ->devolverResultados($sql);
    }

    function insertarTurOperador(){
        
        $sql = "INSERT INTO turoperador (nombre,codigo,nacionalidad) VALUES ('$this->nombre','$this->codigo','$this->nacionalidad')"; 
        //Esta consulta no recibe nada xq el valor correspondiente al numero de habitacion es autoincremntal y la habitacion por defecta comienza con estado disponible
        $con = new Conexion();
        $con -> ejecutarConsulta($sql);
        
    }


}