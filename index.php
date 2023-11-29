<?php
    header('Location: VISTA/plantilla.php');






























//
//$listHabit = generarHabitaciones();
//
//$listadoCliente = generarClientes();
//
//
//function generarClientes($clientes= array(),$cant = 100){
//    $nombre = array('JUAN', 'MARIA','JOSE','PEDRO','TINA','JULIA');
//    $apellido1 = array('PEREZ', 'LOPEZ','DELGADO','GOMEZ','FERNANDEZ','GLEZ');
//    $nacionalidad = array('CUBA','MEXICO','EU','CANADA','ITALIA','PANAMA','URUGUAY');
//
//    while ($cant>0){
//        $clientes[]=new daoClienteOLD(
//            $nombre[rand(0,count($nombre)-1)],
//            rand(20,100),
//            (rand(0,1)==0?'F':'M'),
//            $nacionalidad[rand(0,count($nacionalidad)-1)],
//            (reiterado(new daoClienteOLD(
//                    $nombre[rand(0,count($nombre)-1)],
//                    rand(20,100),
//                    (rand(0,1)==0?'F':'M'),
//                    $nacionalidad[rand(0,count($nacionalidad)-1)],true),$clientes) ||
//            reiterado(new daoClienteOLD(
//                $nombre[rand(0,count($nombre)-1)],
//                rand(20,100),
//                (rand(0,1)==0?'F':'M'),
//                $nacionalidad[rand(0,count($nacionalidad)-1)],false),$clientes)?true:false)
//        );
//        $cant --;
//    }
//    return $clientes;
//}
//
//function reiterado($cliente,$listCliente){
//    foreach ($listCliente as $listC)
//        if($listC == $cliente)
//            return true;
//    return false;
//}
//function generarHabitaciones($listadoHabit = array(),$cant = 100){
//    while ($cant>0){
//        $listadoHabit[]=new daoHabitacion($cant);
//        $cant--;
//    }
//    return $listadoHabit;
//}



