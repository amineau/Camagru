<?php

	if (!isset($_POST['data']) || !isset($_SESSION['login'])
			{
				require_once('function.php');
				header("Location: ".adresse('index.php'));
				exit;
			}
	

	require('index.php');
	exit;
?>