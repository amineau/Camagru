<?php
    session_start();
    session_destroy();
?>

<html>
    <head>
        <title>Configuration bdd</title>
        <meta charset="utf-8" />
    </head>
</html>

<?php
    require('database.php');
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        if (strstr($e->getMessage(), "SQLSTATE[HY000] [1049] Unknown database")) {
            $db = new PDO("mysql:host=".$db_host, $DB_USER, $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $db->exec("CREATE DATABASE `$db_name`;
                        USE `$db_name`;");
        } else {
            echo 'Connexion échouée : ' . $e->getMessage();
            exit;
        }
    }
    try {
        $db->exec("DROP TABLES IF EXISTS user, picture, likes, comments;
                    CREATE TABLE user 
                        (id INT PRIMARY KEY AUTO_INCREMENT,
                        login VARCHAR(50) NOT NULL,
                        date_de_creation DATETIME NOT NULL,
                        email VARCHAR(255) NOT NULL,
                        password VARCHAR(255) NOT NULL,
                        code VARCHAR(32),
                        valid TINYINT(1) DEFAULT 0 NOT NULL,
                        admin TINYINT(1) DEFAULT 0 NOT NULL);
                    CREATE TABLE picture
                        (id INT PRIMARY KEY AUTO_INCREMENT,
                        image MEDIUMBLOB NOT NULL,
                        id_user INT(11) UNSIGNED NOT NULL,
                        date_de_creation DATETIME NOT NULL);
                    CREATE TABLE likes
                        (id INT PRIMARY KEY AUTO_INCREMENT,
                        id_user INT(11) UNSIGNED NOT NULL,
                        id_pic INT(11) UNSIGNED NOT NULL);
                    CREATE TABLE comments
                        (id INT PRIMARY KEY AUTO_INCREMENT,
                        id_user INT(11) UNSIGNED NOT NULL,
                        id_pic INT(11) UNSIGNED NOT NULL,
                        commentaire TEXT,
                        date_comment DATETIME NOT NULL);
                        "
                    );
        $req = $db->prepare("INSERT INTO user
                    (login,
                    date_de_creation,
                    email,
                    password,
                    valid,
                    admin)
 	    			VALUE(?, ?, ?, ?, 1, 1)");
 	    $req->execute(array(
 	    		$super_login,
 	    		date("Y-m-d H:i:s", time()),
 	    		$super_mail,
 	    		$super_password));
 	    echo 'La base de données a bien été réinitialisée';
    }
    catch(PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
    }


?>