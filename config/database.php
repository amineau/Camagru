<?php

 	date_default_timezone_set('Europe/Paris');
 
/************** Connexion bdd ***************/
	$file = "db_info";
	if (!file_exists($file)) {
		$file = "config/".$file;
}
 	if (($handle = fopen($file, 'r'))) {
 		$contents 		= unserialize(fread($handle, filesize($file)));
 		$db_host 		= $contents['db_host'];
 		$db_name 		= $contents['db_name'];

 		$DB_DSN         = "mysql:host=".$db_host.";dbname=".$db_name;
 		$DB_USER        = $contents['db_user'];
    	$DB_PASSWORD    = $contents['db_password'];
 		
 		fclose($handle);
 	}
/********************************************/

	
/************ Compte superadmin *************/
    $super_login      = "admin";
    $super_password   = hash("whirlpool", $super_login);
    $super_mail       = "amineau@student.42.fr";
/********************************************/
?>