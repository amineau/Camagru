<?php
	header("Content-Type: text/plain");

	$comment 	= $_POST['text'];
	$name		= $_POST['name'];
	$date		= $_POST['date'];
	$id_pic		= $_POST['id_pic'];
	if (!isset($comment, $name, $date, $id_pic)) {
		require_once('function.php');
		header("Location: ".adresse('index.php'));
		exit;
	}

	require('connec_db.php');
	try {	
		$res = $db->prepare('SELECT id_user FROM picture WHERE id = ?;');
		$res->execute(array($id_pic));
		$retour = $res->fetch();

		$res = $db->prepare('SELECT login, email FROM user WHERE id = ?;');
		$res->execute(array($retour['id_user']));
		$donnees = $res->fetch();

		/******** Envoi du mail ********/
		require("function.php");
		$website = "Instagru";

 	    $subject = $website." : Vous avez un nouveau commentaire";

 	    $message = "<html><body><p><strong>Bonjour ".htmlentities($donnees['login']).", vous avez reçu un nouveau commentaire sur l'une de vos photos</strong></p>";
 	    $message .= "<p>".htmlentities($name)." a écrit :";
 	    $message .= "<br />".htmlentities($comment)."</p>";
 	    $message .= "<br />Vous pouvez retouver ce commentaire sur ce ";
 	    $message .= "<a href=\"".adresse("image.php?id_pic=".$id_pic)."\" style=\"font-style: bold; text-decoration: none\">lien</a>.</p>";
 	    $message .= "<p>Nous sommes heureux de vous compter parmis nous,<br />L'équipe ".$website;
 	    $message .= "</p></body></html>";

    	send_mail($donnees['email'], $subject, $message, $website);
 	    /******************************/
 	    echo "Mail send";
 	} catch(PDOException $e) {
		echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
	}

 ?>