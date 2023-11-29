<?php

include 'Conexion.php';

class daoUsuario{

    //funcion para verificar las credenciales de acceso
    function verificarCredenciales($usuario,$contrasena){
        $pass = md5($contrasena);
        $sql = "SELECT * FROM usuario WHERE usuario = '$usuario' AND contrasenna='$pass';";
        $con = new conexion();
        return $con->devolverResultados($sql);
    }

}