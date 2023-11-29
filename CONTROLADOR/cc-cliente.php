<?php
include '../MODELO/daoCliente.php';
if(!isset($_SESSION))
    session_start();
extract($_REQUEST);

if(!isset($_SESSION['nombre']) || (!isset($listar) && !isset($insertar) && !isset($eliminar) && !isset($editar)) )
    header('Location: ../VISTA/plantilla.php?opcion=0');


if (isset($listar)){
    $clienteObj = new daoCliente();
    $clientes = $clienteObj ->obtenerTodosClientes();
}

if (isset($insertar) && $insertar=='insertar' && $_SERVER['REQUEST_METHOD']=="POST"){
    $clienteObj = new daoCliente($nombre,$edad,$sexo,$nacionalidad);
    $clienteObj -> registrarCliente();
    header('Location: ../VISTA/plantilla.php?opcion=2');
}

if (isset($editar)){
    if ($_SERVER['REQUEST_METHOD']=="POST"){
        $clienteObj = new daoCliente($nombre,$edad,$sexo,$nacionalidad,(isset($reiterado)?1:0));
        $clienteObjData = $clienteObj->obtenerClienteDadoId($editar);
        if(count($clienteObjData)==1){
            $clienteObj ->actualizarClienteObjetoDadoId($editar);
        }else
            $clienteObj ->registrarCliente();
        header('Location: ../VISTA/plantilla.php?opcion=2');
    }
    if ($_SERVER['REQUEST_METHOD']=="GET"){
        $clienteObj = new daoCliente();
        $clienteObjData = $clienteObj->obtenerClienteDadoId($editar);
        if(count($clienteObjData)==1){
            $nombre = $clienteObjData[0]['nombre'];
            $edad = $clienteObjData[0]['edad'];
            $sexo = $clienteObjData[0]['sexo'];
            $nacionalidad = $clienteObjData[0]['nacionalidad'];
            $reiterado = $clienteObjData[0]['reiterado'];
        }
    }
}
