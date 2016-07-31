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
	} elseif ($width > 480 || $height > 360) {
		$_SESSION['file_error'] = "La taille de l'image est trop importante.<br />Les dimensions maximums sont 480x360.";
	} else {
		$contents = fread(fopen($file, 'r'), filesize($file));
		$_SESSION['img_up'] = 'data:image/'.$file_type.';base64,'.base64_encode($contents);
	}

?>