(function() {


	var galerie		= document.getElementById('galerie'),
		visible		= galerie.firstElementChild,
		image		= visible.getElementsByTagName('img'),
		nb_img		= image.length,
		left		= document.getElementById('left'),
		right		= document.getElementById('right'),
		page		= document.getElementById('page').firstChild,
		windowWidth = window.innerWidth,
		nb_max		= 4,
		nb_by_w		= findNbByWidth(windowWidth),
		nb_by_h		= nb_img / nb_by_w < nb_max ? Math.ceil(nb_img / nb_by_w) : nb_max,
		nb_page		= Math.ceil(nb_img / (nb_by_h * nb_by_w)),
		margin		= 5;

	for($i=0; $i<image.length; $i++) {
		image[$i].style.display = null;
	}

	var	height	= nb_by_h * (4 + image[0].offsetHeight + margin * 2),
		width	= nb_by_w * (image[0].offsetWidth + margin * 2);

	galerie.style.overflow = "hidden";
	galerie.style.position = "relative";
	console.log(height+" - "+width);
	galerie.style.width = width + "px";
	galerie.style.height = height + "px";

	visible.style.position = "absolute";
	visible.style.height = height + "px";
	visible.style.left = 0;
	visible.style.transitionProperty = "left";
	visible.style.transitionDuration = "1s";
	visible.style.display = "flex";
	visible.style.flexDirection = "column";
	visible.style.flexWrap = "wrap";

	document.getElementsByTagName('body')[0].setAttribute("onresize", "resize()");

	left.onclick = function() {	
		if (page.nodeValue > 1) {
			page.nodeValue = +page.nodeValue - 1;
			visible.style.left = (-(page.nodeValue - 1) * width) + "px";
		}
	};

	right.onclick = function() {
		if (page.nodeValue < nb_page) {
			page.nodeValue = +page.nodeValue + 1;
			visible.style.left = (-(page.nodeValue - 1) * width) + "px";
		}
	};

})();

function findNbByWidth(width){
		if (width > 950) {
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
		nb_img		= image.length,
		windowWidth = window.innerWidth,
		nb_max		= 4,
		nb_by_w		= findNbByWidth(windowWidth),
		nb_by_h		= nb_img / nb_by_w < nb_max ? Math.ceil(nb_img / nb_by_w) : nb_max,
		margin		= 5;

	var	height	= nb_by_h * (4 + image[0].offsetHeight + margin * 2),
		width	= nb_by_w * (image[0].offsetWidth + margin * 2);

	galerie.style.width = width + "px";
	galerie.style.height = height + "px";

	visible.style.height = height + "px";
}