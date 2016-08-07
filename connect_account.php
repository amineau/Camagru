<?php
    session_start();
    require_once('function.php');
    header("Location: ".adresse('index.php'));
    $login  = $_POST['login'];
    $passwd = $_POST['passwd'];
    if (!isset($login, $passwd)) {
			exit;
	}
	require('connec_db.php');
    try {
        $rep = $db->prepare('SELECT id, login, password, valid FROM user WHERE login = ? AND password = ?;');
        $rep->execute(array($login, hash("whirlpool", $passwd)));
        $donnee = $rep->fetch();
        if ($donnee['login']) {
            if ($donnee['valid']) {
                $_SESSION['login'] = $donnee['login'];
                $_SESSION['id_user'] = $donnee['id'];
            }
            else {
                $_SESSION['ret_connect'] = "Vous n'avez pas validé votre compte";
            }
        } else {
            $_SESSION['ret_connect'] = "login ou mot de passe incorect";
        }
    } catch(PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
    }
    
?>
