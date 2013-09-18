<?php
	$MM_authorizedUsers = "admin";
?>
<?php require_once('inc/security.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Admin - Formas de Envío - Listado</title>

		<?php require_once('inc/library.php'); ?> 
        
        <!-- Data source variables and related functions -->
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {		        
			
				// IMPORTANT VARIABLES(!)
				sourceURL = "section-envio_listado-serv.php";				
			
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
						{"sWidth": "35%"},
						{"sWidth": "35%"},
						{"sWidth": "10%", "bSearchable": false},
						{"sWidth": "10%", "bSearchable": false},						
						{"sWidth": "10%", "bSearchable": false, "bSortable": false, "fnRender": function (oObj) { return '<ul class="dtInlineIconList ui-widget ui-helper-clearfix"><li title="Modificar" onclick="openBoxModEnvio('+oObj.aData[5]+');"><span class="ui-icon ui-icon-pencil"></span></li><li title="Eliminar" onclick="deleteLinkEnvio('+oObj.aData[5]+');"><span class="ui-icon ui-icon-trash"></span></li></ul>'; }},						
						// Hidden fields
						{"bSearchable": false, "bVisible": false}						
					],	
					"aaSorting": [[0,'asc']],					
					
					// Avoid session expired errors
					"fnServerData": function (sSource, aoData, fnCallback) {
						$.getJSON(sSource, aoData, function (json) {
							if(json.error == 'expired'){
								document.location.href='index.php';
							} else{
								fnCallback(json)
							}
						});
					}						
											
				}).columnFilter({
					"sPlaceHolder": "head:foot",					
					aoColumns: [
						{type: "text"},
						{type: "text"},
						null,
						null,												
						null,	
						null																		
					]
				}); // Enable column filtering	
				
				// Datatables Header Icons
				$('#dtDivHeaderIcons').load('section-envio_listado-dticons.php', function(data){
					if (data=='Session expired') {
						sessionExpire('main');
					}
				});												

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
                            <th>Nombre (ES)</th>
                            <th>Nombre (EN)</th>
                            <th>Precio</th>
                            <th>Ocultar</th>        
                            <th>Acc.</th>                                                                                                                                    
                            <th>Envio ID (Ocultar)</th>    
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>                    
	                <tfoot>
                        <tr>
                            <th>Nombre (ES)</th>
                            <th>Nombre (EN)</th>
                            <th></th>
                            <th></th>        
                            <th></th>                                                                                                                                    
                            <th>Envio ID (Ocultar)</th>                                                          
                        </tr>
                    </tfoot>                    
                </table>
            </div>
            <!-- Table End -->                  

    	</div>
	</body>
</html>