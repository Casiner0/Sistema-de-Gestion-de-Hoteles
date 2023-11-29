<?php
include_once '../MODELO/daoNomenclador.php';


if(!isset($_SESSION))
    session_start();
extract($_REQUEST);

if(!isset($_SESSION['nombre']))
    header('Location: ../VISTA/plantilla.php?opcion=0');


$nomenclador = new daoNomenclador();

$nacionalidades = $nomenclador->obtenerNacionalidades();
$sexos = $nomenclador->obtenerSexos();
$habitacionDisponibles = $nomenclador->obtenerHabitaciones();
$turOperadores = $nomenclador->obtenerTurOperadores();