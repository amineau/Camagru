<?php 
	
	require_once('function.php');
	if (!$_POST) {
		header("Location: ".adresse('index.php'));
		exit;
	}
    include ('includes/header.php');
    require ('connec_db.php');
	
	$req = $db->prepare("SELECT password FROM user WHERE login = ?;");
	$req->execute(array($_SESSION['login']));
	$donnee = $req->fetch();
	if ($donnee['password'] != hash('whirlpool', $_POST['old_passwd'])) {
	    $aff = "Le mot de passe est invalide.";
	}
	else {
	    $req = $db->prepare("UPDATE user SET password = ? WHERE login = ?;");
	    $req->execute(array(hash("whirlpool", $_POST['new_passwd']), $_SESSION['login']));
	    $aff = "La modification a bien été enregistré";
	}

	echo "<div>".$aff."</div>";

?>
	    	
		
	<?php include ('includes/footer.php'); ?>