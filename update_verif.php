<?php 
	
	require_once('function.php');
	if (!isset($_POST['old_passwd'], $_POST['new_passwd'])) {
		header("Location: ".adresse('index.php'));
		exit;
	}
    include ('includes/header.php');
    require ('connec_db.php');
	
	try {
		$req = $db->prepare("SELECT password FROM user WHERE login = ?;");
		$req->execute(array($_SESSION['login']));
		$donnee = $req->fetch();
		if ($donnee['password'] != hash('whirlpool', $_POST['old_passwd'])) {
		    $aff = "Le mot de passe est invalide.";
		}
		else {
			try {
				$db->beginTransaction();
			    $req = $db->prepare("UPDATE user SET password = ? WHERE login = ?;");
			    $req->execute(array(hash("whirlpool", $_POST['new_passwd']), $_SESSION['login']));
			    $db->commit();
			    $aff = "La modification a bien été enregistré";
			} catch(PDOException $e) {
				$db->rollBack();
				$aff = 'Connexion échouée : ' . $e->getMessage() . '<br/>';			}
		}
	} catch(PDOException $e) {
		$aff = 'Connexion échouée : ' . $e->getMessage() . '<br/>';
	}

	echo "<div>".$aff."</div>";

?>
	    	
		
	<?php include ('includes/footer.php'); ?>