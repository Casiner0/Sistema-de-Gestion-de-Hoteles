<!-- Inciso c)
Implemente la funcionalidad para determinar el porciento
de las reservaciones hechas en la recepción del hotel en
lo que va de mes que fueron hechas por clientes de una
nacionalidad dada.
-->
<!--style="float: right;text-decoration: none; padding: 5px;"-->
<div class="col-md-12">
    <div class="form-group">
        <h2 style="">Porciento
            de reservaciones por nacionalidad</h2>
        <?php include_once '../CONTROLADOR/cc-nomenclador.php' ?>

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
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Mes:</label>
                    <select name="mes" id="repMes" class="form-control" required>
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3" >
                <div class="form-group">
                    <label for="">A&ntilde;o:</label>
                    <input id="repAnno" name="anno" type="number" style="-webkit-appearance: textfield" class="form-control">

                </div>
            </div>
            <div class="col-md-3" >
                <div class="form-group">
                    <label for="">¿Con TurOperador?</label>
                    <select name="turoperador" id="repTurOperador" class="form-control">
                        <option value="N">No</option>
                        <option value="S">Si</option>
                        <option value="T">Todos</option>
                    </select>

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
        <th>Cantidad/Total (%)</th>
        <th>Nacionalidad</th>
        <tbody id="rep1Tbody">
        <tr><td style='text-align: center' colspan='3'>SIN DATOS PARA MOSTRAR</td></tr>
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function () {
        var today = new Date();
        document.getElementById('repAnno').value=today.getFullYear();
        document.getElementById('repMes').value=(today.getMonth()+1);
    });

    function reporte1() {
        mes = document.getElementById('repMes').value;
        anno = document.getElementById('repAnno').value;
        nacionalidad = document.getElementById('repNacionalidad').value;
        turoperador = document.getElementById('repTurOperador').value;
        $.ajax({
            type:'POST',
            data:{
                method: 'reporte1',
                repMes: mes,
                repNac: nacionalidad,
                repTur: turoperador,
                repAnno: anno
            },
            url: '../CONTROLADOR/cc-reservacion.php',
            success: function(result){
                $("#rep1Tbody").html(result);
            },
            error: function (xhr) {
                alert("Ha ocurrido el siguiente error: " + xhr.status + " " + xhr.statusText);
            }
        });
    }
</script>