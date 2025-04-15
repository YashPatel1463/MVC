document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("form.trigger-on-submit").forEach((form) => { //form.trigger-on-submit
        new FormValidator(form);
    });

    const backToTop = document.getElementById("backToTop");

    window.addEventListener("scroll", function () {
        if (window.scrollY > 250) {
            backToTop.style.display = "block";
        } else {
            backToTop.style.display = "none";
        }
    });

    backToTop.addEventListener("click", function (e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });

    const alerts = document.querySelectorAll('.alert');

    alerts.forEach((alert, index) => {
        setTimeout(() => {
            alert.classList.add('show');
        }, 100 * index);
    });

    // Auto-dismiss alerts after a delay
    setTimeout(() => {
        alerts.forEach((alert, index) => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 1000 + (1000 * index));
        });
    }, 1000);
});

$(function () {
    const categoriesDropdown = $("#navbarDropdown");
    const mainCategoriesContainer = $("#mainCategoriesContainer");
    const subcategoryBox = $("#subcategoryBox");
    const subcategoriesList = $("#subcategoriesList");
    const baseUrl = $("#config").data("base-url");

    // Toggle main categories menu
    categoriesDropdown.on("click", function (event) {
        event.stopPropagation();
        mainCategoriesContainer.toggle();
    });

    // Fetch subcategories dynamically on category click
    $(document).on("click", ".main-category", function (event) {
        event.stopPropagation();
        let categoryId = $(this).data("category-id");

        $.ajax({
            url: `${baseUrl}catalog/category/subCategory`,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({ category_id: categoryId }),
            dataType: "json",
            success: function (data) {
                subcategoriesList.empty(); // Clear previous subcategories

                if (data.length === 0) {
                    subcategoriesList.html("<p>No subcategories available</p>");
                } else {
                    let subcategoryHTML = "";
                    data.forEach(sub => {
                        subcategoryHTML += `<a href="${baseUrl}catalog/product/list/?category_id=${sub.id}" class="subcategory-item">${sub.name}</a>`;
                    });
                    subcategoriesList.html(subcategoryHTML);
                }

                // Position and display subcategory box
                let rect = event.target.getBoundingClientRect();
                subcategoryBox.css({
                    top: rect.bottom + "px",
                    left: rect.left + "px",
                    display: "block"
                });
            },
            error: function () {
                console.error("Error fetching subcategories.");
            }
        });
    });

    // Hide dropdowns when clicking outside
    $(document).on("click", function () {
        mainCategoriesContainer.hide();
        subcategoryBox.hide();
    });

    // Prevent hiding when clicking inside subcategory box
    subcategoryBox.on("click", function (event) {
        event.stopPropagation();
    });
});


class FormValidator {
    constructor(form) {
        this.form = form; // Assigning the form dynamically
        this.validationRules = {
            "validate_email": this.validateEmail,
            "validate_number": this.validateNumber,
            "validate_name": this.validateName,
            "validate_phone": this.validatePhoneNumber,
            "validate_address": this.validateStreet,
            "validate_Zipcode": this.validateZipCode,
            "validate_region": this.validateRegion,
            "validate_require": this.validateRequired
        };

        this.setupFormSubmission();
    }

    validateName(input) {
        return /^[A-Za-z]+$/.test(input.value) ? "" : "Invalid name !! Only Alphabets allowed.";
    }
    validatePhoneNumber(input) {
        return /^[0-9]{10,15}$/.test(input.value) ? "" : "Length - 10 to 15 digits, No special characters allowed.";
    }
    validateStreet(input) {
        return /^[A-Za-z0-9-,\s]{2,}$/.test(input.value) ? "" : "Minimum 2 characters, No special characters allowed.";
    }
    validateZipCode(input) {
        return /^[0-9]{5,10}$/.test(input.value) ? "" : "Length - 5 to 10 digits, No special characters allowed";
    }
    validateRegion(input) {
        return /^[A-Za-z0-9\s]{2,}$/.test(input.value) ? "" : "Only alphabets and space allowed";
    }

    validateEmail(input) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value) ? "" : "Invalid email format";
    }

    validateNumber(input) {
        return /^\d+$/.test(input.value) ? "" : "Only numbers allowed";
    }

    validateRequired(input) {
        return input.value.trim() ? "" : "This field is required";
    }

    validateInput(input) {
        let errorMessage = "";
        Object.keys(this.validationRules).forEach((rule) => {
            if (input.classList.contains(rule)) {
                let error = this.validationRules[rule](input);
                if (error) errorMessage = error;
            }
        });

        this.showError(input, errorMessage);
    }

    showError(input, message) {
        let errorDiv = input.nextElementSibling;
        if (!errorDiv || !errorDiv.classList.contains("error-message")) {
            errorDiv = document.createElement("div");
            errorDiv.classList.add("error-message", "text-danger", "mt-1");
            input.parentNode.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
    }

    setupFormSubmission() {
        this.form.addEventListener("submit", (event) => {
            let isValid = true;
            const allInputs = this.form.querySelectorAll("input");

            allInputs.forEach((input) => {
                this.validateInput(input);
                if (input.nextElementSibling && input.nextElementSibling.classList.contains("error-message") && input.nextElementSibling.textContent !== "") {
                    isValid = false;
                }
            });

            if (!isValid) {
                event.preventDefault();
                alert("Please fix validation errors before submitting.");
            }
        });
    }
}
