document.addEventListener("DOMContentLoaded", function() {
    const backToTop = document.getElementById("backToTop");

    window.addEventListener("scroll", function() {
        if (window.scrollY > 300) {
            backToTop.style.display = "block";
        } else {
            backToTop.style.display = "none";
        }
    });

    backToTop.addEventListener("click", function(e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const categoriesDropdown = document.getElementById("navbarDropdown");
    const mainCategoriesContainer = document.getElementById("mainCategoriesContainer");
    const mainCategories = document.querySelectorAll(".main-category");
    const subcategoryBox = document.getElementById("subcategoryBox");
    const subcategoriesList = document.getElementById("subcategoriesList");
    const baseUrl = document.getElementById("config").getAttribute("data-base-url");

    // const baseUrl = "http://localhost/mvcproject/";

    // Show Main Categories on Click
    categoriesDropdown.addEventListener("click", function (event) {
        event.stopPropagation(); // Prevent closing when clicking inside
        mainCategoriesContainer.style.display = 
            (mainCategoriesContainer.style.display === "block") ? "none" : "block";
    });

    // Show Subcategories on Click
    mainCategories.forEach(category => {
        category.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevent event bubbling
            const categoryId = this.getAttribute("data-category-id");

            const subcategoryData = document.getElementById("subcat-" + categoryId);

            if (subcategoryData) {
                const subcategories = JSON.parse(subcategoryData.getAttribute("data-subcategories"));

                // Clear previous subcategories
                subcategoriesList.innerHTML = "";

                subcategories.forEach(sub => {
                    let subcatLink = document.createElement("a");
                    subcatLink.href = baseUrl+`catalog/product/list/?category_id=${sub.id}`;
                    subcatLink.textContent = sub.name;
                    subcategoriesList.appendChild(subcatLink);
                });

                // Position the subcategory box
                const rect = this.getBoundingClientRect();
                subcategoryBox.style.top = rect.bottom + "px";
                subcategoryBox.style.left = rect.left + "px";
                subcategoryBox.style.display = "block";
            }
        });
    });

    // Hide on clicking outside
    document.addEventListener("click", function () {
        mainCategoriesContainer.style.display = "none";
        subcategoryBox.style.display = "none";
    });

    // Prevent hiding when clicking inside subcategory box
    subcategoryBox.addEventListener("click", function (event) {
        event.stopPropagation();
    });
});