(function() {

	var calque	= document.getElementById('calque'),
		hidde	= document.getElementById('hid_calque'),
		video	= document.getElementById('video'),
		button	= document.getElementById('button'),
		superpos = document.getElementById('superpos'),
		child	= calque.firstElementChild,
		cover	= document.createElement("IMG"),
		handler = function(ev){
					takepicture();
					savePicture();
					ev.preventDefault();
				};

		cover.style.position = 'absolute';

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
				alert("coucou");
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