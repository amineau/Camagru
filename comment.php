<?php
	session_start();
	header("Content-Type: text/xml");


	$name = $_SESSION['login'];
	$comment = $_POST['text'];
	$date = date("Y-m-d H:i:s", time());
	if (!isset($comment, $_POST['id_pic'], $name)) {
		exit;
	}
	echo '<?xml version = "1.0" encoding="UTF-8"?>';
	
	require('connec_db.php');
	try {	
		$db->beginTransaction();
		$res = $db->prepare('INSERT INTO comments (id_user, id_pic, commentaire, date_comment) VALUES (?, ?, ?, ?);');
		$res->execute(array($_SESSION['id_user'], $_POST['id_pic'], $comment, $date));
		$db->commit();

		echo '<racine>';
		echo '<name>'.$name.'</name>';
		echo '<date>'.$date.'</date>';
		echo '<comment>'.$comment.'</comment>';
		echo '</racine>';
	} catch(PDOException $e) {
		$db->rollBack();
		echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
	}
?>