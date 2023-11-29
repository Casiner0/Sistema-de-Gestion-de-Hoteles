<?php 
	include '../MODELO/daoTurOperador.php';

	if(!isset($_SESSION))
    	session_start();
		extract($_REQUEST);

	if(!isset($_SESSION['nombre']))
    	header('Location: ../VISTA/plantilla.php?opcion=0');	

    $nombreTur = $_POST['nombre'];
    $codigoTur = $_POST['codigo'];
    $nacionalidadTur = $_POST['nacionalidad'];

    if (!empty($nombreTur) && !empty($codigoTur) && !empty($nacionalidadTur)) {
    	$turObj = new daoTurOperador($nombreTur, $nacionalidadTur, $codigoTur);
    	$turObj->insertarTurOperador();
    	header('Location: ../VISTA/plantilla.php?opcion=4');
    }
?>