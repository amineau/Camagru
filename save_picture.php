<?php
	session_start();

	require_once('function.php');

	header("Location: ".adresse('index.php'));

	if (!isset($_POST['data']) || !isset($_SESSION['login'])) {
		exit;
	}

	require('connec_db.php');
    
    try {
	    $rep = $db->prepare('SELECT id FROM user WHERE login = ?');
	    $rep->execute(array($_SESSION['login']));
	    $donnee = $rep->fetch();

	    $rep = $db->prepare('INSERT INTO picture(image, id_user, date_de_creation) VALUE(?, ?, ?);');
	    $rep->execute(array($_POST['data'], $donnee['id'], date("Y-m-d H:i:s", time())));
	}
	catch(PDOException $e) {
		echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
	}
	
?>