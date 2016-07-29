<?php
	session_start();
	header('Content-Type: text/plain');

	if (isset($_POST['action'], $_POST['id_pic'], $_SESSION['id_user'])) {
		require('connec_db.php');
		
		try {
			$db->beginTransaction();
			if ($_POST['action'] == 'like') {
				$rep = $db->prepare('INSERT INTO likes (id_user, id_pic) VALUES (?, ?);');
				$suf = " added";
			} else {
				$rep = $db->prepare('DELETE FROM likes WHERE id_user = ? AND id_pic = ?;');
				$suf = " deleted";
			}
		    $rep->execute(array($_SESSION['id_user'], $_POST['id_pic']));
		    $db->commit();
		    echo $_SESSION['id_user']." et ".$_POST['id_pic']. $suf;
		} catch(PDOException $e) {
			$db->rollBack();
			echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
		}
	} else {
		echo "Opération non autorisée";
	}


?>