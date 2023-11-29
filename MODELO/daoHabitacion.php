<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18/11/2020
 * Time: 11:21 p.m.
 */

include_once '../MODELO/Conexion.php';

class daoHabitacion
{
    private $numero;


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
    function __constructArg($no)
    {
        $this->numero = $no;
    }

    function obtenerHabitacion(){
        $sql = "SELECT * FROM habitacion where numero=$this->numero;";
        $con = new Conexion();
        return $con ->devolverResultados($sql);
    }

    function registrarHabitacion(){
        $result = $this->obtenerHabitacion();
        if(is_array($result) && empty($result)){
            $sql = "INSERT INTO habitacion () VALUES ();"; //Esta consulta no recibe nada xq el valor correspondiente al numero de habitacion es autoincremntal y la habitacion por defecta comienza con estado disponible
            $con = new Conexion();
            $con -> ejecutarConsulta($sql);
        }
    }


    function obtenerTodasHabitaciones(){
        $sql = "SELECT * FROM habitacion;";
        $con = new Conexion();
        return $con ->devolverResultados($sql);
    }
}