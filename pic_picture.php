<?php

	if (!isset($_POST['data']))
			{
				require_once('function.php');
				header("Location: ".adresse('index.php'));
				exit;
			}
	$cam	= base64_decode($_POST['data']);
	$cho	= $_POST['calque'].".png";
	$dest	= imagecreatefromstring($cam);
	$src	= imagecreatefrompng('img/calque/'.$cho);

	$src_w = imagesx($src);
	$src_h = imagesy($src);

	if ($cho == "Niel.png") {
		$dst_x = 0;
		$dst_y = imagesy($dest) - imagesy($src) + 10;
	} elseif ($cho == "casque.png") {
		$dst_x = (imagesx($dest) - imagesx($src)) / 2;
		$dst_y = (imagesy($dest) - imagesy($src)) / 4;
	} elseif ($cho == "croix.png") {
		$dst_x = (imagesx($dest) - imagesx($src)) / 2;
		$dst_y = (imagesy($dest) - imagesy($src)) / 2;
	} elseif ($cho == "poule.png") {
		$dst_x = imagesx($dest) - imagesx($src) + 30;
		$dst_y = (imagesy($dest) - imagesy($src)) / 2;
	} elseif ($cho == "serpent.png") {
		$dst_x = 0;
		$dst_y = imagesy($dest) - imagesy($src);
	}

	imagecopy($dest, $src, $dst_x, $dst_y, 0, 0, $src_w, $src_h);
	
	ob_start();
	imagepng($dest);
	$previsual = ob_get_contents();
	ob_end_clean();
	
	
	imagedestroy($src);
	imagedestroy($dest);

	require('index.php');
	exit;
?>