<?php
include '../CONTROLADOR/cc-nomenclador.php';
include '../CONTROLADOR/cc-cliente.php';
?>
<div class="col-md-6 col-md-offset-3">
    <form action="../CONTROLADOR/cc-cliente.php" method="post" class="form-horizontal">

        <h1><p><?php echo isset($_GET['editar'])?'Editar':'Registrar'?> cliente</p></h1>
        <hr>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Nombre: </label>
                <input type="text" name="nombre" class="form-control" value="<?php echo isset($_GET['editar'])?@$nombre:''?>" required>
            </div>
            <div class="form-group">
                <label for="">Edad: </label>
                <input type="text" name="edad" class="form-control" value="<?php echo isset($_GET['editar'])?@$edad:''?>" required>
            </div>
            <div class="form-group">
                <label for="">Sexo: </label>
                <select name="sexo" id="" class="form-control" required>
                    <option value="">Seleccione un elemento ...</option>
                    <?php foreach ($sexos as $item) {
                       echo "<option value='".$item['id_sexo']."' ".(isset($_GET['editar']) && $item['id_sexo']==@$sexo?"selected":"").">".$item['descripcion']."</option>";
                    }?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Nacionalidad: </label>
                <select name="nacionalidad" id="" class="form-control" required>
                    <option value="">Seleccione el país ...</option>
                    <?php foreach ($nacionalidades as $item) {
                        echo "<option value='".$item['id_nacionalidad']."' ".(isset($_GET['editar']) && $item['id_nacionalidad']==@$nacionalidad?"selected":"").">".$item['descripcion']."</option>";
                    }?>
                </select>
            </div>
            <?php if(isset($_GET['editar'])){ ?>
            <div class="form-group">
                <label for=""> Reiterado: </label>
                <input type="checkbox" name="reiterado" class="form-inline" value=true <?php echo (isset($_GET['editar']) && @$reiterado?"checked":"")?>>
            </div>
            <?php }?>
        </div>

        <div class="clearfix"></div>

        <p>
            <?php
                if(!isset($_GET['editar'])){
                ?>
                <button type="submit" class="btn btn-primary" value="insertar" name="insertar">Registrar cliente
                </button>
                <?php
            }else{
            ?>
            <button type="submit" class="btn btn-primary" value="<?php echo $_GET['editar'] ?>" name="editar">Actualizar cliente</button>
            <?php
            }
            ?>
        </p>

    </form>

</div>