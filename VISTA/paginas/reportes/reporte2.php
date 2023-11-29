<!-- Inciso d)
Implemente la funcionalidad necesaria para determinar
el mes del pasado año que hubo más clientes en el hotel
 de una nacionalidad dada.
-->
<?php include_once '../CONTROLADOR/cc-nomenclador.php' ?>
<div class="col-md-12">
    <div class="form-group">
        <h2 style="">Mes(es) con m&aacute;s clientes de una nacionalidad </h2>
        <!---->
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Nacionalidad:</label>
            <select id="repNacionalidad" name="nacionalidad" class="form-control" required>
                <option value="">Seleccione un elemento ... </option>
                <?php foreach ($nacionalidades as $nacionalidad){
                    echo "<option value='".$nacionalidad['id_nacionalidad']."'>".$nacionalidad['descripcion']."</option>";
                } ?>
            </select>
        </div>
    </div>
    <div class="col-md-3" >
        <div class="form-group">
            <label for="">A&ntilde;o:</label>
            <input id="repAnno" name="anno" type="number" style="-webkit-appearance: textfield" class="form-control">

        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group" style="text-align: center">
        <button  class="btn btn-primary" style="margin-top: 25px" onclick="reporte1()"><span class="glyphicon glyphicon-search"></span> Buscar</button>
    </div>
</div>
<div class="col-md-12">
    <table class="table">
        <th >No.</th>
        <th>Mes</th>
        <th title="Cantidad de reservaciones por nacionalidad">Cantidad</th>
        <th>Nacionalidad</th>
        <tbody id="repTbody">
        <tr><td style='text-align: center' colspan='4'>SIN DATOS PARA MOSTRAR</td></tr>
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function () {
        var today = new Date();
        document.getElementById('repAnno').value=today.getFullYear();
    });

    function reporte1() {
        anno = document.getElementById('repAnno').value;
        nacionalidad = document.getElementById('repNacionalidad').value;
        $.ajax({
            type:'POST',
            data:{
                method: 'reporte2',
                repNac: nacionalidad,
                repAnno: anno
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