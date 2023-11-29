<?php
include_once '../MODELO/Conexion.php';
class daoNomenclador
{
    function __construct(){}

    public function obtenerSexos()
    {
        $sql = "SELECT * FROM sexo";
        $ob = new Conexion();
        return $ob->devolverResultados($sql);
    }

    public function obtenerHabitaciones()
    {
        $sql = "SELECT * FROM habitacion";
        $ob = new Conexion();
        return $ob->devolverResultados($sql);
    }


    public function obtenerTurOperadores()
    {
        $sql = "SELECT * FROM turoperador";
        $ob = new Conexion();
        return $ob->devolverResultados($sql);
    }

    public function obtenerNacionalidades()
    {
        $sql = "SELECT * FROM nacionalidad";
        $ob = new Conexion();
        return $ob->devolverResultados($sql);
    }
}