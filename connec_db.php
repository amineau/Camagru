<?php

		require ('config/database.php');
			
			try {
				$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}
			catch(PDOException $e) {
				echo 'Connexion échouée : ' . $e->getMessage() . '<br/>';
			}

?>