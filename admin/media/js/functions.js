$(document).ready(function() {

	/* ---------------------------- FILTER AND REUSABLE FUNCTIONS ---------------------------- */

	<!-- Session functions -->
	sessionExpire = function(type) {
		switch(type) {
			case 'main':
				document.location.href='index.php';
				break;
			case 'box':
				$.colorbox.close();
				oTable.fnStandingRedraw();								
				break;	
		}
	}
	
	<!-- Formatting functions -->
	nullToSpace = function(value) {
		if (value==null) {
			return '&nbsp;';
		} else {
			return value;
		}
	}
		
	<!-- List functions -->
	sortListAlpha = function(field) {
		$("select#"+field).html($("select#"+field+" option").sort(function (a, b) {
			return a.text == b.text ? 0 : a.text < b.text ? -1 : 1;
		}));			
	}
	sortListValue = function (field) {
		$("#"+field).html($("#"+field+" option").sort(function (a, b) {
			var aValue = parseInt(a.value);
			var bValue = parseInt(b.value);
			return aValue == bValue ? 0 : aValue < bValue ? -1 : 1;
		}));
	}
	appendListItem = function (field, optionvalue, optiontext) {
		$("select#"+field).prepend($('<option />').attr('value', optionvalue).text(optiontext));
	}
	selectFirstItem = function (field) {
		$("select#"+field).val($("select#"+field+" option:first").val());		
	}								

	<!-- Form Disable/Enable/Clear functions -->
	formUIDisabled = function (form) {
        $("#"+form+" textarea").attr("disabled", true);		
        $("#"+form+" select").attr("disabled", true);		
        $("#"+form+" input[type='text']").attr("disabled", true);
        $("#"+form+" input[type='password']").attr("disabled", true);		
        $("#"+form+" input[type='radio']").attr("disabled", true);
        $("#"+form+" input[type='checkbox']").attr("disabled", true);	
		$("#"+form+" input[type='button']").button("option", "disabled", true);	
		$("#"+form+" input[type='submit']").button("option", "disabled", true);			
	}
	formDisabled = function (form) {
        $("#"+form+" textarea").attr("disabled", true);		
        $("#"+form+" select").attr("disabled", true);		
        $("#"+form+" input[type='text']").attr("disabled", true);
        $("#"+form+" input[type='password']").attr("disabled", true);		
        $("#"+form+" input[type='radio']").attr("disabled", true);
        $("#"+form+" input[type='checkbox']").attr("disabled", true);	
		$("#"+form+" input[type='button']").attr("disabled", true);
		$("#"+form+" input[type='submit']").attr("disabled", true);
	}	
	formUIEnabled = function (form) {
        $("#"+form+" textarea").attr("disabled", false);		
        $("#"+form+" select").attr("disabled", false);		
        $("#"+form+" input[type='text']").attr("disabled", false);
        $("#"+form+" input[type='password']").attr("disabled", false);		
        $("#"+form+" input[type='radio']").attr("disabled", false);
        $("#"+form+" input[type='checkbox']").attr("disabled", false);
		$("#"+form+" input[type='button']").button("option", "disabled", false);	
		$("#"+form+" input[type='submit']").button("option", "disabled", false);					
	}
	formEnabled = function (form) {
        $("#"+form+" textarea").attr("disabled", false);		
        $("#"+form+" select").attr("disabled", false);		
        $("#"+form+" input[type='text']").attr("disabled", false);
        $("#"+form+" input[type='password']").attr("disabled", false);		
        $("#"+form+" input[type='radio']").attr("disabled", false);
        $("#"+form+" input[type='checkbox']").attr("disabled", false);
		$("#"+form+" input[type='button']").attr("disabled", false);
		$("#"+form+" input[type='submit']").attr("disabled", false);			
	}	
	formClear = function (form) {		
		// Clear all input text
		$("#"+form+" :input[type=text]").each(function(){
			$(this).val('');
		});	
		// Clear all password text
		$("#"+form+" :input[type=password]").each(function(){
			$(this).val('');
		});			
		// Clear all checkboxes
		$("#"+form+" :input[type=checkbox]").each(function(){
			$(this).attr("checked", false);
		});					
		// Select first option for selects (not multiple)
		$("#"+form+" select").each(function(){
			if ($(this).attr("multiple")) {				
				$(this).val('');
				$(this).scrollTop(0);
			} else {
				$(this).find("option:first")[0].selected = true; 
			}
		});		
	}	
	
	<!-- Populate List functions -->
	populateCategorias = function(field, context){
		var dfd = new $.Deferred();		
		$.ajax({
			url: "get-json-categoria.php",
			dataType: 'json',
			success: function (j) {
				if(j.error == 'expired'){
					sessionExpire(context);
				} else {				
					var options = ''; 
					$.each(j, function(key, value) { 
						options += '<option value="' + key + '">' + value + '</option>';
					});		
					$('#'+field).html(options);
					// Sort options alphabetically
					sortListAlpha(field);					
					// Append option: "all"
					appendListItem(field, '', 'Todas');
					// Select first item
					selectFirstItem(field);	
					dfd.resolve();								
				}
			}
		});			
		return dfd.promise();	
	}		
	
	<!-- Delete via Link functions -->
	deleteLinkMailing = function(id){	
		if (confirm('Está seguro que desea eliminar la dirección?\n\nEsta acción no puede deshacerse.')) {
			$.post("delete-mailing.php", {id: id}, function(data){
				oTable.fnStandingRedraw();						
			});
		}
	}
	deleteLinkProd = function(id){	
		if (confirm('Está seguro que desea eliminar el producto?\n\nEsta acción no puede deshacerse.')) {
			$.post("delete-prod.php", {id: id}, function(data){
				oTable.fnStandingRedraw();
				alert(data);						
			});
		}
	}		
	deleteLinkEnvio = function(id){	
		if (confirm('Está seguro que desea eliminar la forma de envío?\n\nEsta acción no puede deshacerse.')) {
			$.post("delete-envio.php", {id: id}, function(data){
				oTable.fnStandingRedraw();						
			});
		}
	}									
	
	/* ---------------------------- DIALOG FUNCTIONS ---------------------------- */
	
	// Use this space for dialog related functions			
	
	/* --------------------------------- BOX FUNCTIONS --------------------------------- */	
		
	<!-- Form functions -->
	populateFormGeneric = function (j, target) {	
		$.each(j, function(key, value) { 
			switch ($('#'+target+'-'+key).attr('type')) {
				case 'checkbox':
					if(value==1) {
						$('#'+target+'-'+key).attr('checked', true);
					} else if (value==0) {
						$('#'+target+'-'+key).attr('checked', false);						
					}
					break;						
				default:
					$('#'+target+'-'+key).val(value);
					break;					
			}											
		});			
	}
	populateFormBoxProd = function(id){
		var dfd = new $.Deferred();		
		$.ajax({
			url: "get-json-fich_prod.php?id="+id,
			dataType: 'json',
			success: function (j) {
				if (j.error == 'expired'){
					// Session expired
					sessionExpire('box');				
				} else if (j.empty == true) {
					// Record not found
					$.colorbox.close();
				} else {
					// Populate drop-downs, then form
					$.when(
						populateCategorias("box-categoria_id")
					).then(function(){
						populateFormGeneric(j, "box");
						var rnd = Math.floor(Math.random()*1000000);						
						$("#spnBoxImg1").html('<a href="../prod_img/'+id+'-highlight.png?rnd='+rnd+'" target="_blank" class="lnkBox">Ver existente</a>');
						$("#spnBoxImg2").html('<a href="../prod_img/'+id+'-small.jpg?rnd='+rnd+'" target="_blank" class="lnkBox">Ver existente</a>');
						$("#spnBoxImg3").html('<a href="../prod_img/'+id+'-big.jpg?rnd='+rnd+'" target="_blank" class="lnkBox">Ver existente</a>');												
						dfd.resolve();						
					});				
				}
			}
		});	
		return dfd.promise();				
	}	
	populateFormBoxUsuario = function(id){
		var dfd = new $.Deferred();		
		$.ajax({
			url: "get-json-fich_usr.php?id="+id,
			dataType: 'json',
			success: function (j) {
				if (j.error == 'expired'){
					// Session expired
					sessionExpire('box');				
				} else if (j.empty == true) {
					// Record not found
					$.colorbox.close();
				} else {
					// Populate form
					populateFormGeneric(j, "box");
					dfd.resolve();						
				}
			}
		});	
		return dfd.promise();				
	}	
	populateFormBoxPedido = function(id){
		var dfd = new $.Deferred();		
		$.ajax({
			url: "get-json-fich_ped.php?id="+id,
			dataType: 'json',
			success: function (j) {
				if (j.error == 'expired'){
					// Session expired
					sessionExpire('box');				
				} else if (j.empty == true) {
					// Record not found
					$.colorbox.close();
				} else {
					// Populate form
					populateFormGeneric(j, "box");
					dfd.resolve();						
				}
			}
		});	
		return dfd.promise();				
	}
	populateFormBoxEnvio = function(id){
		var dfd = new $.Deferred();		
		$.ajax({
			url: "get-json-fich_env.php?id="+id,
			dataType: 'json',
			success: function (j) {
				if (j.error == 'expired'){
					// Session expired
					sessionExpire('box');				
				} else if (j.empty == true) {
					// Record not found
					$.colorbox.close();
				} else {
					// Populate form
					populateFormGeneric(j, "box");
					dfd.resolve();						
				}
			}
		});	
		return dfd.promise();				
	}			
	
	<!-- Populate Table functions -->
	populateTableProdColor = function(id){
		$.getJSON("get-json-fich_prod-color.php?id="+id,{}, function(j){
			if(j.error == 'expired'){
				sessionExpire('box');
			} else {			
				var result = '';
				// Check if empty
				if (j.length>0) {				
					<!-- Open Table -->
					result += '<table class="tblBox">';			
					<!-- Table Head -->
					result += '<tr>';
					result += '<th>Color</th>';
					result += '<th width="10%">&nbsp;</th>';					
					result += '<th>ES</th>';					
					result += '<th>EN</th>';										
					result += '<th>Acc.</th>';
					result += '</tr>';
					<!-- Table Data -->
					$.each(j, function(i, object) {
						result += '<tr>';
						result += '<td style="border:1px solid #ffffff" bgcolor="'+object.color_hex+'">&nbsp;</td>';
						result += '<td>&nbsp;</td>';
						result += '<td>'+object.color_nombre_es+'</td>';						
						result += '<td>'+object.color_nombre_en+'</td>';												
						result += '<td><span onclick="javascript:deleteLinkProdColor('+object.color_id+', '+id+')" style="cursor: pointer;" class="ui-icon ui-icon-trash" title="Eliminar"></span></td>';
						result += '</tr>';									
					});
					<!-- Close Table -->
					result += '</table>';
				} else {
					result += '<p><strong>El producto no tiene colores asignados.</strong></p>';					
				}
				$('#divBoxAd1').html(result);
			}
		})				
	}
	populateTableProdTalle = function(id){
		$.getJSON("get-json-fich_prod-talle.php?id="+id,{}, function(j){
			if(j.error == 'expired'){
				sessionExpire('box');
			} else {			
				var result = '';
				// Check if empty
				if (j.length>0) {				
					<!-- Open Table -->
					result += '<table class="tblBox">';			
					<!-- Table Head -->
					result += '<tr>';
					result += '<th>Talle (ES)</th>';
					result += '<th>Talle (EN)</th>';					
					result += '<th>Acc.</th>';
					result += '</tr>';
					<!-- Table Data -->
					$.each(j, function(i, object) {
						result += '<tr>';
						result += '<td>'+object.talle_nombre_es+'</td>';
						result += '<td>'+object.talle_nombre_en+'</td>';
						result += '<td><span onclick="javascript:deleteLinkProdTalle('+object.talle_id+', '+id+')" style="cursor: pointer;" class="ui-icon ui-icon-trash" title="Eliminar"></span></td>';
						result += '</tr>';									
					});
					<!-- Close Table -->
					result += '</table>';
				} else {
					result += '<p><strong>El producto no tiene talles asignados.</strong></p>';					
				}
				$('#divBoxAd2').html(result);
			}
		})				
	}
	populateTableUsuarioPedido = function(id){
		$.getJSON("get-json-fich_usr-pedido.php?id="+id,{}, function(j){
			if(j.error == 'expired'){
				sessionExpire('box');
			} else {			
				var result = '';
				// Check if empty
				if (j.length>0) {				
					<!-- Open Table -->
					result += '<table class="tblBox">';			
					<!-- Table Head -->
					result += '<tr>';
					result += '<th>Pedido Nº</th>';
					result += '<th>Estado</th>';					
					result += '<th>Acc.</th>';										
					result += '</tr>';
					<!-- Table Data -->
					$.each(j, function(i, object) {
						result += '<tr>';
						result += '<td>'+object.pedido_id+'</td>';
						result += '<td>'+object.estado_nombre+'</td>';
						result += '<td><span onclick="javascript:openBoxDetPedido('+object.pedido_id+')" style="cursor: pointer;" class="ui-icon ui-icon-zoomin" title="Ver detalle"></span></td>';																		
						result += '</tr>';									
					});
					<!-- Close Table -->
					result += '</table>';
				} else {
					result += '<p>El usuario no tiene pedidos realizados.</p>';					
				}
				$('#divBoxRelated').html(result);
			}
		})				
	}
	populateTablePedidoUsuario = function(id){
		$.getJSON("get-json-fich_ped-usuario.php?id="+id,{}, function(j){
			if(j.error == 'expired'){
				sessionExpire('box');
			} else {			
				var result = '';
				// Check if empty
				if (j.length>0) {				
					<!-- Open Table -->
					result += '<table class="tblBox">';			
					<!-- Table Head -->
					result += '<tr>';
					result += '<th>Nombre</th>';
					result += '<th>Apellido</th>';					
					result += '<th>Empresa</th>';
					result += '<th>País</th>';					
					result += '<th>Tel</th>';										
					result += '<th>E-mail</th>';															
					result += '<th>Acc.</th>';																				
					result += '</tr>';
					<!-- Table Data -->
					$.each(j, function(i, object) {
						result += '<tr>';
						result += '<td>'+object.usuario_nombre+'</td>';
						result += '<td>'+object.usuario_apellido+'</td>';						
						result += '<td>'+nullToSpace(object.usuario_empresa)+'</td>';						
						result += '<td>'+object.usuario_pais+'</td>';						
						result += '<td>'+object.usuario_tel+'</td>';						
						result += '<td><a href="mailto:'+object.usuario_email+'">'+object.usuario_email+'</a></td>';												
						result += '<td><span onclick="javascript:openBoxDetUsuario('+object.usuario_id+')" style="cursor: pointer;" class="ui-icon ui-icon-zoomin" title="Ver detalle"></span></td>';																		
						result += '</tr>';									
					});
					<!-- Close Table -->
					result += '</table>';
				} else {
					result += '<p><strong>Error: El pedido no tiene un usuario asignado.</strong></p>';					
				}
				$('#divBoxRelated').html(result);
			}
		})				
	}	
	populateTablePedidoItem = function(id){
		$.getJSON("get-json-fich_ped-item.php?id="+id,{}, function(j){
			if(j.error == 'expired'){
				sessionExpire('box');
			} else {			
				var result = '';
				// Check if empty
				if (j.length>0) {	
					var total_final = 0;			
					<!-- Open Table -->
					result += '<table class="tblBox">';			
					<!-- Table Head -->
					result += '<tr>';
					result += '<th>Categoría</th>';
					result += '<th>Producto</th>';					
					result += '<th>Cantidad</th>';
					result += '<th>Precio Unit</th>';
					result += '<th>Total</th>';						
					result += '<th>Talle</th>';																												
					result += '<th>Color</th>';										
					result += '</tr>';
					<!-- Table Data -->
					$.each(j, function(i, object) {
						var total_item = (object.item_cantidad*object.item_preciounit);
						total_final += total_item;
						result += '<tr>';
						result += '<td>'+object.categoria_nombre_es+'</td>';
						result += '<td>'+object.producto_nombre_es+'</td>';
						result += '<td>'+object.item_cantidad+'</td>';
						result += '<td>'+object.item_preciounit+'</td>';						
						result += '<td>'+total_item.toFixed(2)+'</td>';																								
						result += '<td>'+object.item_talle+'</td>';	
						result += '<td>'+object.item_color+'</td>';						
						result += '</tr>';									
					});
					<!-- Total -->
					result += '<tr>';
					result += '<td colspan="4"><strong>TOTAL:</strong></td>';
					result += '<td colspan="3"><strong>'+total_final.toFixed(2)+'</strong></td>';					
					result += '</tr>';										
					<!-- Close Table -->
					result += '</table>';
				} else {
					result += '<p>El pedido no tiene items asignados.</p>';					
				}
				$('#divBoxRelated2').html(result);
			}
		})				
	}			
	
	<!-- Delete via Link functions -->
	deleteLinkProdColor = function(id, parent_id){	
		if (confirm('Está seguro que desea eliminar el color?\n\nEsta acción no puede deshacerse.')) {
			$.post("delete-color.php", {id: id}, function(data){
				// DT standing redraw
				oTable.fnStandingRedraw();						
				// Repopulate table
				populateTableProdColor(parent_id);
			});
		}
	}
	deleteLinkProdTalle = function(id, parent_id){	
		if (confirm('Está seguro que desea eliminar el talle?\n\nEsta acción no puede deshacerse.')) {
			$.post("delete-talle.php", {id: id}, function(data){
				// DT standing redraw
				oTable.fnStandingRedraw();						
				// Repopulate table
				populateTableProdTalle(parent_id);
			});
		}
	}	
	
	<!-- Insert via Form functions -->
	insertFormProdColor = function(id){	
		// Disable button
		$('#btnBoxAd1').button("option", "disabled", true);
		// Post				
		$.post("insert-color.php", $("#frmBoxAd1").serialize(),function(data){			
			// DT redraw
			oTable.fnStandingRedraw();	
			// Populate table
			populateTableProdColor(id);
			// Clear field
			formClear("frmBoxAd1");
			// Enable button
			$('#btnBoxAd1').button("option", "disabled", false);				
		});
	}
	insertFormProdTalle = function(id){	
		// Disable button
		$('#btnBoxAd2').button("option", "disabled", true);
		// Post				
		$.post("insert-talle.php", $("#frmBoxAd2").serialize(),function(data){			
			// DT redraw
			oTable.fnStandingRedraw();	
			// Populate table
			populateTableProdTalle(id);
			// Clear fields
			formClear("frmBoxAd2");
			// Enable button
			$('#btnBoxAd2').button("option", "disabled", false);				
		});
	}
	insertFormEnvio = function(){	
		// Disable button
		$('#btnBoxAlta').button("option", "disabled", true);
		// Post				
		$.post("insert-envio.php", $("#frmBoxAlta").serialize(),function(data){			
			// Table standing redraw
			oTable.fnStandingRedraw();				
			// Set message icon
			if (data.toLowerCase().indexOf("error") == -1) {
				$("#spnBoxIcon").removeClass("ui-icon-alert");				
				$("#spnBoxIcon").addClass("ui-icon-info");
			} else {
				$("#spnBoxIcon").removeClass("ui-icon-info");								
				$("#spnBoxIcon").addClass("ui-icon-alert");				
			}				
			// Show message
			$("#spnBoxMessage").html(data);
			$("#divBoxMessage").show("slow").delay(3000).hide("slow", function(){
				// On callback (last effect)
				if (data.toLowerCase().indexOf("error") == -1) {
					// Reset form
					formClear('frmBoxAlta');												
				}
				// Enable button
				$('#btnBoxAlta').button("option", "disabled", false);				
			});				
		
		});
	}	
	
	<!-- Update vía form functions -->	
	updateFormEnvio = function(){	
		// Disable button
		$('#btnBoxMod').button("option", "disabled", true);
		// Post				
		$.post("update-envio.php", $("#frmBoxMod").serialize(),function(data){			
			// Table standing redraw
			oTable.fnStandingRedraw();				
			// Set message icon
			if (data.toLowerCase().indexOf("error") == -1) {
				$("#spnBoxIcon").removeClass("ui-icon-alert");				
				$("#spnBoxIcon").addClass("ui-icon-info");
			} else {
				$("#spnBoxIcon").removeClass("ui-icon-info");								
				$("#spnBoxIcon").addClass("ui-icon-alert");				
			}				
			// Show message
			$("#spnBoxMessage").html(data);
			$("#divBoxMessage").show("slow").delay(3000).hide("slow", function(){
				// On callback (last effect)
				if (data.toLowerCase().indexOf("error") == -1) {
					// Repopulate form
					populateFormBoxEnvio($('#box-envio_id').val());											
				}
				// Enable button
				$('#btnBoxMod').button("option", "disabled", false);				
			});				
		
		});
	}							
	
	<!-- Open Box functions -->
	openBoxAltaProducto = function () {
		$.colorbox({
			title:'Alta',
			href:'box-prod_alta.php',												
			width:'700px',
			height:'580px',
			onComplete: function() {			
			
				// Initialize buttons
				$("#sbtBoxAlta").button();
				
				// Disable forms
				formUIDisabled('frmBoxAlta');				
				
				// Populate form, then initialize
				$.when(populateCategorias("box-categoria_id")).then(function(){							
					// Validate form
					var validateForm = $("#frmBoxAlta").validate({
						rules: {							
							"box-categoria_id": {required: true},
							"box-producto_nombre_es": {required: true},																					
							"box-producto_nombre_en": {required: true},
							"box-producto_desc_es": {required: true, maxlength: 255},
							"box-producto_desc_en": {required: true, maxlength: 255},
							"box-producto_precio": {required: true, min: 0.1, max: 999999.99},
							"box-image_highlight": {required: true},
							"box-image_small": {required: true},
							"box-image_big": {required: true}
						}					
					});							
					// Submit related functions
					var disableButton = function() { 
						// Disable button
						$('#sbtBoxAlta').button("option", "disabled", true);							
						return true;
					}					
					// Form options
					var options = { 
						url: "insert-producto.php",
						method: "post",
						beforeSubmit: disableButton,						
						success: function (data) {
							// Table standing redraw
							oTable.fnStandingRedraw();				
							// General variables
							var mensaje = '', error = 0;
							// If error occurred (response is text)
							if (isNaN(data)) { 
								// Set variables
								error = 1;
								mensaje = data;	
								// Set icons
								$("#spnBoxIcon").removeClass("ui-icon-info");								
								$("#spnBoxIcon").addClass("ui-icon-alert");											
							} else {
								// Set variables								
								mensaje = '<strong>El registro ha sido creado con éxito.</strong><br />';
								mensaje += '<a href="javascript:openBoxModProd('+data+')" class="lnkBox">Completar información del producto</a>';
								// Set icons								
								$("#spnBoxIcon").removeClass("ui-icon-alert");				
								$("#spnBoxIcon").addClass("ui-icon-info");								
							}
							$("#spnBoxMessage").html(mensaje);			
							$("#divBoxMessage").show(function(){
								// Scroll to bottom
								var objDiv = document.getElementById("cboxLoadedContent");
								objDiv.scrollTop = objDiv.scrollHeight;				
								// If no error occurred
								if (error==0) {
									// Clear form
									$('#frmBoxAlta').each(function(){
										this.reset();
									});
								}
								// Enable button
								$('#sbtBoxAlta').button("option", "disabled", false);
							});	
						}
					}; 										
					// Form initialize
					$("#frmBoxAlta").ajaxForm(options);
				});				
															
				// Enable form							
				formUIEnabled('frmBoxAlta');
				
			}
		});		
	}
	openBoxModProd = function (id) {
		$.colorbox({
			title:'Modificación',
			href:'box-prod_mod.php',												
			width:'945px',
			height:'580px',
			onComplete: function() {			
			
				// Initialize buttons
				$("#sbtBoxMod").button();
				$("#btnBoxAd1").button();
				$("#btnBoxAd2").button();								
							
				// Disable forms
				formUIDisabled('frmBoxMod');	
				formUIDisabled('frmBoxAd1');	
				formUIDisabled('frmBoxAd2');												
				
				// Populate tables
				populateTableProdColor(id);
				populateTableProdTalle(id);				
								
				// PRODUCTO				
				// Populate form, then initialize
				$.when(populateFormBoxProd(id)).then(function(){						
					// Validate form
					var validateForm = $("#frmBoxMod").validate({
						rules: {							
							"box-categoria_id": {required: true},
							"box-producto_nombre_es": {required: true},																					
							"box-producto_nombre_en": {required: true},
							"box-producto_desc_es": {required: true, maxlength: 255},
							"box-producto_desc_en": {required: true, maxlength: 255},
							"box-producto_precio": {required: true, min: 0.1, max: 999999.99}
						}					
					});							
					// Submit related functions
					var beforeSubmit = function() { 
						// Disable button
						$('#sbtBoxMod').button("option", "disabled", true);							
					}					
					// Form options
					var options = { 
						url: "update-producto.php",
						method: "post",
						beforeSubmit: beforeSubmit,						
						success: function (data) {	
							// Table standing redraw
							oTable.fnStandingRedraw();				
							// Set message icon
							if (data.toLowerCase().indexOf("error") == -1) {
								$("#spnBoxIcon").removeClass("ui-icon-alert");				
								$("#spnBoxIcon").addClass("ui-icon-info");
							} else {
								$("#spnBoxIcon").removeClass("ui-icon-info");								
								$("#spnBoxIcon").addClass("ui-icon-alert");				
							}				
							// Show message
							$("#spnBoxMessage").html(data);							
							$("#divBoxMessage").show();
							// Scroll to bottom
							var objDiv = document.getElementById("cboxLoadedContent");
							objDiv.scrollTop = objDiv.scrollHeight;								
							// Delay and hide
							$("#divBoxMessage").delay(3500).hide("slow", function(){
								// On callback (last effect)
								if (data.toLowerCase().indexOf("error") == -1) {
									// Repopulate form
									populateFormBoxProd($('#box-producto_id').val());
								}
								// Enable button
								$('#sbtBoxMod').button("option", "disabled", false);	
							});															
						}
					}; 										
					// Form initialize
					$("#frmBoxMod").ajaxForm(options);
					// Enable form							
					formUIEnabled('frmBoxMod');															
				});		
				
				// COLOR
				// Populate Master ID (Hidden field)
				$('#boxad1-producto_id').val(id);
				// Initialize colorpicker	
				$("#boxad1-color_hex").miniColors();																						
				// Validate form options
				var validateFormAd1 = $("#frmBoxAd1").validate({
					rules: {
						"boxad1-color_hex": {required: true},
						"boxad1-color_nombre_es": {required: true},
						"boxad1-color_nombre_en": {required: true}					
					},	
					messages: {
						"boxad1-color_hex": "Requerido",
						"boxad1-color_nombre_es": "Requerido",
						"boxad1-color_nombre_en": "Requerido"						
					},
				  	errorPlacement: function(error, element) {
						error.appendTo(element.parent("p").after("<a>"));
				   	}
				});														
				// Button action
				$("#btnBoxAd1").click(function() {
					if (validateFormAd1.form()) {
						insertFormProdColor(id);
					};
				});							
				// Enable form							
				formUIEnabled('frmBoxAd1');	
				
				// TALLE
				// Populate Master ID (Hidden field)
				$('#boxad2-producto_id').val(id);
				// Validate form options
				var validateFormAd2 = $("#frmBoxAd2").validate({
					rules: {
						"boxad2-talle_nombre_es": {required: true},
						"boxad2-talle_nombre_en": {required: true}
					},	
					messages: {
						"boxad2-talle_nombre_es": "Requerido",
						"boxad2-talle_nombre_en": "Requerido"						
					}
				});														
				// Button action
				$("#btnBoxAd2").click(function() {
					if (validateFormAd2.form()) {
						insertFormProdTalle(id);
					};
				});						
				// Enable form							
				formUIEnabled('frmBoxAd2');																																													
				
			}
		});		
	}
	openBoxDetUsuario = function (id) {
		$.colorbox({
			title:'Detalle',
			href:'box-usr_det.php',												
			width:'700px',
			height:'580px',
			onComplete: function() {	
			
				// Populate tables
				populateTableUsuarioPedido(id);
				
				// Disable forms
				formUIDisabled('frmBoxDet');	
				
				// Populate forms
				populateFormBoxUsuario(id);				
				
			}
		});		
	}
	openBoxDetPedido = function (id) {
		$.colorbox({
			title:'Detalle',
			href:'box-ped_det.php',												
			width:'700px',
			height:'520px',
			onComplete: function() {	
			
				// Populate tables
				populateTablePedidoUsuario(id);
				populateTablePedidoItem(id);						
				
				// Disable forms
				formUIDisabled('frmBoxDet');	
				
				// Populate forms
				populateFormBoxPedido(id);				
				
			}
		});		
	}	
	openBoxAltaEnvio = function () {
		$.colorbox({
			title:'Alta',
			href:'box-envio_alta.php',												
			width:'700px',
			height:'350px',
			onComplete: function() {			
			
				// Initialize buttons
				$("#btnBoxAlta").button();
				
				// Disable forms
				formUIDisabled('frmBoxAlta');				
											
				// Validate form
				var validateForm = $("#frmBoxAlta").validate({
					rules: {							
						"box-envio_nombre_es": {required: true},																					
						"box-envio_nombre_en": {required: true},
						"box-envio_precio": {required: true, min: 0, max: 999999.99}
					}					
				});										
				// Button action	
				$("#btnBoxAlta").click(function() {
					if (validateForm.form()) {
						insertFormEnvio();
					};
				});																						
				// Enable form							
				formUIEnabled('frmBoxAlta');
				
			}
		});		
	}
	openBoxModEnvio = function (id) {
		$.colorbox({
			title:'Modificación',
			href:'box-envio_mod.php',												
			width:'700px',
			height:'350px',
			onComplete: function() {			
			
				// Initialize buttons
				$("#btnBoxMod").button();
				
				// Disable forms
				formUIDisabled('frmBoxMod');				
				
				// Populate form, then initialize
				$.when(populateFormBoxEnvio(id)).then(function(){					
					// Validate form
					var validateForm = $("#frmBoxMod").validate({
						rules: {							
							"box-envio_nombre_es": {required: true},																					
							"box-envio_nombre_en": {required: true},
							"box-envio_precio": {required: true, min: 0, max: 999999.99}
						}					
					});					
					// Button action	
					$("#btnBoxMod").click(function() {
						if (validateForm.form()) {
							updateFormEnvio();
						};
					});																					
					// Enable form							
					formUIEnabled('frmBoxMod');
				});
				
			}
		});		
	}																							
	
});