<?php
	
	require_once('redir.php');
	if (!$_POST) {
		header("Location: ".adresse('index.php'));
		exit;
	}

	require ('connec_db.php');
	
	/************ Verification doublon ************/
		$doublon = "";
		$en_tete = array ('email', 'login');
		foreach ($en_tete as $value) {
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
		 		require('create_account.php');
		 		exit;
		 	}
		}
	/*********************************************/

	include ('includes/header.php');
	
	$code = md5(rand().'login');
		
	$req = $db->prepare("INSERT INTO user(login, date_de_creation, email, password, code)
 	    							VALUE(?, ?, ?, ?, ?);");
 	$req->execute(array(
			$_POST['login'],
 	 		date("Y-m-d H:i:s", time()),
 			$_POST['email'],
 			hash("whirlpool", $_POST['passwd']),
 			$code));
 	    
 	    /******** Envoi du mail ********/
 	    $to = $_POST['email'];
 	    
 	    $subject = "Validation de compte sur " . $website_name;
 	    
 	    $message = "Bonjour ";
 	    $message .= $_POST['login'].",\r\n\r\n";
 	    $message .= "Veuillez cliquer sur le lien suivant pour confirmer la création de votre compte :\r\n";
 	    $message .= adresse("validation.php?code=".$code);
 	    $message = wordwrap($message, 70, "\r\n");
 	    
 	    mail($to, $subject, $nessage);
 	    /******************************/
 	    
 	    echo $message."\n";
 	    echo "<p>Un email de confirmation vient de vous être envoyé sur votre boite mail " .$to. ".</br>Veuillez cliquer sur le lien de confirmation présent dans le mail pour valider votre inscription.</p>";
		
		include ('includes/footer.php'); ?>