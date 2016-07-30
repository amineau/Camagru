<?php
	session_start();
	header("Content-Type: text/xml");


	$name 		= $_SESSION['login'];
	$comment 	= $_POST['text'];
	$date 		= date("Y-m-d H:i:s", time());
	$id_pic		= $_POST['id_pic'];
	if (!isset($comment, $id_pic, $name)) {
		exit;
	}
	echo '<?xml version = "1.0" encoding="UTF-8"?>';
	
	require('connec_db.php');
	try {	
		$db->beginTransaction();
		$res = $db->prepare('INSERT INTO comments (id_user, id_pic, commentaire, date_comment) VALUES (?, ?, ?, ?);');
		$res->execute(array($_SESSION['id_user'], $id_pic, $comment, $date));

		$db->commit();

		echo '<racine>';
		echo '<name>'.$name.'</name>';
		echo '<date>'.$date.'</date>';
		echo '<comment>'.$comment.'</comment>';
		echo '<id>'.$id_pic.'</id>';
		echo '</racine>';

	} catch(PDOException $e) {
		$db->rollBack();
		echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
	}
?>