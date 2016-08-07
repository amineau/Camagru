<?php 
	session_start();
	if (!isset($_POST['email'])) {
		require_once('function.php');
		header("Location: ".adresse('index.php'));
		exit;
	}
    include ('includes/header.php');
    require ('connec_db.php');
	try {
		$req = $db->prepare("SELECT login FROM user WHERE email = ?;");
		$req->execute(array($_POST['email']));

		if (!($donnee = $req->fetch())) {
		    $aff = "L'email est invalide.";
		} else {
		    $new_passwd = generate_pass();
		    $aff = "Un nouveau mot de passe vient de vous être envoyé par email.";
		    
		    try {
		    	$db->beginTransaction();
			    $req = $db->prepare("UPDATE user SET password = ? WHERE login = ?;");
			    $req->execute(array(hash("whirlpool", $new_passwd), $donnee['login']));
			    $db->commit();
		    } catch(PDOException $e) {
				$db->rollBack();
				$aff = 'Connexion échouée : ' . $e->getMessage() . '<br/>';
			}

	 	    /******** Envoi du mail ********/
	 	    $website = "Instagru";
	 	    $subject = $website." : Nouveau mot de passe";

	 	    $message = "<html><body><p><strong>Bonjour ".htmlentities($donnee['login']).",</strong></p>";
	 	    $message .= "<p>Suite à votre demande, un nouveau mot de passe vous a été attribué.<br />";
	 	    $message .= "Nouveau mot de passe : ".$new_passwd."</p>";
	 	    $message .= "<p>Nous sommes heureux de vous compter parmis nous,<br />L'équipe ".$website;
	 	    $message .= "</p></body></html>";

	    	send_mail($_POST['email'], $subject, $message, $website);
 	    	/******************************/
	 	    
		}
	} catch(PDOException $e) {
		$aff = 'Connexion échouée : ' . $e->getMessage() . '<br/>';
	}
	echo "<div>".$aff."</div>";

?>
	    	
		
	<?php include ('includes/footer.php'); ?>