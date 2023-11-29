<?php
include '../MODELO/daoUsuario.php';
extract($_REQUEST);

session_start();

if(isset($autenticar)){

    $userObj = new daoUsuario();
    try{
        $result = $userObj -> verificarCredenciales(strtolower($usuario),$contrasena);

        if(count($result)>0){
            $_SESSION['nombre']=$result[0]['usuario'];
        }else
            $_SESSION['error']='Usuario o contraseña incorrecta.';
        //redireccionar a la página plantilla con opción igual a cero(0)
    }catch (Exception $exception){
        $_SESSION['error']=$exception->getMessage();
    }
}
//echo $usuario." + ".$contrasena;
header('Location: ../VISTA/plantilla.php?opcion=0');

