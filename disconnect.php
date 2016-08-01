<?php
    session_start();
    session_destroy();
    require_once('function.php');
	header('Location: '.adresse('index.php'));
	exit;
?>