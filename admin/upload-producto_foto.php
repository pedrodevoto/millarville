<?php
	$MM_authorizedUsers = "admin";
?>
<?php require_once('inc/security-html.php'); ?>
<?php
	// Require connection
	require_once('Connections/connection.php');
	// Require DB functions
	require_once('inc/db_functions.php');	
?>
<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
ini_set('memory_limit', -1);
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        case 'g':
            $val *= 1024 * 1024 * 1024;
        case 'm':
            $val *= 1024 * 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}
if ($_FILES["box-producto_foto"]["error"] == 0 and isset($_POST['fotos-producto_id'])){
	if ($_FILES["box-producto_foto"]["size"] > return_bytes(ini_get('upload_max_filesize'))) {
		die("Error: no se puede subir archivos de más de ".ini_get('upload_max_filesize')." de tamaño.");
	}
	$extension = strtolower(strrchr($_FILES["box-producto_foto"]["name"], '.'));
	if (!in_array($extension, array(".jpg", ".jpeg", ".png"))) {
		die("Error: subir solamente fotos con extensión .jpg, .jpeg o .png");
	}
	$path = "prod_img/";
	$filename =  md5($_POST['fotos-producto_id'] . time());
	if (move_uploaded_file($_FILES["box-producto_foto"]["tmp_name"], '../'.$path . $filename . $extension )) {
		switch($extension)
		{
			case '.jpg':
			case '.jpeg':
				$image = @imagecreatefromjpeg('../'.$path.$filename.$extension);
				break;
			case '.png':
				$image = @imagecreatefrompng('../'.$path.$filename.$extension);
				break;
			default:
				$image = false;
				break;
		}
		
		if (!$image) {
			die('Error: no se pudo generar vista preliminar.');
		}
		
		$resizes = array(
			'front_mini' => array(
					'width'=> 48,
					'height'=> 48,
					'filename'=> $filename . '-thumb_front_mini.png'
			),
			'front' => array(
					'width'=> 480,
					'height'=> 360,
					'filename'=> $filename . '-thumb_front.png'
			),
			'back' => array(
					'width'=> 100,
					'height'=> 100,
					'filename'=> $filename . '-thumb_back.png'
			),
			'home' => array(
					'width'=> 350,
					'height'=> 188,
					'filename'=> $filename . '-home.png'
			)
		);
		
		$width = imagesx($image);
		$height = imagesy($image);
		
		foreach ($resizes as $resize) {
			$thumb_width = $resize['width'];
			$thumb_height = $resize['height'];
			$thumb_filename = '../'.$path.$resize['filename'];
			error_log(sprintf("thumb_width %s, thumb_height %s, thumb_filename %s", $thumb_width, $thumb_height, $thumb_filename));
			
			$original_aspect = $width / $height;
			$thumb_aspect = $thumb_width / $thumb_height;

			if ( $original_aspect <= $thumb_aspect )
			{
			   $new_height = $thumb_height;
			   $new_width = $width / ($height / $thumb_height);
			}
			else
			{
			   $new_width = $thumb_width;
			   $new_height = $height / ($width / $thumb_width);
			}

			$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
			imagealphablending($thumb, false);
			imagesavealpha($thumb, true);
			
			$trans_layer_overlay = imagecolorallocatealpha($image, 220, 220, 220, 127);
			imagefill($thumb, 0, 0, $trans_layer_overlay);
			
			// Resize and crop
			imagecopyresampled($thumb,
			                   $image,
			                   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
			                   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
			                   0, 0,
			                   $new_width, $new_height,
			                   $width, $height);
			if (!imagepng($thumb, $thumb_filename, 0)) {
				die("Error: no se pudo generar la vista preliminar. Intente nuevamente.");
			}
		}
		
		$insertSQL = sprintf("INSERT INTO producto_foto (producto_id, producto_foto_url, producto_foto_thumb_front_url, producto_foto_thumb_front_mini_url, producto_foto_thumb_back_url, producto_foto_home_url, producto_foto_width, producto_foto_height) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
						GetSQLValueString($_POST['fotos-producto_id'], "int"),
						GetSQLValueString($filename.$extension, "text"),
						GetSQLValueString($resizes['front']['filename'], "text"),
						GetSQLValueString($resizes['front_mini']['filename'], "text"),
						GetSQLValueString($resizes['back']['filename'], "text"),
						GetSQLValueString($resizes['home']['filename'], "text"),
						GetSQLValueString($width, "int"),
						GetSQLValueString($height, "int"));								
		$Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());
		echo "ok";	
	}
}
