<?php
	$MM_authorizedUsers = "admin";	
?>
<?php require_once('inc/security-colorbox.php'); ?>

<div class="divBoxContainer" style="width:96%">

    <!-- USUARIO -->
    <form class="frmBoxMain" name="frmBoxDet" id="frmBoxDet">
        <fieldset class="ui-widget ui-widget-content ui-corner-all">
            <legend class="ui-widget ui-widget-header ui-corner-all">Usuario</legend>           
            <p>
                <label for="box-usuario_nombre">Nombre</label>
                <input type="text" name="box-usuario_nombre" id="box-usuario_nombre" maxlength="255" class="ui-widget-content" style="width:460px"/>
            </p> 
            <p>
                <label for="box-usuario_apellido">Apellido</label>
                <input type="text" name="box-usuario_apellido" id="box-usuario_apellido" maxlength="255" class="ui-widget-content" style="width:460px" />
            </p>
            <p>
                <label for="box-usuario_empresa">Empresa</label>
                <input type="text" name="box-usuario_empresa" id="box-usuario_empresa" maxlength="255" class="ui-widget-content" style="width:460px" />
            </p> 
            <p>
                <label for="box-usuario_tel">Teléfono</label>
                <input type="text" name="box-usuario_tel" id="box-usuario_tel" maxlength="255" class="ui-widget-content" style="width:460px" />
            </p>                 
            <p>
                <label for="box-usuario_email">E-mail</label>
                <input type="text" name="box-usuario_email" id="box-usuario_email" maxlength="255" class="ui-widget-content" style="width:460px" />
            </p> 
            <p>
                <label for="box-usuario_passreset">Password Reset</label>
                <input type="checkbox" name="box-usuario_passreset" id="box-usuario_passreset" value="1" />
            </p>
            <p>
                <label for="box-usuario_direccion1">Dirección 1</label>
                <input type="text" name="box-usuario_direccion1" id="box-usuario_direccion1" maxlength="255" class="ui-widget-content" style="width:460px" />
            </p>
            <p>
                <label for="box-usuario_direccion2">Dirección 2</label>
                <input type="text" name="box-usuario_direccion2" id="box-usuario_direccion2" maxlength="255" class="ui-widget-content" style="width:460px" />
            </p> 
            <p>
                <label for="box-usuario_ciudad">Ciudad</label>
                <input type="text" name="box-usuario_ciudad" id="box-usuario_ciudad" maxlength="255" class="ui-widget-content" style="width:460px" />
            </p>
            <p>
                <label for="box-usuario_estado">Estado</label>
                <input type="text" name="box-usuario_estado" id="box-usuario_estado" maxlength="255" class="ui-widget-content" style="width:460px" />
            </p>
            <p>
                <label for="box-usuario_cp">Código Postal</label>
                <input type="text" name="box-usuario_cp" id="box-usuario_cp" maxlength="255" class="ui-widget-content" style="width:460px" />
            </p>  
            <p>
                <label for="box-usuario_pais">País</label>
                <input type="text" name="box-usuario_pais" id="box-usuario_pais" maxlength="255" class="ui-widget-content" style="width:460px" />
            </p>                                                                  
        </fieldset>
	</form>  
    
    <!-- PEDIDOS -->    
    <fieldset class="ui-widget ui-widget-content ui-corner-all" style="margin-top:20px">
        <legend class="ui-widget ui-widget-header ui-corner-all" style="padding:5px">Pedidos realizados</legend> 
        <div id="divBoxRelated">Cargando...</div>
    </fieldset>                       
    
</div>