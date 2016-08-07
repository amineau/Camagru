<?php

 	date_default_timezone_set('Europe/Paris');
 
 	$db_host = "localhost";
 	$db_name = "camagru";

/************** Connexion bdd ***************/  
    $DB_DSN         = "mysql:host=".$db_host.";dbname=".$db_name;
    $DB_USER        = "root";
    $DB_PASSWORD    = "root";
/********************************************/

	
/************ Compte superadmin *************/
    $super_login      = "admin";
    $super_password   = hash("whirlpool", $super_login);
    $super_mail       = "amineau@student.42.fr";
/********************************************/
?>