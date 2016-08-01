<?php
	
	
	require_once('function.php');
	if (!isset($_POST['login'], $_POST['passwd'], $_POST['email'])) {
		header("Location: ".adresse('index.php'));
		exit;
	}

	require ('connec_db.php');
	
	/************ Verification doublon ************/
		$doublon = "";
		$en_tete = array ('email', 'login');
		foreach ($en_tete as $value) {
			try {
				$req = $db->prepare("SELECT * FROM user WHERE ".$value." = ?;");
			 	$req->execute(array($_POST[$value]));
			 	if ($req->fetch()){
			 		if ($value == 'email') {
			 			$doublon = 'L\'';
			 		}
			 		else {
			 			$doublon = 'Le ';
			 		}
			 		$doublon .= $value;
			 		$doublon .= " est déjà utilisé.";
			 		header("Location: ".adresse('create_account.php?doublon='.$doublon));
			 		exit;
			 	} elseif (strlen($_POST['login']) > 50) {
			 		header("Location: ".adresse('create_account.php?doublon=Le login a une taille supérieur à 50 caractères.'));
			 		exit;
			 	}

		 	} catch(PDOException $e) {;
				echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
		 	}
		}
	/*********************************************/
include ('includes/header.php');
	
	$code = md5(rand().'login');
	try {	
		$db->beginTransaction();
		$req = $db->prepare("INSERT INTO user(login, date_de_creation, email, password, code)
	 	    							VALUE(?, ?, ?, ?, ?);");
	 	$req->execute(array(
				$_POST['login'],
	 	 		date("Y-m-d H:i:s", time()),
	 			$_POST['email'],
	 			hash("whirlpool", $_POST['passwd']),
	 			$code));
 	    /******** Envoi du mail ********/

 	    $subject = $website_name." : Veuillez confirmer votre adresse électronique";

 	    $message = "<html><body><p><strong>Vous y êtes presque</strong></p>";
 	    $message .= "<p>Bienvenue dans ".$website_name.", ".htmlentities($_POST['login']);
 	    $message .= ".<br />Cliquez sur le lien ci-dessous puis connectez vous avec votre login : ";
 	    $message .= htmlentities($_POST['login']).".<br />";
 	    $message .= "<a href=\"".adresse("validation.php?code=".$code)."\" style=\"font-style: bold; text-decoration: none\">Confirmez votre adresse électronique</a></p>";
 	    $message .= "<p>Nous sommes heureux de vous compter parmis nous,<br />L'équipe ".$website_name;
 	    $message .= "</p></body></html>";

    	send_mail($_POST['email'], $subject, $message, $website_name);
 	    /******************************/
 	    
 	    echo "<section class='fond sect'><p>Un email de confirmation vient de vous être envoyé sur votre boite mail " .$_POST['email']. ".</br>Veuillez cliquer sur le lien de confirmation présent dans le mail pour valider votre inscription.</p></section>";
 	    $db->commit();
 	} catch(PDOException $e) {
		$db->rollBack();
		echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
	}
		
		include ('includes/footer.php'); ?>