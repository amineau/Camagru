<?php

    require('database.php');
    include('../head.php');
    

    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec("DROP DATABASE IF EXISTS camagru;
                    CREATE DATABASE camagru;
                    USE camagru;
                    CREATE TABLE IF NOT EXISTS user 
                        (id INT PRIMARY KEY AUTO_INCREMENT,
                        login VARCHAR(50) NOT NULL,
                        date_de_creation DATETIME NOT NULL,
                        email VARCHAR(255) NOT NULL,
                        password VARCHAR(255) NOT NULL,
                        code VARCHAR(32),
                        valid TINYINT(1) DEFAULT 0 NOT NULL,
                        admin TINYINT(1) DEFAULT 0 NOT NULL);"
                    );
        $req = $db->prepare("INSERT INTO user(login, date_de_creation, email, password, valid, admin)
 	    							VALUE(?, ?, ?, ?, 1, 1)");
 	    $req->execute(array(
 	    		$login,
 	    		date("Y-m-d H:i:s", time()),
 	    		$mail,
 	    		$password));
 	    echo 'La base de données a bien été réinitialisée';
    }
    catch(PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
    }


?>