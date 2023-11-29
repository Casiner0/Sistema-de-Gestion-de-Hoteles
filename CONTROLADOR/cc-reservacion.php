<?php
include '../MODELO/daoReservacion.php';
include '../MODELO/daoHabitacion.php';
include '../MODELO/daoCliente.php';
if (!isset($_SESSION))
    session_start();
extract($_REQUEST);

if ((!isset($_SESSION['nombre']) || (!isset($listar) && !isset($insertar) && !isset($eliminar) && !isset($editar))) && !isset($method)){
    header('Location: ../VISTA/plantilla.php?opcion=1');
}


if (isset($listar)) {
    $reservaObj = new daoReservacion();
    $reservas = $reservaObj->obtenerTodasReservaciones();
}

if (isset($insertar)) {

    $reservaObj = new daoReservacion();
    if ($insertar == 'insertar' && $_SERVER['REQUEST_METHOD'] == "POST") {

        if (daoReservacion::obtenerHabitacionDisponible($numero_habitacion, $fecha_entrada, $cant_dias) == true) {
            if (isset($id_cliente) && strtoupper($id_cliente) == 'OTRO') {//Si el cliente es nuevo entonces lo registro
                $clienteObj = new daoCliente($nombre_client, $edad_cliente, $sexo_cliente, $nacionalidad_cliente);
                $clienteObj->registrarCliente();
                $clienteObjData = $clienteObj->obtenerClienteObjeto();
                $id_cliente = $clienteObjData[0]['id_cliente'];
                $newClient = true;
            }else{
                $newClient = false;
                $clienteObj = new daoCliente();
            }
            if (isset($id_turoperador) && !empty($id_turoperador)) {
                $reservaObj = new daoReservacion($id_cliente, $numero_habitacion, $cant_dias, $fecha_entrada, $id_turoperador, $pertenece_tur);
                $list = 'ctur';
            } else {
                $list = 'stur';
                $reservaObj = new daoReservacion($id_cliente, $numero_habitacion, $cant_dias, $fecha_entrada);
            }

            $success = $reservaObj->registrarElemento();

            if (!is_bool($success)) {
                $_SESSION['error'] = "El cliente <b>" . $success[0]['nombre'] . "</b> tiene reservada la <b>habitacion # " . $success[0]['numero'] . "</b> vigente en el periodo seleccionado, no se permite varias reservaciones en un mismo periodo.";

                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else{

                if(!$newClient){
                    $clienteObj->setReiterado(true);
                    $clienteObj->actualizarEstadoClienteObjetoDadoId($id_cliente);
                }
                header('Location: ../VISTA/plantilla.php?opcion=1&'.$list);
            }
        } else {

            $_SESSION['error'] = "La habitaci&oacute;n <b># $numero_habitacion</b> no est&aacute; disponible en el tiempo seleccionado.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }

    }

    if (isset($cliente)) {
        $clienteObj = new daoCliente();
        $clienteObjData = $clienteObj->obtenerClienteDadoId($cliente);
        if (count($clienteObjData) == 1) {
            //DATOS DEL CLIENTE
            $nombreCliente = $clienteObjData[0]['nombre'];
            $edadCliente = $clienteObjData[0]['edad'];
            $sexoCliente = $clienteObjData[0]['sexo'];
            $nacionalidadCliente = $clienteObjData[0]['nacionalidad'];
            //FIN DATOS DEL CLIENTE
        }
    }
    $clienteObj = new daoCliente();
    $clientes = $clienteObj->obtenerTodosClientes();
    $habitacionDisponibles = $reservaObj->obtenerHabitacionesSinReservacionActual();
    $fechaEntrada=date('Y-m-d');
}

if (isset($eliminar)) {
    $reservaObj = new daoReservacion();
    $reservaObj->eliminarreservacion($_GET['eliminar']);
    header('Location: ../VISTA/plantilla.php?opcion=1');
}
if (isset($editar)) {
    $reservaObj = new daoReservacion();
    $clientes = $reservaObj->obtenerClienteDadoIdReservacion($editar);
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $reservaObjData = $reservaObj->obtenerElemento(array('idReservacion' => $editar));
        if (count($reservaObjData) == 1) {
            $numero_habitacion = $reservaObjData[0]['habitacion'];
            $id_cliente = $reservaObjData[0]['cliente'];
            if (daoReservacion::obtenerHabitacionDisponible($numero_habitacion, $fecha_entrada, $cant_dias,$editar) == true) {
                $reservaObj = new daoReservacion($id_cliente, $numero_habitacion, $cant_dias, $fecha_entrada);
                $reservaObj->actualizarReservacionObjetoDadoCodigo($reservaObjData[0]['codigo']);
                if(isset($reservaObjData[0]['turoperador']) && !empty($reservaObjData[0]['turoperador']))
                    $list = 'ctur';
                else
                    $list = 'stur';
                header('Location: ../VISTA/plantilla.php?opcion=1&'.$list);
            } else {
                $_SESSION['error'] = "La habitaci&oacute;n <b># $numero_habitacion</b> no est&aacute; disponible en el tiempo seleccionado.";
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }

        }else
        header('Location: ../VISTA/plantilla.php?opcion=0');
    }
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $reservaObjData = $reservaObj->obtenerElemento(array('idReservacion' => $editar));
        if (count($reservaObjData) == 1) {
            //DATOS DEL CLIENTE
            $cliente = $reservaObjData[0]['cliente'];//idCliente
            $nombreCliente = $reservaObjData[0]['nombre'];
            $edadCliente = $reservaObjData[0]['edad'];
            $sexoCliente = $reservaObjData[0]['sexo'];
            $nacionalidadCliente = $reservaObjData[0]['nacionalidad'];
            //FIN DATOS DEL CLIENTE

            //DATOS GENERALES DE LA RESERVACION
            $codigo = $reservaObjData[0]['codigo'];
            $fechaEntrada = explode(' ', $reservaObjData[0]['fecha_entrada'])[0];
            $cantidadDias = $reservaObjData[0]['cantidad_dias'];
            $habitacion = $reservaObjData[0]['habitacion'];
            $pertenecetur = $reservaObjData[0]['pertenece_tur'];
            $turoperador = $reservaObjData[0]['turoperador'];
            //FIN DE DATOS GENERALES DE LA RESERVACION

        }else
            header('Location: ../VISTA/plantilla.php?opcion=1');


    }
}
//PETICIONES AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservaObj = new daoReservacion();
    $habitacion = new daoHabitacion();
    if (isset($method))
        switch ($method) {
            case 'cargarHabitaciones':
                $arregloHabitacionesOcupadas = $reservaObj::obtenerHabitacionDisponible(0, $fechaEntrada, $cantidadDias);
                $arregloHabitaciones = $habitacion->obtenerTodasHabitaciones();
                $resultadoHabitacion = array();
                foreach ($arregloHabitaciones as $habitacion) {
                    $esta = false;
                    foreach ($arregloHabitacionesOcupadas as $habitacionesOcupada) {
                        if ($habitacion['numero'] == $habitacionesOcupada['numero']) {
                            $esta = true;
                            break;
                        }
                    }
                    if (!$esta)
                        $resultadoHabitacion[] = $habitacion;
                }

                $resultado = "<option value= ''>Seleccione un elemento ... </option>";
                foreach ($resultadoHabitacion as $habitacion) {
                    $resultado .= "<option value=" . $habitacion['numero'] . ">" . $habitacion['numero'] . "</option>";
                }
                print_r($resultado);
                break;
            case 'reporte1':
                $fecha = (isset($repAnno) && !empty($repAnno)?$repAnno:date('Y')).(isset($repMes) && !empty($repMes)?"-".$repMes:"-".date('m'));
                $rep1Strt =strtotime("$fecha");
                $rep1FechaInicial =date('Y-m-d',$rep1Strt);
                $rep1CantDias =date('t',$rep1Strt)-date('d',$rep1Strt);

                if($repTur=='S')
                    $rep1Tur = true;
                elseif ($repTur=='N')
                    $rep1Tur = false;
                else
                    $rep1Tur = 'NO BOOLEAN';
                $result = $reservaObj->obtenerElemento(array('rangoFechaI'=> $rep1FechaInicial,'rangoFechaF'=>$rep1CantDias,'nacionalidad'=>$repNac,'conTurOperador'=> $rep1Tur)); //Obtengo todas las reservaciones existentes en el periodo dado
                $todasReserv = $reservaObj->obtenerTodasReservaciones();
                $resultNac = array(); //arreglo para almacenar los valores id correspondientes a las nacionalidades
                $resultado = array();
                $total = count($todasReserv);
                foreach ($result as $item){
                    if(!in_array($item['nacionalidad'],$resultNac)){
                        $resultNac[]=$item['nacionalidad'];
                        $resultado[]=array(
                            'nacionalidad'=>$item['descripcion'],
                            'cantidadPorNac'=>1,
                            'porCientoTotal'=>round(((1/$total)*100),2)
                        );
                    }else{
                        $index = array_search($item['nacionalidad'],$resultNac);
                        $resultado[$index]['cantidadPorNac']+=1;
                        $resultado[$index]['porCientoTotal']=round((($resultado[$index]['cantidadPorNac']/$total)*100),2);
                    }
                }

                $json = '';
                if(count($result)==0)
                    $json = "<tr><td style='text-align: center' colspan='3'>SIN DATOS PARA MOSTRAR</td></tr>";
                foreach ($resultado as $key => $value){
                    $json.="<tr><td>".($key+1)."</td><td>".$value['cantidadPorNac']."/".$total." (".$value['porCientoTotal']."%)</td><td>".$value['nacionalidad']."</td></tr>";
                }
                print_r($json);
                break;
            case 'reporte2':
                $fecha = (isset($repAnno) && !empty($repAnno)?$repAnno:date('Y'));
                $rep2StrtI =strtotime("$fecha"."-01");
                $rep2StrtF =strtotime("$fecha"."-12");
                $rep2FechaInicial =date('Y-m-d',$rep2StrtI);
                $rep2FechaFinal =date('Y-m-t',$rep2StrtF);

                $result = $reservaObj->obtenerElemento(array('rangoFechaI'=> $rep2FechaInicial,'rangoFechaF'=>$rep2FechaFinal,'nacionalidad'=>$repNac)); //Obtengo todas las reservaciones existentes en el periodo dado

                $resultNac = array();
                $resultado = array();
                $meses = array('ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCUTBRE','NOVIEMBRE','DICIEMBRE');

                $json = '';
                if(count($result)==0){
                    $json = "<tr><td style='text-align: center' colspan='4'>SIN DATOS PARA MOSTRAR</td></tr>";
                }
                else{
                    foreach ($result as $item){
                        $fechaItem = $item['fecha_entrada']; //fecha en texto '2020-01-01 12:30:45'
                        $fechaItemTimestamp = strtotime($fechaItem); //fecha en milisegundos 1577899845
                        $fechaItemMes = date('m',$fechaItemTimestamp); //mes de la fecha '01'
                        $fechaItemMesInt = intval($fechaItemMes); //mes de la fecha como valor entero '1'
                        $mes = $meses[$fechaItemMesInt-1]; //Se le resta uno dado que el arreglo de meses comienza con '0' como primer indice y termina en '11'
                        if(!in_array($item['nacionalidad'].$mes,$resultNac)){
                            $resultNac[]=$item['nacionalidad'].$mes;
                            $resultado[]=array(
                                'nacionalidad'=>$item['descripcion'],
                                'cantidadPorNac'=>1,
                                'mes'=>$mes,
                            );
                        }else{
                            $index = array_search($item['nacionalidad'].$mes,$resultNac);
                            $resultado[$index]['cantidadPorNac']+=1;
                        }
                    }
                    $max = array();
                    $maximos =array();

                    foreach ($resultado as $value){
                        if(!array_key_exists($value['nacionalidad'],$max)){
                            $max[$value['nacionalidad']] = $value;
                            $maximos[$value['nacionalidad']]=array();
                            $maximos[$value['nacionalidad']][]=$value;
                        }
                        elseif($max[$value['nacionalidad']]['cantidadPorNac']<$value['cantidadPorNac']){
                            $max[$value['nacionalidad']] = $value;
                            $maximos[$value['nacionalidad']]=array();
                            $maximos[$value['nacionalidad']][]=$value;
                        }elseif ($max[$value['nacionalidad']]['cantidadPorNac']==$value['cantidadPorNac']){
                            $maximos[$value['nacionalidad']][]=$value;
                        }
                    }

                    $count = 1;
                    foreach ($maximos as $maximo1){
                        foreach($maximo1 as $maximo)
                            $json.="<tr><td>".$count++."</td><td>".$maximo['mes']."</td><td>".$maximo['cantidadPorNac']."</td><td>".$maximo['nacionalidad']."</td></tr>";
                    }
                }

                print_r($json);
                break;
            case 'reporte3':

                $fecha = (isset($repAnno) && !empty($repAnno)?$repAnno:date('Y'));
                $rep2StrtI =strtotime("$fecha"."-01");
                $rep2StrtF =strtotime("$fecha"."-12");
                $rep2FechaInicial =date('Y-m-d',$rep2StrtI);
                $rep2FechaFinal =date('Y-m-t',$rep2StrtF);

                $result = $reservaObj->obtenerElemento(array('rangoFechaI'=> $rep2FechaInicial,'rangoFechaF'=>$rep2FechaFinal,'nacionalidad'=>$repNac)); //Obtengo todas las reservaciones existentes en el periodo dado

                $resultNac = array();
                $resultado = array();

                $json = '';
                if(count($result)==0){
                    $json = "<tr><td style='text-align: center' colspan='4'>SIN DATOS PARA MOSTRAR</td></tr>";
                }
                else{
                    foreach ($result as $item){
                        if(!in_array($item['descripcion'].$item['sexo'],$resultNac)){
                            $resultNac[]=$item['descripcion'].$item['sexo'];
                            $resultado[]=array(
                                'nacionalidad'=>$item['descripcion'],
                                'cantidadPorNac'=>1,
                                'sexo'=>$item['sexo'],
                            );
                        }else{
                            $index = array_search($item['descripcion'].$item['sexo'],$resultNac);
                            $resultado[$index]['cantidadPorNac']+=1;
                        }
                    }
                    $max = array();
                    $maximos =array();

                    foreach ($resultado as $value){
                        if(!array_key_exists($value['nacionalidad'],$max)){
                            $max[$value['nacionalidad']] = $value;
                            $maximos[$value['nacionalidad']]=array();
                            $maximos[$value['nacionalidad']][]=$value;
                        }
                        elseif($max[$value['nacionalidad']]['cantidadPorNac']<$value['cantidadPorNac']){
                            $max[$value['nacionalidad']] = $value;
                            $maximos[$value['nacionalidad']]=array();
                            $maximos[$value['nacionalidad']][]=$value;
                        }elseif ($max[$value['nacionalidad']]['cantidadPorNac']==$value['cantidadPorNac']){
                            $maximos[$value['nacionalidad']][]=$value;
                        }
                    }

                    $count = 1;
                    foreach ($maximos as $maximo1){
                        foreach($maximo1 as $maximo)
                            $json.="<tr><td>".$count++."</td><td>".($maximo['sexo']==1?'MASCULINO':'FEMENINO')."</td><td>".$maximo['cantidadPorNac']."</td><td>".$maximo['nacionalidad']."</td></tr>";
                    }
                }

                print_r($json);
                break;
            case 'reporte4':
                $clientes  = $reservaObj->obtenerClientesTuroperadorDadoCodigo($repTur);

                $resultado='';
                if(count($clientes)==0){
                    $resultado='<tr><td colspan="5" style="text-align: center">SIN DATOS PARA MOSTRAR</td></tr>';
                }else{
                    foreach ($clientes as $key => $cliente){
                        $resultado.='<tr><td>'.($key+1).'</td><td>'.$cliente['fecha_entrada'].'</td><td>'.$cliente['cliente_nombre'].'</td><td>'.$cliente['turoperador_nombre'].' ('.$cliente['codigo'].')</td><td>'.($cliente['turoperador_pertenece']?'SI':'NO').'</td></tr>';
                    }
                }
                print_r($resultado);
                break;

        }
}