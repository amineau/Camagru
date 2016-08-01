<?php
	session_start();
	require('function.php');
	header("Location: ".adresse('index.php'));

	if (!isset($_FILES['file'], $_POST['upload'])) {
		exit;
	}
	if (empty($_FILES['file']['name'])) {
		$_SESSION['file_error'] = "Veuillez sélectionner un fichier image.";
		exit;
	}

	$file 		= $_FILES['file']['tmp_name'];
	$file_type 	= substr(strrchr($_FILES['file']['type'], '/'), 1);
	$taille		= getimagesize($file);
	$width		= $taille[0];
	$height		= $taille[1];

	if ($file_type != 'png' && $file_type != 'jpg' && $file_type != 'jpeg') {
		$_SESSION['file_error'] = "Le format du fichier est incorrect.<br />Les formats autorisés sont : .png, .jpg et .jpeg.";
	} elseif ($width > 1040 || $height > 1000) {
		$_SESSION['file_error'] = "La taille de l'image est trop importante.<br />Les dimensions maximums sont 1040x1000.";
	} else {
		$r_w = $width / 480;
		$r_h = $height / 360;
		if ($r_w > 1 || $r_h > 1) {
			if ($r_w > $r_h) {
				$new_width = $width / $r_w;
				$new_height = $height / $r_w;
			} else {
				$new_width = $width / $r_h;
				$new_height = $height / $r_h;
			}
			if ($file_type == 'png') {
				$image = imagecreatefrompng($file);
			} else {
				$image = imagecreatefromjpeg($file);
			}
			$new_img = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($new_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagedestroy($image);
			ob_start();
			if ($file_type == 'png') {
				imagepng($new_img);
			} else {
				imagejpeg($new_img);
			}
			$contents = ob_get_contents();
			ob_end_clean();
			imagedestroy($new_img);
		} else {
			$contents = fread(fopen($file, 'r'), filesize($file));
		}
		$_SESSION['img_up'] = 'data:image/'.$file_type.';base64,'.base64_encode($contents);
	}

?>