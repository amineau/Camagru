(function() {

	var streaming = false,
		video   = document.querySelector('#video'),
		cover   = document.querySelector('#cover'),
		canvas  = document.querySelector('#canvas'),
		photo   = document.querySelector('#photo'),
		superpo = document.querySelector('#superpos'),
		fichier = superpos.firstChild,
		hidde	= document.getElementById('hid_calque'),
		button	= document.getElementById('button'),
		child	= calque.firstElementChild,
		cover	= document.createElement("IMG"),
		handler = function(ev){
					takepicture();
					savePicture();
					ev.preventDefault();
				},
		width   = 480,
		height  = 0;

	if (video !== null) {
		navigator.getMedia = ( navigator.getUserMedia ||
	                         navigator.webkitGetUserMedia ||
	                         navigator.mozGetUserMedia ||
							   navigator.msGetUserMedia);

		navigator.getMedia(
			{
				video: true,
				audio: false
			},
			function(stream) {
				if (navigator.mozGetUserMedia) {
					video.mozSrcObject = stream;
				} else {
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL.createObjectURL(stream);
				}
				video.play();
			},
			function(err) {
				console.log("An error occured! " + err);
			}
		);
 
		video.addEventListener('canplay', function(ev){
				if (!streaming) {
					height = video.videoHeight / (video.videoWidth/width);
					video.setAttribute('width', width);
					video.setAttribute('height', height);
					canvas.setAttribute('width', width);
					canvas.setAttribute('height', height);
					superpo.style.width = width + "px";
					superpo.style.height = height + "px";
					streaming = true;
				}
			}, false);
	} else {
		superpo.style.width = fichier.offsetWidth + "px";
		superpo.style.height = fichier.offsetHeight + "px";
	}

	cover.style.position = 'absolute';

	function savePicture() {
		var xhr 	= getXMLHttpRequest();
		var calque	= encodeURIComponent(document.getElementById('hid_calque').value);
		var data 	= encodeURIComponent(document.getElementById('hid_data').value)

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				readData(xhr.responseXML);
			} else if (xhr.readyState < 4) {
				document.getElementById("gif").style.display = "block";
			}
		};

		xhr.open("POST", "save_picture.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("data="+data+"&calque="+calque);
	}

	function readData(rData) {
		if (rData == null) {
			document.getElementById("gif").style.display = "none";
			return;
		}
		document.getElementById('hid_data').removeAttribute('value');
		var photos	= document.getElementById("photos"),
			newPic	= document.getElementById("gif"),
			clone	= newPic.cloneNode(true),
			newPic 	= photos.removeChild(newPic),
 			idPic	= rData.getElementsByTagName('id')[0].textContent,
 			img 	= rData.getElementsByTagName('img')[0].textContent,
			nLink 	= document.createElement('a'),
			div		= document.createElement('div'),
			tLink	= "image.php?id_pic=" + idPic;

		newPic.src = "data:image/png;base64,"+img;
		newPic.className = "pic_galerie";
		newPic.alt = idPic;
		newPic.removeAttribute('id');
		nLink.href = tLink;
		nLink.appendChild(newPic);
		div.appendChild(nLink);
		photos.insertBefore(div, photos.firstChild);

		clone.style.display = "none";
		photos.insertBefore(clone, photos.firstChild);
	}

	function takepicture() {
		var data;
		if (video === null) {
			data = superpo.firstChild.src;
		} else {
			canvas.width = width;
			canvas.height = height;
			canvas.getContext('2d').drawImage(video, 0, 0, width, height);
			data = canvas.toDataURL('image/png');
		}
		var ret = data.slice(data.indexOf(',') + 1);
		document.getElementById('hid_data').setAttribute('value', ret);
	}

	function pos_x(name) {
		if (name == "Niel") {
			return 0;
		} else if (name == "casque") {
			return (superpos.offsetWidth - cover.offsetWidth) / 2;
		} else if (name == "croix") {
			return (superpos.offsetWidth - cover.offsetWidth) / 2;
		} else if (name == "poule") {
			return (superpos.offsetWidth - cover.offsetWidth) + 30;
		} else if (name == "serpent") {
			return 0;
		} else {
			return (superpos.offsetWidth - cover.offsetWidth) / 2;
		}
	}
	function pos_y(name) {
		if (name == "Niel") {
			return superpos.offsetHeight - cover.offsetHeight + 10;
		} else if (name == "casque") {
			return (superpos.offsetHeight - cover.offsetHeight) / 4;
		} else if (name == "croix") {
			return (superpos.offsetHeight - cover.offsetHeight) / 2;
		} else if (name == "poule") {
			return (superpos.offsetHeight - cover.offsetHeight) / 2;
		} else if (name == "serpent") {
			return superpos.offsetHeight - cover.offsetHeight;
		} else {
			return (superpos.offsetHeight - cover.offsetHeight) / 2;
		}
	}

	while (child) {
		child.onclick = function() {
			old_hid	= hidde.getAttribute('value');
			if (!old_hid || old_hid != this.id) {
				if (old_hid){
					document.getElementById(old_hid).style.opacity = "0.5";
				} else {
					superpos.appendChild(cover);
				}
				this.style.opacity = "1";
				hidde.setAttribute('value', this.id);
				cover.setAttribute('src', this.getAttribute('src'));
				cover.style.left = pos_x(this.id) + "px";
				cover.style.top = pos_y(this.id) + "px";
				button.className = "input";
				button.addEventListener('click', handler, false);

			} else {
				hidde.removeAttribute('value');
				cover.removeAttribute('src');
				superpos.removeChild(superpos.lastElementChild);
				this.style.opacity = "0.5";
				button.className = "fail";
				button.removeEventListener('click', handler);
			}
		};
		child = child.nextElementSibling;
	}

})();