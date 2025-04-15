document.addEventListener("DOMContentLoaded", function () {
    const sameAsBillingCheckbox = document.getElementById("same_as_billing");

    sameAsBillingCheckbox.addEventListener("change", function () {
        toggleShippingAddress(this.checked);
    });

function toggleShippingAddress(isChecked) {
    const fields = [
        "firstname",
        "lastname",
        "phone",
        "address1",
        "city",
        "state",
        "zip",
        "country"
    ];

    fields.forEach(field => {
        document.getElementById(`shipping_${field}`).value = isChecked 
            ? document.getElementById(`billing_${field}`).value 
            : "";
    });
}


class FormValidator {
    constructor() {
        this.validationRules = {
            "validate_email": this.validateEmail,
            "validate_phone": this.validatePhone,
            "validate_name": this.validateName,
            "validate_address": this.validateAddress,
            "validate_zipcode": this.validateZipcode,
            "validate_required": this.validateRequired
        };
        this.observeInputs();
    }

    validateRequired(input) {
        return input.value.trim() ? "" : "This field is required";
    }

    // Email Validation
    validateEmail(input) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(input.value) ? "" : "Invalid email format";
    }

    // Number Validation
    validatePhone(input) {
        return /^\d{10}$/.test(input.value) ? "" : "Only 10 digit numbers allowed";
    }

    validateZipcode(input) {
        return /^\d{6}$/.test(input.value) ? "" : "Only 6 digit numbers allowed";
    }

    validateName(input) {
        return /^[a-zA-Z]+$/.test(input.value) ? "" : "Only alphabets allowed";
    }

    validateAddress(input) {
        return /^[a-zA-Z- ]+$/.test(input.value) ? "" : "Only alphabets and '-' allowed";
    }

    // Validate a single input
    validateInput(input) {
        let errorMessage = "";
        
        Object.keys(this.validationRules).forEach((rule) => {
            if (input.classList.contains(rule)) {
                let error = this.validationRules[rule](input);
                if (error) errorMessage = error; // Only last error is shown
            }
        });

        this.showError(input, errorMessage);
    }

    // Show error message
    showError(input, message) {
        let errorSpan = input.nextElementSibling;
        if (!errorSpan || !errorSpan.classList.contains("error-message")) {
            errorSpan = document.createElement("span");
            errorSpan.classList.add("error-message", "text-danger", "mt-1");
            input.parentNode.appendChild(errorSpan);
        }
        errorSpan.textContent = message;
    }

    // Observe inputs for validation
    observeInputs() {
        document.addEventListener("input", (event) => {
            if (event.target.tagName === "INPUT") {
                this.validateInput(event.target);
            }
        });

        // MutationObserver for dynamically added inputs
        let observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.tagName === "INPUT") this.validateInput(node);
                });
            });
        });

        observer.observe(document.body, { childList: true, subtree: true });
    }
}

// Initialize validation system
new FormValidator();

});