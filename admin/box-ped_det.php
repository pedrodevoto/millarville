<?php
	$MM_authorizedUsers = "admin";	
?>
<?php require_once('inc/security-colorbox.php'); ?>

<div class="divBoxContainer" style="width:96%">

    <!-- USUARIO -->    
    <fieldset class="ui-widget ui-widget-content ui-corner-all">
        <legend class="ui-widget ui-widget-header ui-corner-all" style="padding:5px">Usuario</legend> 
        <div id="divBoxRelated">Cargando...</div>
    </fieldset> 

    <!-- PEDIDO -->
    <form class="frmBoxMain" name="frmBoxDet" id="frmBoxDet" style="margin-top:20px">
        <fieldset class="ui-widget ui-widget-content ui-corner-all">
            <legend class="ui-widget ui-widget-header ui-corner-all">Pedido</legend>           
            <p>
                <label for="box-pedido_id">Pedido Nº</label>
                <input type="text" name="box-pedido_id" id="box-pedido_id" maxlength="10" class="ui-widget-content" style="width:460px"/>
            </p> 
            <p>
                <label for="box-pedido_fecha">Fecha</label>
                <input type="text" name="box-pedido_fecha" id="box-pedido_fecha" maxlength="255" class="ui-widget-content" style="width:460px"/>
            </p>            
            <p>
                <label for="box-estado_nombre">Estado</label>
                <input type="text" name="box-estado_nombre" id="box-estado_nombre" maxlength="255" class="ui-widget-content" style="width:460px"/>
            </p>             
        </fieldset>
	</form>  
    
    <!-- ITEMS -->    
    <fieldset class="ui-widget ui-widget-content ui-corner-all" style="margin-top:10px">
        <legend class="ui-widget ui-widget-header ui-corner-all" style="padding:5px">Items del pedido</legend> 
        <div id="divBoxRelated2">Cargando...</div>
    </fieldset>                       
    
</div>