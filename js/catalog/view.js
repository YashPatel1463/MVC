document.addEventListener("DOMContentLoaded", function () {
    const mainImage = document.getElementById("mainImage");
    const thumbnails = document.querySelectorAll(".thumbnail");

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener("click", function () {
            mainImage.src = this.src;
            
            // Remove active class from all thumbnails
            thumbnails.forEach(img => img.classList.remove("active"));

            // Add active class to the clicked thumbnail
            this.classList.add("active");
        });
    });
});
