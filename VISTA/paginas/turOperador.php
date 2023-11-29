<?php
    include '../CONTROLADOR/cc-nomenclador.php';
    
?>
<div class="col-md-6 col-md-offset-3">
    <form action="../CONTROLADOR/cc-tur.php" method="post" class="form-horizontal">

        <h1><p>Registrar TurOperadores</p></h1>
        <hr>
        <div class="col-md-12">
            <div class="form-group">
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo isset($_GET['editar'])?@$nombre:''?>" required>
            </div>
            <div class="form-group">
                <label for="codigo">Código: </label>
                <input type="text" name="codigo" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="nacionalidad">Nacionalidad: </label>
                <select name="nacionalidad" id="nacionalidad" class="custom-select form-control" required>
                    <option value="">Seleccione el país ...</option>
                    <?php foreach ($nacionalidades as $item) {
                        echo "<option value='".$item['id_nacionalidad']."' ".(isset($_GET['editar']) && $item['id_nacionalidad']==@$nacionalidad?"selected":"").">".$item['descripcion']."</option>";
                    }?>
                </select>
            </div>
        </div>

        <div class="clearfix"></div>

        <p>
            
            <button type="submit" class="btn btn-primary" value="insertar" name="insertar">Registrar</button>
                
                
        </p>

    </form>

</div>