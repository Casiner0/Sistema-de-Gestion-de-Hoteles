$(function() {
    alertaLogin($("#alerta_login"));
    
});


/*
 * ##############################
 * # FUNCIONES PARA RESERVACION #
 * ##############################
 */
function activarDatosCliente($this) {
    limpiarDatosCliente();
    $reservInfoCliente = document.getElementById('reservInfoCliente');
    if($reservInfoCliente !== null){
        if($this.value==="otro"){
            $reservInfoCliente.disabled=false;
        }else{
            $reservInfoCliente.disabled=true;
            $optionSelected = $this.selectedOptions[0];
            $datos = JSON.parse($optionSelected.getAttribute('data-cliente'));
            if($datos!=null){
                document.getElementById('reservClienteNombre').value= $datos.nombre;
                document.getElementById('reservClienteEdad').value= $datos.edad;
                $sexoOptions = document.getElementById('reservClienteSexo').options;
                for($i=0;$sexoOptions.length>$i;$i++){
                    if($sexoOptions[$i].text===$datos.sexo){
                        $sexoOptions[$i].selected=true;
                        break;
                    }
                }
                $nacionalidadOptions = document.getElementById('reservClienteNacionalidad').options;
                for($i=0;$nacionalidadOptions.length>$i;$i++){
                    if($nacionalidadOptions[$i].text===$datos.nacionalidad){
                        $nacionalidadOptions[$i].selected=true;
                        break;
                    }
                }

            }
        }
    }
}

function limpiarDatosCliente() {
    document.getElementById('reservClienteNombre').value='';
    document.getElementById('reservClienteEdad').value='';
    document.getElementById('reservClienteSexo').options[0].selected=true;
    document.getElementById('reservClienteNacionalidad').options[0].selected=true;
}

function activarPerteneceTur($this) {
    if($this.value===""){
        document.getElementById('reservTuroperadorPertenece').options[0].selected = true;
        document.getElementById('reservTuroperadorPertenece').disabled = true;
    }else {
        document.getElementById('reservTuroperadorPertenece').disabled = false;
    }
}

/*
 * ########################
 * # FUNCIONES PARA LOGIN #
 * ########################
 */

 function alertaLogin(div) {
    div.slideDown(1000);
    setTimeout(function(){
        div.slideUp(500);
    }, 3000);
 }