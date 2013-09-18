<?php
	$MM_authorizedUsers = "admin";	
?>
<?php require_once('inc/security-colorbox.php'); ?>

<div class="divBoxContainer" style="width:94%">

	<form name="frmBoxAlta" id="frmBoxAlta" class="frmBoxMain">
    	<!-- Envío -->
		<fieldset class="ui-widget ui-widget-content ui-corner-all">
            <legend class="ui-widget ui-widget-header ui-corner-all">Envío</legend>               
            <p>
                <label for="box-envio_nombre_es">Nombre (Español) *</label>
                <input type="text" name="box-envio_nombre_es" id="box-envio_nombre_es" maxlength="255" class="ui-widget-content" style="width:220px" />
            </p>
            <p>
                <label for="box-envio_nombre_en">Nombre (Inglés) *</label>
                <input type="text" name="box-envio_nombre_en" id="box-envio_nombre_en" maxlength="255" class="ui-widget-content" style="width:220px" />
            </p>            
            <p>
                <label for="box-envio_precio">Precio *</label>
                <input type="text" name="box-envio_precio" id="box-envio_precio" maxlength="9" class="ui-widget-content" style="width:60px" />
            </p> 
            <p>
                <label for="box-envio_ocultar">Ocultar *</label>
                <select name="box-envio_ocultar" id="box-envio_ocultar" class="ui-widget-content" style="width:60px"> 
                	<option value="0">NO</option>
                	<option value="1">SI</option>                    
                </select>
            </p>                                                          
        </fieldset>               
        <!-- Acciones -->
        <p align="center" style="margin-top:20px">     
            <input type="hidden" name="box-insert" id="box-insert" value="1" />            
            <input type="button" name="btnBoxAlta" id="btnBoxAlta" value="Crear" />
        </p>        
	</form>
    <div id="divBoxMessage" class="ui-state-highlight ui-corner-all divBoxMessage"> 
        <p><span class="ui-icon spnBoxMessage" id="spnBoxIcon"></span>
        <span id="spnBoxMessage"></span></p>
    </div>
    
</div>