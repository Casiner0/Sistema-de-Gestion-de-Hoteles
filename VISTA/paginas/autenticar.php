<form class="navbar-form navbar-right" role="form" id="registra" action="../CONTROLADOR/cc-autenticar.php" method="POST">

    <div class="form-group">
        <input type="text" placeholder="Usuario" class="form-control" name="usuario" id="usuario" type="text" value="">
    </div>

    <div class="form-group">
        <input type="password" placeholder="Contraseña" class="form-control has-error" id="pass" name="contrasena" type="password" value="">
    </div>

    <button type="submit" class="btn btn-success" name='autenticar'>Autenticarse</button>
<?php 
    if (isset($_SESSION['error'])){
?>
        <div class="alerta_login" id="alerta_login">
            <?php echo $_SESSION['error'] ?>
        </div> 
<?php }
    session_destroy();
    ?>
</form>
