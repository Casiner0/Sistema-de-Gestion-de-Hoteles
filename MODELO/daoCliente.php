<?php

include_once '../MODELO/Conexion.php';


class daoCliente
{
    private $nombre;

    private $edad;

    private $sexo;

    private $nacionalidad;

    private $reiterado;

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

    function __constructEmpty()
    {

    }

    //constructor que será invocado si se le pasan argumentos al llamar a esta clase
    function __constructArg($nombre, $edad, $sexo, $nacionalidad, $reiterado=false)
    {
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->sexo = $sexo;
        $this->nacionalidad = $nacionalidad;
        $this->reiterado = $reiterado;

    }

    public function setReiterado($reiterado)
    {
        $this->reiterado = $reiterado;
    }



    //Esta funcion devuelde los datos de los clientes a partir del objeto por la que es invocada.
    function obtenerClienteObjeto(){
        $sql = "SELECT * FROM cliente where nombre='$this->nombre' and sexo='$this->sexo' and edad='$this->edad' and nacionalidad='$this->nacionalidad';";
        $con = new Conexion();
        return $con ->devolverResultados($sql);
    }

    //Esta funcion devuelve los datos de los clientes que coinciden con los argumentos recibidos.
    function obtenerCliente($nombre,$sexo,$edad,$nacionalidad){
        $sql = "SELECT * FROM cliente where nombre='$nombre' and sexo='$sexo' and edad='$edad' and nacionalidad='$nacionalidad';";
        $con = new Conexion();
        return $con ->devolverResultados($sql);
    }

    //Esta funcion devuelve los datos de todos los clientes registrados.
    function obtenerTodosClientes(){
        $sql = "SELECT cliente.id_cliente,
       cliente.nombre,
       cliente.edad,
       cliente.reiterado,
       s.descripcion         as sexo,
       n.descripcion as nacionalidad, (SELECT count(*)
                                                 FROM reservacion
                                                        inner join habitacion
                                                          on reservacion.habitacion = habitacion.numero
                                                        left join turoperador
                                                          on reservacion.turoperador = turoperador.id_turoperador
                                                 where CURRENT_TIMESTAMP <= DATE_ADD(fecha_entrada, INTERVAL cantidad_dias DAY)
                                                   and CURRENT_TIMESTAMP >= fecha_entrada
                                                   and reservacion.cliente = cliente.id_cliente) 'cant_reserv_act'
FROM cliente inner join sexo s on cliente.sexo = s.id_sexo inner join nacionalidad n on cliente.nacionalidad = n.id_nacionalidad";
        $con = new Conexion();
        return $con -> devolverResultados($sql);
    }

    //Esta funcion devuelve los datos del cliente cuyo id coincide con el recibido como argumento.
    function obtenerClienteDadoId($idCliente){
        $sql = "SELECT * FROM cliente where id_cliente = '$idCliente'";
        $con = new Conexion();
        return $con ->devolverResultados($sql);
    }


    function registrarCliente(){
        $clientes = $this->obtenerClienteObjeto();
        if(is_array($clientes) && empty($clientes)){
            $sql = "INSERT INTO cliente (nombre,edad,sexo,nacionalidad) VALUES ('$this->nombre','$this->edad','$this->sexo','$this->nacionalidad');";
        }else
            $sql = "UPDATE cliente SET reiterado = '1' WHERE nombre = '$this->nombre' and edad ='$this->edad' and sexo='$this->sexo' and nacionalidad= '$this->nacionalidad'";
        $con = new Conexion();
        $con -> ejecutarConsulta($sql);
    }


    function actualizarClienteObjetoDadoId($idCliente){
        $sql = "UPDATE cliente set nombre = '$this->nombre', edad ='$this->edad', sexo='$this->sexo', nacionalidad= '$this->nacionalidad', reiterado='$this->reiterado' where id_cliente='$idCliente'";
        $con = new Conexion();
        $con -> ejecutarConsulta($sql);
    }

    function actualizarEstadoClienteObjetoDadoId($idCliente){
        $sql = "UPDATE cliente set reiterado='$this->reiterado' where id_cliente='$idCliente'";
        $con = new Conexion();
        $con -> ejecutarConsulta($sql);
    }

}