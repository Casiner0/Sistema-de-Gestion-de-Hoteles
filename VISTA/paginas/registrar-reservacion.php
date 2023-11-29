<?php
include '../CONTROLADOR/cc-nomenclador.php';
include '../CONTROLADOR/cc-reservacion.php';

?>
<div class="col-md-12">

    <form action="../CONTROLADOR/cc-reservacion.php" method="post" class="form-horizontal">

        <h1><p><?php echo isset($_GET['editar']) ? 'Editar' : 'Registrar' ?> reservaci&oacute;n</p></h1>
        <hr>
        <div class="col-md-6">
            <div class="form-group" style="padding: 10px">
                <select name="id_cliente" id="reservIdCliente" class="form-control" onchange="activarDatosCliente(this)" <?php echo (isset($_GET['editar'])?'disabled':'required')?>>
                    <?php if(!isset($_GET['editar'])){ ?>
                    <option value="">Seleccione un cliente ...</option>
                    <option value="otro">Es otro</option>
                    <?php }?>
                    <?php foreach ($clientes as $item) {
                        echo "<option data-cliente='" . json_encode($item) . "' value='" . $item['id_cliente'] . "' " . (isset($cliente) && $item['id_cliente'] == @$cliente ? "selected" : "") . ">" . strtoupper($item['nombre']) . "</option>";
                    } ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <?php

            if (isset($_SESSION['error'])) {
                include 'error.php';
                unset($_SESSION['error']);
            }
            ?>
        </div>

        <div class="clearfix"></div>
        <div class="col-md-6">
            <fieldset id="reservInfoCliente" disabled>
                <legend>Informaci&oacute;n del cliente:</legend>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Nombre:</label>
                        <input id="reservClienteNombre" name="nombre_client" type="text" class="form-control"
                               value="<?php echo(isset($nombreCliente) ? $nombreCliente : '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="padding-right: 5px;">
                        <label for="">Nacionalidad:</label>
                        <select id="reservClienteNacionalidad" name="nacionalidad_cliente" id="" class="form-control">
                            <option value="">Seleccione un elemento ...</option>
                            <?php foreach ($nacionalidades as $item) {
                                echo "<option value='" . $item['id_nacionalidad'] . "' " . (isset($nacionalidadCliente) && $item['id_nacionalidad'] == @$nacionalidadCliente ? "selected" : "") . ">" . $item['descripcion'] . "</option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="padding-left: 5px;">
                        <label for="">Sexo:</label>
                        <select id="reservClienteSexo" name="sexo_cliente" class="form-control">
                            <option value="">Seleccione un elemento ...</option>
                            <?php foreach ($sexos as $item) {
                                echo "<option value='" . $item['id_sexo'] . "' " . (isset($sexoCliente) && $item['id_sexo'] == @$sexoCliente ? "selected" : "") . ">" . $item['descripcion'] . "</option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="padding-left: 5px;">
                        <label for="">Edad:</label>
                        <input id="reservClienteEdad" name="edad_cliente" class="form-control"
                               value="<?php echo isset($edadCliente) ? $edadCliente : '' ?>">
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-md-6">
            <fieldset>
                <legend>Datos generales:</legend>
                <div class="col-md-6">
                    <div class="form-group" style="padding-left: 5px;">
                        <label for="">Fecha de entrada: </label>
                        <input type="date"   name="fecha_entrada" <?php echo "min='".date('Y-m-d')."'" ?> id="reservFechaEntrada"class="form-control" value="<?php echo isset($fechaEntrada)?$fechaEntrada:''?>"  <?php echo (isset($_GET['editar'])?'':' onchange="cargarHabitaciones()"')?> required>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group" style="padding-right: 5px;">
                        <label for="">N&uacute;mero de habitaci&oacute;n: </label>
                        <select name="numero_habitacion" id="reservNoHabitacion" class="form-control" <?php echo (isset($_GET['editar'])?'disabled':'required') ?>>
                            <option value="">Seleccione un elemento ...</option>
                            <?php foreach ($habitacionDisponibles as $item) {
                                echo "<option value='" . $item['numero'] . "' " . (isset($habitacion) && $item['numero'] == @$habitacion ? "selected" : "") . ">" . $item['numero'] . "</option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="padding-left: 5px ">
                        <label for="">Cantidad de d&iacute;as:</label>
                        <input type="text" name="cant_dias" id="reservCantDias" onchange="cargarHabitaciones()" class="form-control" required
                               value="<?php echo isset($cantidadDias) ? $cantidadDias : 1 ?>">
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group" style="padding-right: 5px ">
                        <label for="">Turoperador: </label>
                        <select name="id_turoperador" id="" class="form-control" <?php echo (isset($_GET['editar'])?'disabled':'onchange="activarPerteneceTur(this);"')?>>
                            <option value="">Seleccione un elemento ...</option>
                            <?php foreach ($turOperadores as $item) {
                                echo "<option value='" . $item['id_turoperador'] . "' " . (isset($turoperador) && $item['id_turoperador'] == $turoperador ? "selected" : "") . ">" . $item['nombre'] . "</option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="padding-left: 5px;">
                        <label for="">¿Pertenece al tur? </label>
                        <select id="reservTuroperadorPertenece" name="pertenece_tur" class="form-control"
                                required <?php echo (isset($turoperador) && isset($pertenecetur)&!isset($_GET['editar']) ? '' : 'disabled') ?> >
                            <option value="">Seleccione un elemento ...</option>
                            <option value="1" <?php echo isset($pertenecetur) && $pertenecetur ? "selected" : '' ?>>SI
                            </option>
                            <option value="0" <?php echo isset($pertenecetur) && !$pertenecetur ? "selected" : '' ?>>
                                NO
                            </option>
                        </select>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="clearfix"></div>

        <p>
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary"
                        value="<?php echo(isset($_GET['editar']) ? $_GET['editar'] : 'insertar') ?>"
                        name="<?php echo(isset($_GET['editar']) ? 'editar' : 'insertar') ?>"><?php echo(isset($_GET['editar']) ? 'Actualizar' : 'Registrar') ?>
                    reservaci&oacute;n
                </button>
            <a class="btn btn-default" href="?opcion=<?php echo isset($opcion)?$opcion:'1' ?>"><span class="glyphicon glyphicon-arrow-left"></span> Ir al listado de reservaciones</a>
            </div>
        </p>

    </form>

</div>
<!--Scripts propios de esta clase-->
<script>
//    $(document).ready(function () {
//        var currentDate = (new Date()).toLocaleDateString();
//        arrayCurrentDate = currentDate.split('/');
//        arrayReverseCurrentDate = arrayCurrentDate.reverse();
//        if(arrayReverseCurrentDate[2]<10)
//            arrayReverseCurrentDate[2]='0'+arrayReverseCurrentDate[2];
//        arrayJoinReverseCurrentDate = arrayReverseCurrentDate.join('-');
//
//        document.getElementById('reservFechaEntrada').setAttribute('min',arrayJoinReverseCurrentDate);
//        // document.getElementById('reservFechaEntrada').value=arrayJoinReverseCurrentDate;
//    });

    function cargarHabitaciones() {
        valueFechaEntrada = document.getElementById('reservFechaEntrada').value;
        valueCantDias = document.getElementById('reservCantDias').value;
        $.ajax({
            type:'POST',
            data:{
                method: 'cargarHabitaciones',
                fechaEntrada:valueFechaEntrada,
                cantidadDias :valueCantDias
            },
            url: '../CONTROLADOR/cc-reservacion.php',
            success: function(result){
                $("#reservNoHabitacion").html(result);
            },
            error: function (xhr) {
                alert("Ha ocurrido el siguiente error: " + xhr.status + " " + xhr.statusText);
            }
        });
    }
</script>
