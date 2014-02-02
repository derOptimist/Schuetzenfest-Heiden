// Once files have been selected
document.querySelector('#fileinput').addEventListener('change', function(event){

	// Read files
	var files = event.target.files;

	// Iterate through files
	for (var i = 0; i < files.length; i++) {

		// Ensure it's an image
		if (files[i].type.match(/image.*/)) {

         $("#pictures").html('Bild wird hochgeladen').trigger('create');

			// Load image
			var reader = new FileReader();
			reader.onload = function (readerEvent) {
				var image = new Image();
				image.onload = function (imageEvent) {

					// Add elemnt to page
					var imageElement = document.createElement('div');
					imageElement.classList.add('uploading');
					imageElement.innerHTML = '<span class="progress"><span></span></span>';
					var progressElement = imageElement.querySelector('span.progress span');
					progressElement.style.width = 0;
					document.querySelector('#photos').appendChild(imageElement);

					// Resize image
					var canvas = document.createElement('canvas'),
						max_size = 1200,
						width = image.width,
						height = image.height;
					if (width > height) {
						if (width > max_size) {
							height *= max_size / width;
							width = max_size;
						}
					} else {
						if (height > max_size) {
							width *= max_size / height;
							height = max_size;
						}
					}
					canvas.width = width;
					canvas.height = height;
					canvas.getContext('2d').drawImage(image, 0, 0, width, height);

					// Upload image
					var xhr = new XMLHttpRequest();
					if (xhr.upload) {

						// Update progress
						xhr.upload.addEventListener('progress', function(event) {
							var percent = parseInt(event.loaded / event.total * 100);
							progressElement.style.width = percent+'%';
						}, false);

						// File uploaded / failed
						xhr.onreadystatechange = function(event) {
							if (xhr.readyState == 4) {
								if (xhr.status == 200) {

									imageElement.classList.remove('uploading');
									imageElement.classList.add('uploaded');
									imageElement.style.backgroundImage = 'url('+xhr.responseText+')';
                           document.querySelector('#uploadprogress').value = 'Erfolgreich hochgeladen. Die Bilder werden erst nach Freigabe des Administrators angezeigt.';

									alert("Erfolgreich hochgeladen. Die Bilder werden erst nach Freigabe des Administrators angezeigt");
								} else {
                        
                           document.querySelector('#uploadprogress').value = 'Fehler beim Hochladen.';
									alert("Fehler beim Hochladen.");
								}
							}
						}

						// Start upload
						xhr.open('post', 'http://schwitte.de/heiden/upload/process.php', true);
						xhr.send(canvas.toDataURL('image/jpeg'));

					}

				}

				image.src = readerEvent.target.result;

			}
			reader.readAsDataURL(files[i]);
		}

	}

	// Clear files
	event.target.value = '';

});