<?php

    
    ini_set('date.timezone', 'Europe/Paris');
 
 
/************** Connexion bdd ***************/  
    $IP             = getenv('IP');
    $DB_DSN         = "mysql:localhost;host=" . $IP;
    $DB_USER        = getenv('C9_USER');
    $DB_PASSWORD    = "";
/********************************************/


/************ Compte superadmin *************/
    $login      = "admin";
    $password   = hash("whirlpool", $login);
    $mail       = "amineau@student.42.fr";
/********************************************/
?>