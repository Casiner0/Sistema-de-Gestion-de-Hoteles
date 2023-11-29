<?php


if(!isset($_SESSION['nombre']) || session_status()!=PHP_SESSION_ACTIVE)
    header('Location: ../VISTA/plantilla.php?opcion=0');
?>

<div style="">
    <button id="conTurBtn" onclick="verListadoConTur(this)" class="btn btn-info"><span class="glyphicon glyphicon-book"></span> Listado Turoperador</button>
    <button id="sinTurBtn" onclick="verListadoSinTur(this)" class="btn btn-info active"><span class="glyphicon glyphicon-list"></span> Listado Recepci&oacute;n</button>
</div>
<?php
    include_once '../CONTROLADOR/cc-reservacion.php';
?>
<div class="col-md-12" id="sinTur">
<div class="form-group">
    <a href="?opcion=<?php echo $opcion ?>&insertar" style="float: right;text-decoration: none; padding: 5px;" class="btn btn-primary"> <i class="glyphicon glyphicon-plus" ></i> Reservar</a>
    <h2 style="">Listado de reservaciones sin turoperador</h2>
</div>
    <table class="table" >
        <tr>
            <th>No.</th>
            <th>Código</th>
            <th>Habitaci&oacute;n</th>
            <th>Fecha de Entrada</th>
            <th>Cliente</th>
            <th>Cantidad de Días</th>
            <th>Acciones</th>
        </tr>
        <tbody>
        <?php
        if(empty($reservas)){
            echo '<tr><td colspan="7" style="text-align: center">No existen reservaciones para mostrar.</td></tr>';
        }
        $count = 1;
        foreach ($reservas as $key => $reserva){
            if(!empty($reserva['nombre_turoperador']))
                continue;
            ?>
            <tr>
                <td><?php echo $count++ ?></td>
                <td><?php echo $reserva['codigo'] ?></td>
                <td><?php echo $reserva['habitacion'] ?></td>
                <td><?php echo $reserva['fecha_entrada'] ?></td>
                <td><?php echo $reserva['nombre_cliente'] ?></td>
                <td><?php echo $reserva['cantidad_dias'] ?></td>
                <td>
                    <?php
                    $fechaFinal = date('Y-m-d H:i:s',strtotime($reserva['fecha_entrada']."+ ".$reserva['cantidad_dias']." days"));
                    if($fechaFinal > date('Y-m-d H:i:s')){
                        ?>
                        <a title="Editar" href="?opcion=<?php echo $opcion ?>&editar=<?php echo $reserva['id_reservacion'] ?>" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Editar  </a>
                        <a title="Cancelar" href="?opcion=<?php echo $opcion ?>&eliminar=<?php echo $reserva['id_reservacion'] ?>" class="btn btn-danger"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</a>
                    <?php }else{ ?>
                    <?php }?>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
<div class="col-md-12" id="conTur" hidden>

    <div class="form-group">
        <a href="?opcion=<?php echo $opcion ?>&insertar" style="float: right;text-decoration: none; padding: 5px;" class="btn btn-primary"> <i class="glyphicon glyphicon-plus" ></i> Reservar</a>
        <h2 style="">Listado de reservaciones por turoperador</h2>
        <!---->
    </div>
    <table class="table" >
        <tr>
            <th>No.</th>
            <th>Código</th>
            <th>Habitaci&oacute;n</th>
            <th>Fecha de Entrada</th>
            <th>Cliente</th>
            <th>Turoperador</th>
            <th>Cantidad de Días</th>
            <th>Acciones</th>
        </tr>
        <tbody >
        <?php
        if(empty($reservas)){
            echo '<tr><td colspan="7" style="text-align: center">No existen reservaciones para mostrar.</td></tr>';
        }
        $count = 1;
        foreach ($reservas as $key => $reserva){
            if(empty($reserva['nombre_turoperador']))
                continue;
            ?>
            <tr>
                <td><?php echo $count++ ?></td>
                <td><?php echo $reserva['codigo'] ?></td>
                <td><?php echo $reserva['habitacion'] ?></td>
                <td><?php echo $reserva['fecha_entrada'] ?></td>
                <td><?php echo $reserva['nombre_cliente'] ?></td>
                <td><?php echo $reserva['nombre_turoperador'] ?></td>
                <td><?php echo $reserva['cantidad_dias'] ?></td>
                <td>
                    <?php
                    $fechaFinal = date('Y-m-d H:i:s',strtotime($reserva['fecha_entrada']."+ ".$reserva['cantidad_dias']." days"));
                    if($fechaFinal > date('Y-m-d H:i:s')){
                        ?>
                        <a title="Editar" href="?opcion=<?php echo $opcion ?>&editar=<?php echo $reserva['id_reservacion'] ?>" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Editar  </a>
                        <a title="Cancelar" href="?opcion=<?php echo $opcion ?>&eliminar=<?php echo $reserva['id_reservacion'] ?>" class="btn btn-danger"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</a>
                    <?php }else{ ?>
                    <?php }?>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>

<script>
       $(document).ready(function () {
           <?php if(isset($stur)){
                echo 'document.getElementById("sinTurBtn").click();';
           }elseif (isset($ctur)){
                echo 'document.getElementById("conTurBtn").click();';

           } ?>
       });

    function verListadoConTur(btn) {
        btn.setAttribute('class',btn.classList+' active');
        document.getElementById('sinTurBtn').classList.remove('active');
        document.getElementById('conTur').removeAttribute('hidden');
        document.getElementById('sinTur').setAttribute('hidden','hidden');
    }

    function verListadoSinTur(btn) {
        btn.setAttribute('class',btn.classList+' active');
        document.getElementById('conTurBtn').classList.remove('active');
        document.getElementById('sinTur').removeAttribute('hidden');
        document.getElementById('conTur').setAttribute('hidden','hidden');
    }
</script>
