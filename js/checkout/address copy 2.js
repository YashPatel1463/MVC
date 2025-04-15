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
      "country",
    ];

    fields.forEach((field) => {
      document.getElementById(`shipping_${field}`).value = isChecked
        ? document.getElementById(`billing_${field}`).value
        : "";
    });
  }

  class FormValidator {
    constructor() {
      this.validationRules = {
        validate_require: this.validateRequired,
        validate_email: this.validateEmail,
        validate_phone: this.validatePhone,
        validate_name: this.validateName,
        validate_address: this.validateAddress,
        validate_zipcode: this.validateZipcode,
      };
      this.setupSubmitValidation();
    }

    validateRequired(input) {
      return input.value.trim() ? "" : "This field is required";
    }

    validateEmail(input) {
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailPattern.test(input.value) ? "" : "Invalid email format";
    }

    validatePhone(input) {
      return /^\d{10}$/.test(input.value)
        ? ""
        : "Only 10 digit numbers allowed";
    }

    validateZipcode(input) {
      return /^\d{6}$/.test(input.value) ? "" : "Only 6 digit numbers allowed";
    }

    validateName(input) {
      return /^[a-zA-Z]+$/.test(input.value) ? "" : "Only alphabets allowed";
    }

    validateAddress(input) {
      return /^[a-zA-Z0-9- ]+$/.test(input.value)
        ? ""
        : "Only alphabets, numbers, and '-' allowed";
    }

    showError(input, message) {
      let errorSpan = input.nextElementSibling;

      if (!errorSpan || !errorSpan.classList.contains("error-message")) {
        errorSpan = document.createElement("span");
        errorSpan.classList.add("error-message", "text-danger", "mt-1");
        input.parentNode.appendChild(errorSpan);
      }

      errorSpan.textContent = message;
    }

    setupSubmitValidation() {
      document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", (event) => {
          event.preventDefault(); // Prevent actual form submission
          let inputs = form.querySelectorAll("input");
          let isValid = true;

          inputs.forEach((input) => {
            let errorMessage = "";

            if (
              input.classList.contains("validate_require") &&
              !input.value.trim()
            ) {
              errorMessage = "This field is required";
            }

            if (input.value.trim()) {
              Object.keys(this.validationRules).forEach((rule) => {
                if (input.classList.contains(rule)) {
                  let error = this.validationRules[rule](input);
                  if (error) errorMessage = error;
                }
              });
            }

            this.showError(input, errorMessage);
            if (errorMessage) isValid = false;
          });

          if (isValid) {
            console.log("Form is valid. Ready for submission.");
            // form.submit(); // Uncomment if actual submission is needed
          }
        });
      });
    }
  }

  // Initialize validation
  new FormValidator();
});
