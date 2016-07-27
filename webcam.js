(function() {

	var streaming = false,
		video   = document.querySelector('#video'),
		cover   = document.querySelector('#cover'),
		canvas  = document.querySelector('#canvas'),
		photo   = document.querySelector('#photo'),
		button  = document.querySelector('#button'),
		save    = document.querySelector('#save'),
		width   = 500,
		height  = 0;

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

	function takepicture() {
		canvas.width = width;
		canvas.height = height;
		canvas.getContext('2d').drawImage(video, 0, 0, width, height);
		var data = canvas.toDataURL('image/png');
		button.setAttribute('value', data.slice(22));
	}

	button.addEventListener('click', function(ev){
			takepicture();
			submit();
			ev.preventDefault();
		}, false);

	save.addEventListener('click', function(ev){
			save.setAttribute('value', photo.getAttribute('src').slice(22));
			submit();	
			ev.preventDefault();
		}, false);

})();