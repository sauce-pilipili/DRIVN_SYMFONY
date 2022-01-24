function handleFilesImageEnAvant(files,) {
    var imageType = /^image\//;
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (!imageType.test(file.type)) {
            alert("veuillez sélectionner une image");
        } else {
            if (i == 0) {
                previewAvant.innerHTML = '';
            }
            var img = document.createElement("img");
            img.classList.add("image-preview");
            img.file = file;
            previewAvant.appendChild(img);
            var reader = new FileReader();
            reader.onload = (function (aImg) {
                return function (e) {
                    aImg.src = e.target.result;
                };
            })(img);
            reader.readAsDataURL(file);
        }
    }
}