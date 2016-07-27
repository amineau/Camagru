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

		function send_mail($to, $subject, $body, $website_name)
		{
			if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
			$eol="\r\n"; 
			} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
				$eol="\r"; 
			} else { 
				$eol="\n";
			}

			$boundary = "-----=".md5(rand());
			$header = "From: \"".$website_name."\"<ant.mineau@gmail.com>".$eol;
			$header .= "Reply-to: \"".$website_name."\"<ant.mineau@gmail.com>".$eol;
			$header .= "MIME-Version: 1.0".$eol;
			$header .= "Content-Type: multipart/related; charset=iso-8859-1; boundary=\"".$boundary."\"".$eol;
			$header .= "Content-Transfer-Encoding: 8bit".$eol; 

	 	    $message = $eol."--".$boundary.$eol;
	 	    $message .= "Content-Type: text/html; charset=iso-8859-1".$eol;
			$message .= "Content-Transfer-Encoding: 8bit".$eol;
			$message .= $eol.$body.$eol;
			$message .= $eol."--".$boundary."--".$eol.$eol;
	 	    
	    	mail($to, utf8_decode($subject), utf8_decode($message), $header);
		}
		
?>