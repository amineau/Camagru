<?php

    
    ini_set('date.timezone', 'Europe/Paris');
 
 
/************** Connexion bdd ***************/  
    $IP             = getenv('IP');
    $DB_DSN         = "mysql:localhost;host=" . $IP;
    $DB_USER        = "root";
    $DB_PASSWORD    = "root";
/********************************************/

	
/************ Compte superadmin *************/
    $super_login      = "admin";
    $super_password   = hash("whirlpool", $super_login);
    $super_mail       = "amineau@student.42.fr";
/********************************************/
?>