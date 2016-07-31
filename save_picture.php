<?php
	session_start();
	header("Content-Type: text/xml");
	require_once('function.php');
	if (!isset($_POST['data'], $_POST['calque'], $_SESSION['login']) || empty($_POST['data']) || empty($_POST['calque'])) {
		exit;
	}

	echo '<?xml version = "1.0" encoding="UTF-8"?>';

	$cam	= base64_decode($_POST['data']);
	$dest	= imagecreatefromstring($cam);
	$cho	= $_POST['calque'].".png";
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
	$img_to_save = base64_encode(ob_get_contents());
	ob_end_clean();
	imagedestroy($src);
	imagedestroy($dest);

	require('connec_db.php');
    
    try {
    	$db->beginTransaction();
	    $rep = $db->prepare('INSERT INTO picture(image, id_user, date_de_creation) VALUE(?, ?, ?);');
	    $rep->execute(array($img_to_save, $_SESSION['id_user'], date("Y-m-d H:i:s", time())));

	    $id = $db->lastInsertId();
	    $db->commit();


	    echo '<racine>';
		echo '<img>'.$img_to_save.'</img>';
		echo '<id>'.$id.'</id>';
		echo '</racine>';
	}
	catch(PDOException $e) {
		$db->rollBack();
		echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
	}

?>