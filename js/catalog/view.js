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

$(function () {
    $(".btn-add-cart").on("click", function (event) {
        event.preventDefault(); 

        let form = $(this).closest("form");
        // console.log(form);
        
        let formData = form.serialize(); 
        // console.log(formData);
        
        $.ajax({
            url: "http://localhost/mvcproject/checkout/cart/add", 
            type: "POST",
            data: formData,
            success: function (response) {
                let extractedContent = $(response).find("#cartcount").html();
                $("#cartcount").empty().html(extractedContent);
                // alert("Product added to cart successfully!");
                // console.log("Response:", response);
                // Optional: Update cart count, UI, etc.
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                alert("Failed to add product to cart!");
            }
        });
    });
});

