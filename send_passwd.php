<?php 
	
	require_once('function.php');
	if (!isset($_POST['email'])) {
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
	 	    $to = $_POST['email'];
	 	    
	 	    $subject = "Nouveau mot de passe " . $website_name;
	 	    
	 	    $message = "Bonjour ";
	 	    $message .= $donnee['login'].",\r\n\r\n";
	 	    $message .= "Suite à votre demande, un nouveau mot de passe vous a été attribué.\r\n Mot de passe :";
	 	    $message .= $new_passwd;
	 	    $message = wordwrap($message, 70, "\r\n");
	 	    
	 	    mail($to, $subject, $message);
	 	    /******************************/
	 	    
		}
	} catch(PDOException $e) {
		$aff = 'Connexion échouée : ' . $e->getMessage() . '<br/>';
	}
	echo "<div>".$aff."</div>";

?>
	    	
		
	<?php include ('includes/footer.php'); ?>