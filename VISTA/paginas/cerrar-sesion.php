<?php
ob_start();
session_destroy();
header('Location: ../VISTA/plantilla.php?opcion=0');
