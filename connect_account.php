<?php
    session_start();
    require_once('function.php');
    
    $login  = $_POST['login'];
    $passwd = $_POST['passwd'];

    if (!isset($login, $passwd)) {	
			header("Location: ".adresse('index.php'));
			exit;
	}
	print_r($_POST);
    echo "<br />".$login."<br />";
	require('connec_db.php');
    try {
        $rep = $db->prepare('SELECT id, login, password, valid FROM user WHERE login = ? AND password = ?;');
        $rep->execute(array($login, hash("whirlpool", $passwd)));
        $donnee = $rep->fetch();
        print_r($donnee);
        if ($donnee['login']) {
            if ($donnee['valid']) {
                $_SESSION['login'] = $donnee['login'];
                $_SESSION['id_user'] = $donnee['id'];
                $ret_connect = "Connexion réussi";
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
    header("Location: ".adresse('index.php?ret_connect='.$ret_connect));
    exit;
    
?>