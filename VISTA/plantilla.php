<?php
    session_start();
    ob_start();
    
    //Evitar que pase a páginas k no esten autorizadas
    if (isset($_SESSION['nombre'])){
        if ($_SESSION['nombre'] == "recepcion" && $_GET['opcion'] == 4) {
            header ("location: ?opcion=2");
        }
        if ($_SESSION['nombre'] == "turoperador" && $_GET['opcion'] == 5) {
            header ("location: ?opcion=2");
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Hotel Cuba</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum‐scale=1.0, user‐scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- incluimos los ficheros css-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/miEstilo.css" rel="stylesheet" type="text/css">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]-->
    <script src="js/html5shiv.js"></script>
    <!--[endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="img/icon 32x.png">

    <!-- incluimos los ficheros js-->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</head>
<?php
$opcion = isset($_GET['opcion'])?$_GET['opcion']:'0';
$listar ="";
if(ctype_digit($opcion)){
    if(empty($_SESSION))
        $opcion = '0';
    switch ($opcion) {
        case 0: $page= './paginas/portada.php';
            break;
        case 1:
            if(isset($_GET['insertar']) || isset($_GET['editar']))
                $page= './paginas/registrar-reservacion.php';
            else
                $page = './paginas/listar-reservaciones.php';
            break;
        case 2:
            if(isset($_GET['insertar']) || isset($_GET['editar']))
                $page= './paginas/registrar-cliente.php';
            else
                $page= './paginas/listar-clientes.php';
            break;
        case 3: $page = './paginas/cerrar-sesion.php';
            break;
        case 4: $page = './paginas/turOperador.php';
            break;    
        case 5:
            if(isset($_GET['rep']))
                $page = './paginas/reportes/reporte'.$_GET['rep'].'.php';
            else
                $page = './paginas/reportes.php';
            break;
        default: $page= './paginas/error.php';
            break;
    }

}else{
    $page= './paginas/error.php';
}
?>
<body>
<div class="container">
    <header>
        <div class="row clearfix">
            <div class="col-md-6 column">
                <div class="logo">
                    <img src="img/logo white.png">
                </div>
            </div>
            <div class="col-md-6 column cabecera">
                <?php
                extract($_REQUEST);


                if(!isset($_SESSION['nombre'])){
                    include './paginas/autenticar.php';
                }else{
                    ?>
                    <p style="margin-top: 40px;">Bienvenido:
                        <span class="glyphicon glyphicon-user"></span>
                        <?php echo $_SESSION['nombre'];?> | <a href="?opcion=3">Cerrar sesión</a></p>

                <?php }
                ?>
            </div>
        </div>

    </header>
    <div class="row clearfix">
        <div class="col-md-12 column">
            <nav class="navbar navbar-default fondo" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only ">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="?opcion=0">Inicio</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <?php
                    //solo mostrar ul si existe la sesión correcta
                    if(isset($_SESSION['nombre'])){
                    ?>
                    <ul class="nav navbar-nav">
                        <li class="<?php echo ($opcion=='2'?'active':'');?>">
                            <a href="?opcion=2">Clientes</a>
                        </li>
                        <li class="<?php echo ($opcion=='1'?'active':'');?>">
                            <a href="?opcion=1">Reservaciones </a>
                        </li>
                        <?php if ($_SESSION['nombre'] == "turoperador"){ ?>
                                <li class="<?php echo ($opcion=='4'?'active':'');?>">
                                    <a href="?opcion=4">TurOperadores</a>
                                </li>
                        <?php }else{ ?>        
                                <li class="<?php echo ($opcion=='5'?'active':'');?>">
                                    <a href="?opcion=5">Reportes </a>
                                </li>    
                        <?php } ?>
                    </ul>
                <?php }?>
                </div>
            </nav>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="fondo pocision-fondo">
                <?php
                if(isset($_SESSION['nombre']))
                    include($page);
                else
                {?>
                    <div class="container">
                        <div class="row clearfix">
                            <div class="col-md-12 column">
                                <blockquote>
                                    <p>
                                        Bienvendo al sitio encargado de las reservaciones en los hoteles.  
                                    </p> <small><cite>Hotel Cuba</cite></small>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                <?php }?>
                <div class="row clearfix"></div>
                <div class="col-md-12 column pie">
                    <div class="contenido-pie">
                        &REG; Hotel Cuba.
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
</body>
</html>