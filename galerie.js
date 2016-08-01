(function() {


	var galerie		= document.getElementById('galerie'),
		visible		= galerie.firstElementChild,
		image		= visible.getElementsByTagName('img');

	
	for($i=0; $i<image.length; $i++) {
		image[$i].style.display = null;
	}
	insertImg(resize())
	galerie.style.overflow = "hidden";
	galerie.style.position = "relative";

	visible.style.position = "absolute";
	visible.style.left = 0;
	visible.style.transitionProperty = "left";
	visible.style.transitionDuration = "1s";
	visible.style.display = "flex";
	visible.style.flexDirection = "column";
	visible.style.flexWrap = "wrap";

	document.getElementsByTagName('body')[0].setAttribute("onresize", "resize()");


})();

function insertImg(nbImg) {
	var xhr 	= getXMLHttpRequest(),
		page	= document.getElementById('page').firstChild.nodeValue;

		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				readData(xhr.responseXML);
			}
		};
		xhr.open("POST", "pagination.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("nb_img="+nbImg+"&page="+page);
}

function readData(oData){
	console.log(oData);
	var id 	= oData.getElementsByTagName('id'),
		bin = oData.getElementsByTagName('bin'),
		nb  = oData.getElementsByTagName('nb')[0].textContent,
		fst  = oData.getElementsByTagName('first')[0].textContent,
		zom = document.getElementsByClassName('zoom');
 
		for(var i = 0; i < nb; i++) {
			j = Number(fst) + i - 1;
			zom[j].firstChild.href = "image.php?id_pic="+id[i].textContent;
			zom[j].firstChild.firstChild.src = "data:image/png;base64,"+bin[i].textContent;
		}
}

function findNbByWidth(width){
		if (width > 1000) {
			return 4;
		} else if (width > 740) {
			return 3;
		} else if (width > 530) {
			return 2;
		} else {
			return 1;
		}
}

function resize() {


	var galerie		= document.getElementById('galerie'),
		visible		= galerie.firstElementChild,
		image		= visible.getElementsByTagName('img'),
		left		= document.getElementById('left'),
		right		= document.getElementById('right'),
		page		= document.getElementById('page').firstChild,
		nb_img		= image.length,
		windowWidth = window.innerWidth,
		nb_max		= 4,
		nb_by_w		= findNbByWidth(windowWidth),
		nb_by_h		= nb_img / nb_by_w < nb_max ? Math.ceil(nb_img / nb_by_w) : nb_max,
		nb_page		= Math.ceil(nb_img / (nb_by_h * nb_by_w)),
		margin		= 10;

	var	height	= nb_by_h * (150 + margin * 2),
		width	= nb_by_w * (200 + margin * 2),
		nb 		= nb_by_w * nb_by_h;

	galerie.style.width = width + "px";
	galerie.style.height = height + "px";

	visible.style.height = height + "px";

	left.onclick = function() {	
		if (page.nodeValue > 1) {
			page.nodeValue = +page.nodeValue - 1;
			visible.style.left = (-(page.nodeValue - 1) * width) + "px";
		}
	};

	right.onclick = function() {
		if (page.nodeValue < nb_page) {
			page.nodeValue = +page.nodeValue + 1;
			if (document.getElementsByClassName('zoom')[nb * (page.nodeValue - 1) + 1].firstChild.href == "") {
				insertImg(nb);	
			}
			visible.style.left = (-(page.nodeValue - 1) * width) + "px";
		}
	};
	return nb;
}