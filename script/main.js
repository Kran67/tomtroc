function imageChanged(obj, imgId) {
    var reader = new FileReader();

    reader.onload = (e) => {
        document.getElementById(imgId).src = e.target.result;
    }

    reader.readAsDataURL(obj.files[0]);
}