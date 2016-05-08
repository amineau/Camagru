<?php
	session_start();
	function ft_check_login()
	{
		if(file_exists("htdocs/private/passwd")) {
			$tab = unserialize(file_get_contents("htdocs/private/passwd"));
			foreach ($tab as $value) {
				if ($value["login"] == $_POST["login"])
					return 0;
			}
		}
		return 1;
	}
	if ($_SESSION["loggued_on_user"])
		$my_account = "moncompte.php";
	else 
		$my_account = "#";

	if ($_POST["OK"] == "OK" && $_POST["login"] && $_POST["passwd"] && ($_POST["passwd"] == $_POST["confpasswd"]) && ft_check_login()) {
		$tab = ["login" => $_POST["login"], "passwd" => hash("whirlpool", $_POST["passwd"])];
		if (!file_exists("htdocs/private"))
			mkdir("htdocs/private");
		elseif (file_exists("htdocs/private/passwd"))
			$unse = unserialize(file_get_contents("htdocs/private/passwd"));
		$unse[] = $tab;
		file_put_contents("htdocs/private/passwd", serialize($unse));
		$_POST["create_account"] = "";
		$_POST["loggued_on_user"] = $_POST["login"];
	}
	elseif ($_POST["OK"] == "OK"){
		$_POST["create_account"] = 1;
		if (!$_POST["login"] || !$_POST["passwd"] || !$_POST["confpasswd"])
			$error = "Login or/and Password missing";
		elseif ($_POST["passwd"] != $_POST["confpasswd"])
			$error = "Password incorrect";
		elseif (!ft_check_login())
			$error = "Login already used";
			
	}

	if ($_POST["Annuler"])
		$_POST["create_account"] == "";
	
	if ($_POST["Deco"])
		$_SESSION["loggued_on_user"] = "";
	

?>