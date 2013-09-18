<?php
	$MM_authorizedUsers = "admin";
?>
<?php require_once('inc/security.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Admin - Pedidos - Listado</title>

		<?php require_once('inc/library.php'); ?> 
        
        <!-- Data source variables and related functions -->
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {		        
			
				// IMPORTANT VARIABLES(!)
				sourceURL = "section-pedido_listado-serv.php";
			
			});
		</script>                   
        
        <!-- DataTables initialization -->
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {		

				oTable = $('#table1').dataTable({	

					"sDom": '<"H"l<"#dtDivHeaderIcons">fr>t<"F"ip>',
					"oLanguage": {
						"sProcessing":   "Procesando...",
						"sLengthMenu":   "Mostrar _MENU_ registros",
						"sZeroRecords":  "No se encontraron resultados",
						"sInfo":         "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
						"sInfoEmpty":    "Mostrando desde 0 hasta 0 de 0 registros",
						"sInfoFiltered": "(filtrado de _MAX_ registros en total)",
						"sInfoPostFix":  "",
						"sSearch":       "Buscar en todos:",
						"sUrl":          "",
						"oPaginate": {
							"sFirst":    "Primero",
							"sPrevious": "Anterior",
							"sNext":     "Siguiente",
							"sLast":     "Último"
						}
					},
					"indicator": "Guardando...",
					"bFilter": true,					
					"bJQueryUI": true,
					"bAutoWidth": false,
					"bPaginate": true,
					"sPaginationType": "full_numbers",	
					"bProcessing": true,
					"bServerSide": true,					
					"sAjaxSource": sourceURL+'?action=view',
					"aoColumns": [
						{"bWidth": "15%"},
						{"bWidth": "15%"},
						{"bWidth": "15%"},
						{"bWidth": "15%"},
						{"bWidth": "15%"},
						{"bWidth": "15%"},																																				
						{"bWidth": "10%", "bSearchable": false, "bSortable": false, "fnRender": function (oObj) { return '<span title="Ver detalle" class="ui-icon ui-icon-zoomin" style="cursor: pointer;" onclick="javascript:openBoxDetPedido('+oObj.aData[0]+');"></span>'; }}
					],	
					"aaSorting": [[0,'desc']],					
					
					// Avoid session expired errors
					"fnServerData": function (sSource, aoData, fnCallback) {
						$.getJSON(sSource, aoData, function (json) {
							if(json.error == 'expired'){
								document.location.href='index.php';
							} else{
								fnCallback(json)
							}
						});
					},
					
					"fnDrawCallback": function(){
						// Editable: Estado
						$('td:eq(2)', this.fnGetNodes()).editable( 'update-pedido_estado.php', {
							"placeholder": "",							
							"cssclass": "dtFormSelect",
							"event": "click",							
							"loadurl": "get-json-esta.php",
							"type": "select",						
							"onsubmit": function (settings, self) {
								var aPos = oTable.fnGetPosition(self);
								var aData = oTable.fnGetData(aPos[0]);
								settings.submitdata = {id: aData[0],nombre: $(this).find(":selected").text()};
								return true;
							},		
							"callback": function() {
								oTable.fnStandingRedraw();	
							},								
							"onblur": function () {
								this.reset();
							},											
							"tooltip": "Click para editar"
						} );
					}
											
				}).columnFilter({
					"sPlaceHolder": "head:foot",					
					aoColumns: [
						{type: "text"},
						{type: "text"},
						{type: "text"},
						{type: "text"},
						{type: "text"},
						{type: "text"},												
						null
					]
				}); // Enable column filtering												

			});	
		</script>      

	</head>
	<body>     
		<div id="divContainer">
        
            <!-- Include Header -->
            <?php include('inc/header.php'); ?>   
                 
            <!-- Table Start (custom padding No-Filter) -->                              	
            <div id="divTable" style="padding-top:15px">            
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="table1">
                    <thead>
                        <tr>                        
                            <th>Nº Pedido</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Nombre</th>
                            <th>Apellido</th>                                                                                                                                        
                            <th>País</th>
                            <th>Acc</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>                    
	                <tfoot>
                        <tr>
                            <th>Nº Pedido</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Nombre</th>
                            <th>Apellido</th>                                                                                                                                        
                            <th>País</th>
                            <th></th>                  
                        </tr>
                    </tfoot>                    
                </table>
            </div>
            <!-- Table End -->                  

    	</div>
	</body>
</html>