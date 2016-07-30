	function ft_like(oARef) {
		var xhr 	= getXMLHttpRequest();
		var liOrDis	= oARef.id;
		var idPic	= document.getElementById('id_pic').value;

		if (liOrDis == 'like') {
			document.getElementById('dislike').style.visibility = "visible";
		} else {
			oARef.style.visibility = "hidden";
		}
		xhr.open("POST", "like.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("action="+liOrDis+"&id_pic="+idPic);
	}



	function ft_comment(){
		var comment	= encodeURIComponent(document.getElementById('comment').value);
		if (comment == ""){return;}
		var xhr 	= getXMLHttpRequest();
		var idPic	= document.getElementById('id_pic').value;

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				readData(xhr.responseXML);
			}
		};

		xhr.open("POST", "comment.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("text="+comment+"&id_pic="+idPic);
	}

	function readData(sData) {
		var listCom	= document.getElementById('comments'),
			comment	= sData.getElementsByTagName("comment")[0].textContent,
			name	= sData.getElementsByTagName("name")[0].textContent,
			date	= sData.getElementsByTagName("date")[0].textContent;
			idPic	= sData.getElementsByTagName("id")[0].textContent;
			xhr 	= getXMLHttpRequest();
		createComment(name, date, comment);
			
		document.getElementById('comment').value = "";

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				returnMail(xhr.responseText);
			}
		};

		xhr.open("POST", "comment_send_mail.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("text="+comment+"&name="+name+"&date="+date+"&id_pic="+idPic);
	}

	function createComment(name, date, comment) {
		var listCom	= document.getElementById('comments');
			div		= document.createElement("div"),
			p		= {};

			for(i=0; i<3;i++){
				p[i] = document.createElement("p");
			}

			p[0].appendChild(document.createTextNode(name));
			p[1].appendChild(document.createTextNode(comment));
			p[2].appendChild(document.createTextNode('Il y a '+diffTime(date)));
			
			for(i=0; i<3;i++){
				div.appendChild(p[i]);
			}

			listCom.appendChild(div);
	}

	function diffTime(oldDate) {
		var now = new Date();
		var old = new Date(oldDate);
		var tmp = now - old;
		var dif = {
			'an': '',
			'mois': '',
			'jour': '',
			'heure': '',
			'minute': '',
			'sec': ''
		};

		tmp = mp = Math.floor(tmp/1000);            
		dif.sec = tmp % 60;					
		tmp = Math.floor((tmp-dif.sec)/60);	
		dif.minute = tmp % 60;				
		tmp = Math.floor((tmp-dif.minute)/60);
		dif.heure = tmp % 24;
		tmp = Math.floor((tmp-dif.heure)/24);
		dif.jour = tmp % 30;
		tmp = Math.floor((tmp-dif.jour)/30);
		dif.mois = tmp % 365; 
		tmp = Math.floor((tmp-dif.mois)/365);
		dif.an = tmp;

		for (var type in dif) {
			if (type == "sec") {
					return " quelques secondes";
				}
			if (dif[type]) {
				if (dif[type] > 1 && type != "mois") {
					return dif[type] + " " + type + "s";
				}
				return dif[type] + " " + type;
			}
		}
	}