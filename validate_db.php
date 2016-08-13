<?php
	session_start();
	require_once('function.php');
	if (!isset($_POST['hostName'], $_POST['dbName'], $_POST['user'], $_POST['passwd']) || file_exists("config/db_info")) {
		header("Location: ".adresse('create_db.php'));
		exit;
	}
	
	try {
		header("Location: ".adresse('config/setup.php'));
		$content = ["db_host" => $_POST['hostName'], "db_name" => $_POST['dbName'], "db_user" => $_POST['user'], "db_password" => $_POST['passwd']];
		$db = new PDO("mysql:host=".$content['db_host'], $content['db_user'], $content['db_password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

		if ($handle = fopen('config/db_info', 'w')) {
			fwrite($handle, serialize($content));
			fclose($handle);
		}
	} catch(PDOException $e) {
		$aff = 'Paramètre de connection invalide : ' . $e->getMessage();
		header("Location: ".adresse('create_db.php?error='.$aff));
	}
?>