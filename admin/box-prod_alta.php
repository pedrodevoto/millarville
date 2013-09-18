<?php
	$MM_authorizedUsers = "admin";	
?>
<?php require_once('inc/security-colorbox.php'); ?>

<div class="divBoxContainer" style="width:94%">

	<form name="frmBoxAlta" id="frmBoxAlta" class="frmBoxMain">
    	<!-- Producto -->
		<fieldset class="ui-widget ui-widget-content ui-corner-all">
            <legend class="ui-widget ui-widget-header ui-corner-all">Producto</legend>    
            <p>
                <label for="box-categoria_id">Categoria *</label>
                <select name="box-categoria_id" id="box-categoria_id" class="ui-widget-content" style="width:120px"> 
                	<option value="">Cargando</option>                                    
                </select>
            </p>             
            <p>
                <label for="box-producto_nombre_es">Nombre (Español) *</label>
                <input type="text" name="box-producto_nombre_es" id="box-producto_nombre_es" maxlength="255" class="ui-widget-content" style="width:220px" />
            </p>
            <p>
                <label for="box-producto_nombre_en">Nombre (Inglés) *</label>
                <input type="text" name="box-producto_nombre_en" id="box-producto_nombre_en" maxlength="255" class="ui-widget-content" style="width:220px" />
            </p> 
            <p>
                <label for="box-producto_desc_es">Descripción (Español) *</label>
                <textarea name="box-producto_desc_es" id="box-producto_desc_es" class="ui-widget-content" style="width:220px;" />
            </p>
            <p>
                <label for="box-producto_desc_en">Descripción (Inglés) *</label>
                <textarea name="box-producto_desc_en" id="box-producto_desc_en" class="ui-widget-content" style="width:220px;" />
            </p>            
            <p>
                <label for="box-producto_precio">Precio *</label>
                <input type="text" name="box-producto_precio" id="box-producto_precio" maxlength="9" class="ui-widget-content" style="width:60px" />
            </p>                                          
            <p>
                <label for="box-producto_destacado">Destacado *</label>
                <select name="box-producto_destacado" id="box-producto_destacado" class="ui-widget-content" style="width:60px"> 
                	<option value="0">NO</option>
                	<option value="1">SI</option>                    
                </select>
            </p>
            <p>
                <label for="box-producto_ocultar">Ocultar *</label>
                <select name="box-producto_ocultar" id="box-producto_ocultar" class="ui-widget-content" style="width:60px"> 
                	<option value="0">NO</option>
                	<option value="1">SI</option>                    
                </select>
            </p>                                                          
        </fieldset>   
        <!-- Fotos -->      
		<fieldset class="ui-widget ui-widget-content ui-corner-all" style="margin-top:20px">        
			<legend class="ui-widget ui-widget-header ui-corner-all">Fotos</legend>   
            <p>
	    	    <label>Imagen Destacada *<br />(PNG, 350x188)</label> <input type="file" name="box-image_highlight" id="box-image_highlight" />
			</p>
            <p>
	    	    <label>Imagen Pequeña *<br />(JPG, 286x200) </label> <input type="file" name="box-image_small" id="box-image_small" />
			</p>                            
            <p>
	    	    <label>Imagen Grande *<br />(JPG, 460x340) </label> <input type="file" name="box-image_big" id="box-image_big" />
			</p>                                        
        </fieldset>              
        <!-- Acciones -->
        <p align="center" style="margin-top:20px">
		    <input type="hidden" name="MAX_FILE_SIZE" value="2048000" />        
            <input type="hidden" name="box-insert" id="box-insert" value="1" />            
            <input type="submit" name="sbtBoxAlta" id="sbtBoxAlta" value="Crear" />
        </p>        
        <!-- Nota -->
	    <p align="center" style="margin-top:10px" class="txtBox"><strong>Importante:</strong> Una vez creado el producto, debe asignar al menos un talle y color para que aparezca en el sitio.</p>                
	</form>
    <div id="divBoxMessage" class="ui-state-highlight ui-corner-all divBoxMessage"> 
        <p><span class="ui-icon spnBoxMessage" id="spnBoxIcon"></span>
        <span id="spnBoxMessage"></span></p>
    </div>
    
</div>