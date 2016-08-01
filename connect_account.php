<?php
    session_start();
    require_once('function.php');
    
    $login  = $_POST['login'];
    $passwd = $_POST['passwd'];
    $ret_connect = "";
    if (!isset($login, $passwd)) {	
			header("Location: ".adresse('index.php'));
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
                $ret_connect = "Vous n'avez pas validé votre compte";
            }
        } else {
            $ret_connect = "login ou mot de passe incorect";
        }
    } catch(PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
    }
    if ($ret_connect != "") {
        $ret_connect = "?ret_connect=".$ret_connect;
    } 
    header("Location: ".adresse('index.php'.$ret_connect));
    exit;
    
?>