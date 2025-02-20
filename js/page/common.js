// alert("1");
function updateRatingValue(value) {
    document.getElementById('ratingValue').textContent = value;
}

function updateColorPreview(color) {
    document.getElementById('colorCode').textContent = color;
    document.getElementById('color').style.backgroundColor = color;
    document.getElementById('colorinput').style.backgroundColor = color;
}