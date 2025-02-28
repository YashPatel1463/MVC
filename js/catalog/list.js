document.addEventListener("DOMContentLoaded", function () {
    const minPriceInput = document.getElementById("minPrice");
    const maxPriceInput = document.getElementById("maxPrice");
    const applyFilterBtn = document.getElementById("applyFilter");
    const productCards = document.querySelectorAll(".product-card");

    console.log(minPriceInput);
    console.log(maxPriceInput);
    
    function filterProducts() {
        const minPrice = parseFloat(minPriceInput.value) || 0;
        const maxPrice = parseFloat(maxPriceInput.value) || Infinity;

        productCards.forEach(card => {
            const productPrice = parseFloat(card.getAttribute("data-price"));
            console.log(productPrice);
            
            if (productPrice >= minPrice && productPrice <= maxPrice) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    }

    applyFilterBtn.addEventListener("click", filterProducts);
});
