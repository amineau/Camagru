<?php
	session_start();
	require_once('function.php');
	header("Location: ".adresse('index.php'));
	if (!isset($_POST['data']) || !isset($_SESSION['login'])) {
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
	} else {
		$dst_x = (imagesx($dest) - imagesx($src)) / 2;
		$dst_y = (imagesy($dest) - imagesy($src)) / 2;
	}

	imagecopy($dest, $src, $dst_x, $dst_y, 0, 0, $src_w, $src_h);
	ob_start();
	imagepng($dest);
	$img_to_save = ob_get_contents();
	ob_end_clean();
	imagedestroy($src);
	imagedestroy($dest);

	require('connec_db.php');
    
    try {
	    $rep = $db->prepare('SELECT id FROM user WHERE login = ?');
	    $rep->execute(array($_SESSION['login']));
	    $donnee = $rep->fetch();

	    $db->beginTransaction();
	    $rep = $db->prepare('INSERT INTO picture(image, id_user, date_de_creation) VALUE(?, ?, ?);');
	    $rep->execute(array(base64_encode($img_to_save), $donnee['id'], date("Y-m-d H:i:s", time())));
	    $db->commit();
	}
	catch(PDOException $e) {
		$db->rollBack();
		echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
	}

?>