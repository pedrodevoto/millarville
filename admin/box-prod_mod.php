<?php
	$MM_authorizedUsers = "admin";	
?>
<?php require_once('inc/security-colorbox.php'); ?>

<div class="divBoxContainer" style="width:96%">

	<!-- COLUMN 1 -->
    <div style="float: left; width:71%"> 

		<!-- PRODUCTO -->
        <form name="frmBoxMod" id="frmBoxMod" class="frmBoxMain">
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
            <!-- Acciones -->
            <p align="center" style="margin-top:20px">
                <input type="hidden" name="MAX_FILE_SIZE" value="2048000" />        
                <input type="hidden" name="box-producto_id" id="box-producto_id" />            
                <input type="submit" name="sbtBoxMod" id="sbtBoxMod" value="Modificar" />
            </p>        
        </form>
        <div id="divBoxMessage" class="ui-state-highlight ui-corner-all divBoxMessage"> 
            <p><span class="ui-icon spnBoxMessage" id="spnBoxIcon"></span>
            <span id="spnBoxMessage"></span></p>
        </div>
        <!-- Fotos -->      
		<div style="margin-top:20px">
		    <fieldset class="ui-widget ui-widget-content ui-corner-all">
		        <legend class="ui-widget ui-widget-header ui-corner-all" style="padding:5px">Fotos</legend> 
				<form id="fileForm" action="upload-producto_foto.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="fotos-producto_id" id="fotos-producto_id" value="" />
				    <p>
				        <label for="box-producto_foto">Subir</label>
				        <input type="file" name="box-producto_foto" id="box-producto_foto" class="ui-widget-content" style="width:220px" />
						<input type="submit" value="Subir foto"> <span id="fotosLoading" style="display:none"><img title="Subiendo..." src="media/images/fotos-loading.gif" /></span>
				    </p>
				</form>
				<div id="divBoxFotos" style="width:600px;height:135px;overflow:auto;white-space: nowrap;display:none">
				</div>
			</fieldset>
		</div>         
        <br />
        
    </div>
    <!-- END COLUMN 1 -->        
    
    <!-- COLUMN 2 -->
    <div style="float: right; width:27%">

		<!-- COLORES -->
        <form name="frmBoxAd1" id="frmBoxAd1" class="frmBoxAd">
            <fieldset class="ui-widget ui-widget-content ui-corner-all">
                <legend class="ui-widget ui-widget-header ui-corner-all">Agregar colores</legend>    
                <p>
                    <label for="boxad1-color_hex">Color *</label><br />
                    <input type="text" name="boxad1-color_hex" id="boxad1-color_hex" maxlength="7" class="ui-widget-content" style="width:65px" />
                </p>                     
                <p>
                    <label for="boxad1-color_nombre_es">Nombre (Español) *</label><br />
                    <input type="text" name="boxad1-color_nombre_es" id="boxad1-color_nombre_es" maxlength="255" class="ui-widget-content" style="width:100px" />
                </p>                        
                <p>
                    <label for="boxad1-color_nombre_en">Nombre (Inglés) *</label><br />
                    <input type="text" name="boxad1-color_nombre_en" id="boxad1-color_nombre_en" maxlength="255" class="ui-widget-content" style="width:100px" />
                </p>                   
                <p>
                    <input type="hidden" name="boxad1-producto_id" id="boxad1-producto_id" />
                    <input type="button" name="btnBoxAd1" id="btnBoxAd1" value="Agregar" />                
                </p>                             
            </fieldset>
        </form>
        <fieldset class="ui-widget ui-widget-content ui-corner-all" style="margin-top:10px;">
            <legend class="ui-widget ui-widget-header ui-corner-all" style="padding:5px">Colores asignados</legend> 
            <div id="divBoxAd1">Cargando...</div>
        </fieldset> 
               
        <!-- TALLES -->
        <form name="frmBoxAd2" id="frmBoxAd2" class="frmBoxAd" style="margin-top:20px">
            <fieldset class="ui-widget ui-widget-content ui-corner-all">
                <legend class="ui-widget ui-widget-header ui-corner-all">Agregar talles</legend>    
                <p>
                    <label for="boxad2-talle_nombre_es">Talle (Español) *</label><br />
                    <input type="text" name="boxad2-talle_nombre_es" id="boxad2-talle_nombre_es" maxlength="255" class="ui-widget-content" style="width:100px" />
                </p>                        
                <p>
                    <label for="boxad2-talle_nombre_en">Talle (Inglés) *</label><br />
                    <input type="text" name="boxad2-talle_nombre_en" id="boxad2-talle_nombre_en" maxlength="255" class="ui-widget-content" style="width:100px" />
                </p>                                        
                <p>
                    <input type="hidden" name="boxad2-producto_id" id="boxad2-producto_id" />
                    <input type="button" name="btnBoxAd2" id="btnBoxAd2" value="Agregar" />                
                </p>                             
            </fieldset>
        </form>
        <fieldset class="ui-widget ui-widget-content ui-corner-all" style="margin-top:10px">
            <legend class="ui-widget ui-widget-header ui-corner-all" style="padding:5px">Talles asignados</legend> 
            <div id="divBoxAd2">Cargando...</div>
        </fieldset>    
        <br />              

    </div>
    
</div>