<?php


if(!isset($_SESSION['nombre']) || session_status()!=PHP_SESSION_ACTIVE)
    header('Location: ../VISTA/plantilla.php?opcion=0');
?>

<div style="">
    <div class="form-group">
    <a href="?opcion=<?php echo $opcion ?>&insertar" style="float: right;text-decoration: none; padding: 5px;" class="btn btn-primary"> <i class="glyphicon glyphicon-plus" ></i> Registrar cliente </a>
    <h2 style="">Listado de clientes</h2>
    </div>
</div>


<table class="table">
    <tr>
        <th>No.</th>
        <th>Nombre</th>
        <th>Sexo</th>
        <th>Edad</th>
        <th>Nacionalidad</th>
        <th>¿Primera vez en el hotel?</th>
        <th>Acciones</th>
    </tr>

    <?php
            include_once '../CONTROLADOR/cc-cliente.php';
            foreach ($clientes as $key => $cliente){
        ?>
        <tr>
            <td><?php echo $key + 1 ?></td>
            <td><?php echo $cliente['nombre'] ?></td>
            <td><?php echo $cliente['sexo'] ?></td>
            <td><?php echo $cliente['edad'] ?></td>
            <td><?php echo $cliente['nacionalidad'] ?></td>
            <td><?php echo (!$cliente['reiterado']?'Si':'No') ?></td>
            <td>
                <a href="<?php echo '?opcion=1&insertar&cliente='.$cliente['id_cliente'] ?>" class="btn btn-default"><span class="glyphicon glyphicon-file"></span> Reservar</a>
                <a href="?opcion=<?php echo $opcion ?>&editar=<?php echo $cliente['id_cliente'] ?>" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Editar</a>
            </td>
        </tr>
        <?php }?>
</table>

