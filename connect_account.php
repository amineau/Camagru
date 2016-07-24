<?php
    session_start();
    require_once('redir.php');
    
    if (!$_POST) {
		
			header("Location: ".adresse('index.php'));
			exit;
	}
	
	require('connec_db.php');
    
    $rep = $db->prepare('SELECT login, password, valid FROM user WHERE login = ? AND password = ?;');
    $rep->execute(array($_POST['login'], hash("whirlpool", $_POST['passwd'])));
    $donnee = $rep->fetch();
    if ($donnee['login']) {
        if ($donnee['valid']) {
            $_SESSION['login'] = $donnee['login'];
            $ret_connect = "Connexion réussi";
        }
        else {
            $ret_connect = "Vous n'avez pas validé votre compte";
        }
    }
    else {
        $ret_connect = "login ou mot de passe incorect";
    }
    require('index.php');
    exit;
    
?>