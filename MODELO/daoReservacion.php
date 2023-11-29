<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18/11/2020
 * Time: 11:21 p.m.
 */

include_once '../MODELO/Conexion.php';

class daoReservacion
{

    private $idReservacion;

    private $codigo;

    private $cliente;

    private $turoperador;

    private $habitacion;

    private $fechaEntrada;

    private $cantidadDias;

    private $pertenecetur;

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

    //constructor que será invocado si se le pasan argumentos al llamar esta clase
    public function __constructArg($cliente, $habitacion, $cantidadDias,$fechaEntrada=null,$turoperador='null', $pertenecetur=0)
    {
        $this->codigo = $cliente.$habitacion.date('dmyhis'); // $idCliente + $noHabitacion + dia + mes + anno + hour + min + seg
        $this->cliente = $cliente;
        $this->turoperador = $turoperador;
        $this->habitacion = $habitacion;
        $this->fechaEntrada = !is_null($fechaEntrada)&&!empty($fechaEntrada)?($fechaEntrada.' 09:00:00'):date('Y-m-d 09:00:00');
        $this->cantidadDias = $cantidadDias;
        $this->pertenecetur = $pertenecetur;
    }

    //constructor que será invocado si no se le pasan argumentos al llamar esta clase
    function __constructEmpty(){}

    //Permite obtener los datos de las reservaciones en el sistema
    function obtenerElemento($filtros = array())
    {
        $sql = "
         SELECT *
         FROM
              reservacion,
              habitacion,
              cliente,
              nacionalidad
         WHERE
              reservacion.habitacion=habitacion.numero and
              reservacion.cliente = cliente.id_cliente and 
              cliente.nacionalidad = nacionalidad.id_nacionalidad
             ";
        if (isset($filtros['idReservacion']))
            $sql .= " and reservacion.id_reservacion ='" . $filtros['idReservacion'] . "'";
        if (isset($filtros['codigo']))
            $sql .= " and reservacion.codigo ='" . $filtros['codigo'] . "'";
        if (isset($filtros['fechaEntrada']))
            $sql .= " and reservacion.fecha_entrada ='" . $filtros['fechaEntrada'] . "'";
        if (isset($filtros['cantidadDias']))
            $sql .= " and reservacion.cantidad_dias = '" . $filtros['cantidadDias'] . "'";
        if (isset($filtros['habitacion']))
            $sql .= " and reservacion.habitacion ='" . $filtros['habitacion'] . "'";
        if (isset($filtros['conTurOperador']) && is_bool($filtros['conTurOperador']))
            $sql .= " and reservacion.turoperador ". ($filtros['conTurOperador']?'is not null ':'is null ');
        if (isset($filtros['turoperador']))
            $sql .= " and reservacion.turoperador =". $filtros['turoperador'];
        if (isset($filtros['pertenecetur']))
            $sql .= " and reservacion.pertenece_tur ='" . $filtros['pertenecetur'] . "'";
        if (isset($filtros['cliente']))
            $sql .= " and cliente.id_cliente ='" . $filtros['cliente'] . "'";
        if (isset($filtros['nacionalidad']) && !empty($filtros['nacionalidad']))
            $sql .= " and cliente.nacionalidad ='" . $filtros['nacionalidad'] . "'";
        if (isset($filtros['rangoFechaI']) && isset($filtros['rangoFechaF'])){
            $fechaEntrada = $filtros['rangoFechaI'];
            $cantDias = $filtros['rangoFechaF'];
            if(is_numeric($cantDias))
                $fechaF = "DATE_ADD('".$fechaEntrada."',INTERVAL ".$cantDias." DAY)";
            else
                $fechaF =  "'".$cantDias."'";
            $fechaI = "'".$fechaEntrada."'";
            $fechaIBD = "fecha_entrada";
            $fechaFBD = "DATE_ADD(fecha_entrada, INTERVAL cantidad_dias DAY)";


            $fechaIMenorIBD = $fechaI."<=".$fechaIBD;
            $fechaFMayorIBD = $fechaF.">=".$fechaIBD;
            $fechaIMayorFBD = $fechaI.">=".$fechaIBD;
            $fechaIMenorFBD = $fechaI."<=".$fechaFBD;
            $fechaFMayorFBD = $fechaF.">=".$fechaFBD;
            $fechaFMenorFBD = $fechaF."<=".$fechaFBD;

            $caso2 = $fechaIMenorFBD." and ".$fechaFMayorFBD;
            $caso3 = $fechaIMayorFBD." and ".$fechaFMenorFBD;

            $caso14 = $fechaIMenorIBD." and (".$fechaFMayorIBD." or ".$fechaFMayorFBD.")";

            $sqlFecha = "(".$caso2.") or (".$caso3.") or (".$caso14.")";

            $sql .= "and (".$sqlFecha.")";
        }
        $con = new Conexion();
//        print_r($sql);
//        exit;
        return $con->devolverResultados($sql);
    }

    function registrarElemento()
    {
            try{
            $sql = "INSERT INTO reservacion (codigo,fecha_entrada,cantidad_dias,habitacion,cliente,pertenece_tur,turoperador) VALUES ('$this->codigo','$this->fechaEntrada','$this->cantidadDias','$this->habitacion','$this->cliente','$this->pertenecetur',$this->turoperador);";
            $db = new Conexion();
            $db->ejecutarConsulta($sql);

            return true;
            }catch (Exception $exception){
                return $exception->getMessage();
            }
    }

    function obtenerTodasReservaciones()
    {
        $sql = "SELECT reservacion.id_reservacion,
       reservacion.codigo,
       reservacion.habitacion,
       reservacion.fecha_entrada,
       reservacion.cantidad_dias,
       cliente.nombre as nombre_cliente,
       turoperador.nombre as nombre_turoperador
        FROM reservacion
       INNER JOIN cliente on reservacion.cliente = cliente.id_cliente
       inner join habitacion on reservacion.habitacion = habitacion.numero
       left join turoperador on reservacion.turoperador = turoperador.id_turoperador
       ORDER BY reservacion.id_reservacion DESC 
       ";
        $con = new Conexion();
        return $con->devolverResultados($sql);
    }

    function eliminarreservacion($id_reservacion)
    {
        $sql = "delete from reservacion where id_reservacion='$id_reservacion'";
        $con = new conexion();
        $con->ejecutarConsulta($sql);
    }

    function actualizarReservacionObjetoDadoCodigo($codigo)
    {
        $sql = "UPDATE reservacion set 
                    cantidad_dias='$this->cantidadDias', 
                    fecha_entrada='$this->fechaEntrada' 
                where codigo=$codigo";
        $con = new Conexion();
        $con->ejecutarConsulta($sql);
    }

    function obtenerClienteDadoIdReservacion($idReservacion)
    {

        $sql = "SELECT 
                 A.id_cliente, 
                 A.nombre, 
                 A.edad, 
                 sexo.descripcion as sexo,
                 nacionalidad.descripcion as nacionalidad 
                FROM
                 reservacion,
                 cliente A,
                 sexo, 
                 nacionalidad
                WHERE 
                 A.id_cliente = reservacion.cliente and
                 A.sexo = sexo.id_sexo  and 
                 A.nacionalidad = nacionalidad.id_nacionalidad and  reservacion.id_reservacion='".$idReservacion."'";
        $con = new Conexion();
        $cliente = $con->devolverResultados($sql);
        return $cliente;
    }

    function obtenerHabitacionesSinReservacionActual(){
        $sql = "SELECT habitacion.*
FROM habitacion
where habitacion.numero not in (SELECT habitacion.numero
       FROM reservacion
                   INNER JOIN cliente on reservacion.cliente = cliente.id_cliente
                   inner join habitacion on reservacion.habitacion = habitacion.numero
                   left join turoperador on reservacion.turoperador = turoperador.id_turoperador
       where CURRENT_TIMESTAMP <= DATE_ADD(fecha_entrada, INTERVAL cantidad_dias DAY)
         and CURRENT_TIMESTAMP >= fecha_entrada)";
        $con = new Conexion();
        return $con -> devolverResultados($sql);
    }

    //Esta funcion permite obtener los datos de los clientes que reservaron con turoperador a partir del codigo del mismo
    function obtenerClientesTuroperadorDadoCodigo($codigoTuroperador){
        $sql = "SELECT reservacion.fecha_entrada,cliente.nombre cliente_nombre,turoperador.codigo turoperador_codigo, turoperador.nombre turoperador_nombre, reservacion.pertenece_tur turoperador_pertenece, turoperador.codigo FROM reservacion,cliente,turoperador where reservacion.cliente=cliente.id_cliente and reservacion.turoperador=turoperador.id_turoperador and turoperador.codigo".($codigoTuroperador!=''?"='".$codigoTuroperador."'":' is not null')." order by reservacion.fecha_entrada asc";
        $con = new Conexion();
        return $con ->devolverResultados($sql);
    }

    static function obtenerHabitacionDisponible($habitacion=0,$fechaEntrada = 'CURRENT_TIMESTAMP', $cantDias=0,$idReservacion=null){
        $sql = "SELECT habitacion.*
       FROM reservacion
                   INNER JOIN cliente on reservacion.cliente = cliente.id_cliente
                   inner join habitacion on reservacion.habitacion = habitacion.numero
                   left join turoperador on reservacion.turoperador = turoperador.id_turoperador ";
        if($fechaEntrada!='CURRENT_TIMESTAMP'){
//            $sql.= " where DATE_ADD('".$fechaEntrada."',INTERVAL ".$cantDias." DAY) <= DATE_ADD(fecha_entrada, INTERVAL cantidad_dias DAY)
//         and  DATE_ADD('".$fechaEntrada."',INTERVAL ".$cantDias." DAY) >= fecha_entrada";
            $fechaF = "DATE_ADD('".$fechaEntrada."',INTERVAL ".$cantDias." DAY)";
        }
        else{
//            $sql.= " where DATE_ADD(".$fechaEntrada.",INTERVAL ".$cantDias." DAY) <= DATE_ADD(fecha_entrada, INTERVAL cantidad_dias DAY)
//         and  DATE_ADD(".$fechaEntrada.",INTERVAL ".$cantDias." DAY) >= fecha_entrada";
            $fechaF = "DATE_ADD(".$fechaEntrada.",INTERVAL ".$cantDias." DAY)";

        }

        $fechaI = "'".$fechaEntrada."'";
        $fechaIBD = "fecha_entrada";
        $fechaFBD = "DATE_ADD(fecha_entrada, INTERVAL cantidad_dias DAY)";


        $fechaIMenorIBD = $fechaI."<=".$fechaIBD;
        $fechaFMayorIBD = $fechaF.">=".$fechaIBD;
        $fechaIMayorFBD = $fechaI.">=".$fechaIBD;
        $fechaIMenorFBD = $fechaI."<=".$fechaFBD;
        $fechaFMayorFBD = $fechaF.">=".$fechaFBD;
        $fechaFMenorFBD = $fechaF."<=".$fechaFBD;


        $caso2 = $fechaIMenorFBD." and ".$fechaFMayorFBD;
        $caso3 = $fechaIMayorFBD." and ".$fechaFMenorFBD;

//        $caso1 = "(".$fechaFMayorIBD." and ".$fechaIMenorIBD.")";
//        $caso4 = "(".$fechaFMayorFBD." and ".$fechaIMenorIBD.")";

        $caso14 = $fechaIMenorIBD." and (".$fechaFMayorIBD." or ".$fechaFMayorFBD.")";

        $sqlFecha = "(".$caso2.") or (".$caso3.") or (".$caso14.")";

//
//        $fechaIMenorFBD= "(".$fechaIMenorFBD." or ".$fechaFMayorFBD.")";

        $sql.="WHERE (".$sqlFecha.")";
         if($habitacion>0)
             $sql.=" and habitacion.numero =$habitacion";
        if ($idReservacion!=null)
             $sql.=" and reservacion.id_reservacion !=$idReservacion";
        $con = new Conexion();

//        return $sql;
        $result =  $con -> devolverResultados($sql);
        if($habitacion>0){
            if(count($result)>0){
                return false;
            }else{
                return true;
            }
        }
        return $result;
    }




}