<?php
	$MM_authorizedUsers = "admin";
?>
<?php require_once('inc/security-ajax.php'); ?>
<?php 
	// Extend execution time
	set_time_limit(180);
?>
<?php
	// Require connection
	require_once('Connections/connection.php');
?>
<?php

	// GENERATE MAIN QUERY (WITHOUT SELECT STATEMENT)
	$query_Recordset1_fields = " mailing_email, mailing.mailing_id";
	$query_Recordset1_tables = " FROM mailing";
	$query_Recordset1_where = " WHERE 1";

?>
<?php

	// DETERMINE PAGE ACTION
	if (isset($_GET['action']) && $_GET['action']!="") {
		$action = $_GET['action'];
	} else {
		$action = "none";		
	}

	switch ($action) {

		// --------------------------------------- VIEW RESULTS ----------------------------------------------
		case "view":

			// COMBINE MAIN QUERY (WITHOUT SELECT STATEMENT)
			$query_Recordset1_base = $query_Recordset1_fields . $query_Recordset1_tables . $query_Recordset1_where;	
	
			/* Array of database columns which should be read and sent back to DataTables */
			$aColumns = array('mailing_email', ' ', 'mailing_id');
	
			/* Indexed column (used for fast and accurate table cardinality) */
			$sIndexColumn = "mailing.mailing_id";		
			
			/* Paging */
			$sLimit = "";
			if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength']!='-1'){
				$sLimit = "LIMIT " . mysql_real_escape_string($_GET['iDisplayStart']) . ", " . mysql_real_escape_string($_GET['iDisplayLength']);
			}
	
			/* Ordering */
			if (isset($_GET['iSortCol_0'])){
				$sOrder = "ORDER BY  ";
				for ($i=0; $i<intval($_GET['iSortingCols']); $i++){
					if ($_GET['bSortable_'.intval($_GET['iSortCol_'.$i])] == "true"){
						$sOrder .= $aColumns[intval($_GET['iSortCol_'.$i])] . " " . mysql_real_escape_string($_GET['sSortDir_'.$i]) . ", ";
					}
				}
				$sOrder = substr_replace($sOrder, "", -2);
				if ($sOrder == "ORDER BY"){
					$sOrder = "";
				}
			}
				
			/* Global Filtering */
			$sWhere = "";
			if (isset($_GET['sSearch']) && $_GET['sSearch']!= "") {
				$sWhere = "AND (";
				for ($i=0; $i<count($aColumns); $i++) {
					if ($aColumns[$i]!=' ') {
						if (isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true") {
							$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
						}
					}
				}
				$sWhere = substr_replace($sWhere, "", -3);
				$sWhere .= ')';
			}

			/* Individual column filtering */
			for ($i=0; $i<count($aColumns); $i++) {
				if (isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '') {
					$sWhere .= " AND ".$aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
				}
			}			
		
			/* SQL queries: Get data to display */			
			$query_Recordset1_final = "SELECT SQL_CALC_FOUND_ROWS" . $query_Recordset1_base . " $sWhere $sOrder $sLimit";
			$Recordset1 = mysql_query($query_Recordset1_final, $connection) or die("Database error.");	
		
			/* Data set length after filtering */
			$query_Recordset1_final = "SELECT FOUND_ROWS()";
			$rResultFilterTotal = mysql_query($query_Recordset1_final, $connection) or die("Database error.");
			$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
			mysql_free_result($rResultFilterTotal);					
			$iFilteredTotal = $aResultFilterTotal[0];	
			
			/* Total data set length */
			$query_Recordset1_final = "SELECT COUNT(".$sIndexColumn.")," . $query_Recordset1_base;
			$rResultTotal = mysql_query($query_Recordset1_final, $connection) or die("Database error.");
			$aResultTotal = mysql_fetch_array($rResultTotal);
			mysql_free_result($rResultTotal);							
			$iTotal = $aResultTotal[0];
			
			/* Output */		
			$output = array(
				"sEcho" => intval($_GET['sEcho']),
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
			);
			while ($aRow = mysql_fetch_array($Recordset1)) {
				$row = array();
				for ($i=0; $i<count($aColumns); $i++) {
					/* General output */
					switch ($aColumns[$i]) {
						case ' ':
							$row[] = ' ';						
							break;
						default:
							$row[] = strip_tags($aRow[ $aColumns[$i] ]);						
							break;
					}
				}
				$output['aaData'][] = $row;
			}
			mysql_free_result($Recordset1);		
			echo json_encode( $output );
			
			break;
			
		// ------------------------------------- EXPORT RESULTS --------------------------------------------
		case "export":
		
			// COMBINE MAIN QUERY
			$query_Recordset1_final = "SELECT" . $query_Recordset1_fields . $query_Recordset1_tables . $query_Recordset1_where;			
								
			// CREATE RECORDSET		
			$Recordset1 = mysql_query($query_Recordset1_final, $connection) or die("Database error.");
			$totalFields_Recordset1 = mysql_num_fields($Recordset1);
			
			// PHPExcel required class and object initialization
			require_once('Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$worksheet = $objPHPExcel->getActiveSheet();			
			
			// Header vars
			$header_col_start = "A";
			$header_row_start = 1;		
	
			// Add headers from DB
			for ($col=0; $col<$totalFields_Recordset1; $col++) {
				$fieldname = strtoupper(str_replace("_"," ",mysql_field_name($Recordset1,$col)));
				$worksheet->setCellValueByColumnAndRow($col, $header_row_start, $fieldname);
			}
	
			// Count columns
			$header_col_high = $worksheet->getHighestColumn();		
					
			// Format headers
			$header_start = $header_col_start.$header_row_start;
			$header_end = $header_col_high.$header_row_start;
			$fill = array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'CCCCCC'));	
					
			$worksheet->getStyle($header_start.":".$header_end)->getFill()->applyFromArray($fill);					
			$worksheet->getStyle($header_start.":".$header_end)->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_WHITE));
			$worksheet->getStyle($header_start.":".$header_end)->getFont()->setBold(true);	
	
			// Set column sizes
			for ($col=$header_col_start; $col <= $header_col_high; $col++){
				$worksheet->getColumnDimension($col)->setAutoSize(true);			
			}
									
			// Add cell data
			$cell_col_number = 0;
			$cell_row_number = $header_row_start + 1;
			
			while($row_Recordset1 = mysql_fetch_assoc($Recordset1)) {
				
				// Add data from DB
				foreach($row_Recordset1 as $key=>$value) {
					$worksheet->setCellValueExplicitByColumnAndRow($cell_col_number, $cell_row_number, strip_tags($value), PHPExcel_Cell_DataType::TYPE_STRING);				
					$cell_col_number++;
				}
								
				// Increment/reset counters
				$cell_row_number++;
				$cell_col_number = 0;	
					
			}
			
			// Free Recordsets
			mysql_free_result($Recordset1);		
		
			// Redirect output to a client's web browser (Excel5)
			date_default_timezone_set('America/Argentina/Buenos_Aires');		
			$file_date = date('Y_m_d-H.i');
			$section_array = explode("-", $_SERVER['PHP_SELF']);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename='.$section_array[1].'-'.$file_date.'.xls');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');

			break;	
			
	} // End switch	
	
?>