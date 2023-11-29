<!-- Inciso f)
Implemente la funcionalidad necesaria para determinar
el listado de todos los clientes que han reservado
por medio de un turoperador dado su código y que esté
ordenado por la fecha de entrada.
-->
<?php include_once '../CONTROLADOR/cc-nomenclador.php' ?>
<div class="col-md-12">
    <div class="form-group">
        <h2 style="">Clientes que han reservado por un turoperador </h2>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Turoperador:</label>
            <select id="repTuroperador" name="turoperador" class="form-control" required>
                <option value="">Seleccione un elemento ... </option>
                <?php foreach ($turOperadores as $turOperador){
                    echo "<option value='".$turOperador['codigo']."'>".$turOperador['nombre']."</option>";
                } ?>
            </select>
        </div>
    </div>
    <div class="col-md-3">
    <div class="form-group" style="text-align: center">
        <button  class="btn btn-primary" style="margin-top: 25px" onclick="reporte()"><span class="glyphicon glyphicon-search"></span> Buscar</button>
    </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="col-md-12">
    <table class="table">
        <th >No.</th>
        <th>Fecha entrada</th>
        <th >Nombre del cliente</th>
        <th>Nombre del turoperador (C&oacute;digo)</th>
        <th>¿Pertenece a un tour?</th>
        <tbody id="repTbody">
        <tr><td style='text-align: center' colspan='5'>SIN DATOS PARA MOSTRAR</td></tr>
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function () {
        var today = new Date();
        document.getElementById('repAnno').value=today.getFullYear();
    });

    function reporte() {
        turoperador = document.getElementById('repTuroperador').value;
        $.ajax({
            type:'POST',
            data:{
                method: 'reporte4',
                repTur: turoperador,
            },
            url: '../CONTROLADOR/cc-reservacion.php',
            success: function(result){
                $("#repTbody").html(result);
            },
            error: function (xhr) {
                alert("Ha ocurrido el siguiente error: " + xhr.status + " " + xhr.statusText);
            }
        });
    }
</script>