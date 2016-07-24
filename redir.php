<?php

		function adresse($extra)
		{
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			return("http://$host$uri/$extra");
		}
		
		function generate_pass()
		{
			$chaine = "abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789";
			$length = strlen($chaine);
			$pwd = "";
			for($i = 0; $i < 6; $i++) {
				switch ($i) {
					case 0:
						$min = 0;
						$max = $length - 11;
						break;
					case 1;
						$min = $length - 10;
						$max = $length - 1;
						break;
					default:
						$min = 0;
						$max = $length - 1;
						break;
				}
				$char = $chaine[mt_rand($min, $max)];
				$pwd .= $char;
			}
			return ($pwd);
		}
		
?>