(function() {

	var streaming = false,
		video   = document.querySelector('#video'),
		cover   = document.querySelector('#cover'),
		canvas  = document.querySelector('#canvas'),
		photo   = document.querySelector('#photo'),
		button  = document.querySelector('#button'),
		superpo = document.querySelector('#superpos'),
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
					streaming = true;
				}
			}, false);
	}

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
		div.className = "pic_nav";
		div.appendChild(nLink);
		photos.insertBefore(div, photos.firstChild);

		clone.style.display = "none";
		photos.insertBefore(clone, photos.firstChild);

		document.getElementById('hid_data').removeAttribute('value');
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

	button.addEventListener('click', function(ev){
		takepicture();
		savePicture();
		ev.preventDefault();
	}, false);

})();