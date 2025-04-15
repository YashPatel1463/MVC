document.addEventListener("DOMContentLoaded", function() {
    const sameAsBillingCheckbox = document.getElementById("same_as_billing");

    sameAsBillingCheckbox.addEventListener("change", function() {
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
            document.getElementById(`shipping_${field}`).value = isChecked ?
                document.getElementById(`billing_${field}`).value :
                "";
        });
    }
});
//     class FormValidator {
//         constructor() {
//             this.validationRules = {
//                 validate_require: this.validateRequired,
//                 validate_email: this.validateEmail,
//                 validate_phone: this.validatePhone,
//                 validate_name: this.validateName,
//                 validate_address: this.validateAddress,
//                 validate_zipcode: this.validateZipcode,
//             };

//             this.setupFormValidation();

//             const observer = new MutationObserver((mutations) => {
//                 mutations.forEach((mutation) => {
//                     mutation.addedNodes.forEach((node) => {
//                         if (node.nodeType === 1) {
//                             // Ensure it's an element node
//                             if (node.tagName === "FORM") {
//                                 this.attachValidationToForm(node);
//                             } else {
//                                 let form = node.closest("form");
//                                 if (form) {
//                                     this.setupFormValidation();
//                                 }
//                             }
//                         }
//                     });
//                 });
//             });

//             observer.observe(document.body, { childList: true, subtree: true });
//         }

//         validateRequired(input) {
//             return input.value.trim() ? "" : "This field is required";
//         }

//         validateEmail(input) {
//             const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//             return emailPattern.test(input.value) ? "" : "Invalid email format";
//         }

//         validatePhone(input) {
//             return /^\d{10}$/.test(input.value) ?
//                 "" :
//                 "Only 10-digit numbers allowed";
//         }

//         validateZipcode(input) {
//             return /^\d{6}$/.test(input.value) ? "" : "Only 6-digit numbers allowed";
//         }

//         validateName(input) {
//             return /^[a-zA-Z]+$/.test(input.value) ? "" : "Only alphabets allowed";
//         }

//         validateAddress(input) {
//             return /^[a-zA-Z0-9- ]+$/.test(input.value) ?
//                 "" :
//                 "Only alphabets, numbers, and '-' allowed";
//         }

//         showError(input, message) {
//             let errorSpan = input.nextElementSibling;

//             if (!errorSpan || !errorSpan.classList.contains("error-message")) {
//                 errorSpan = document.createElement("span");
//                 errorSpan.classList.add("error-message", "text-danger", "mt-1");
//                 input.parentNode.appendChild(errorSpan);
//             }

//             errorSpan.textContent = message;
//         }

//         setupFormValidation() {
//             let forms = document.getElementsByTagName("form");
//             Array.from(forms).forEach((form) => {
//                 this.attachValidationToForm(form);
//             });
//         }

//         attachValidationToForm(form) {
//             form.addEventListener("submit", (event) => {
//                 event.preventDefault();
//                 let inputs = form.querySelectorAll("input");
//                 let isValid = true;

//                 inputs.forEach((input) => {
//                     let errorMessage = "";

//                     if (input.classList.contains("validate_require") &&
//                         !input.value.trim()) {
//                         errorMessage = "This field is required";
//                     }

//                     if (input.value.trim()) {
//                         Object.keys(this.validationRules).forEach((rule) => {
//                             if (input.classList.contains(rule)) {
//                                 let error = this.validationRules[rule](input);
//                                 if (error) errorMessage = error;
//                             }
//                         });
//                     }

//                     this.showError(input, errorMessage);
//                     if (errorMessage) isValid = false;
//                 });

//                 if (isValid) {
//                     form.submit();
//                 }
//             });

//             this.addRealTimeValidation(
//                 form,
//                 "validate_name",
//                 /^[A-Za-z]{3,}$/,
//                 "Invalid name! Only letters (3+ chars)."
//             );
//             this.addRealTimeValidation(
//                 form,
//                 "validate_address",
//                 /^[A-Za-z0-9\s-]+$/,
//                 "Invalid address! Min 5, max 100 characters. Only - and spaces allowed."
//             );
//             this.addRealTimeValidation(
//                 form,
//                 "validate_phone",
//                 /^[6-9]\d{9}$/,
//                 "Invalid phone number! Must be exactly 10 digits, starting with 6-9."
//             );
//             this.addRealTimeValidation(
//                 form,
//                 "validate_zipcode",
//                 /^[1-9]\d{5}$/,
//                 "Invalid zip code! Must be 6 digits."
//             );
//         }

//         addRealTimeValidation(form, className, regex, errorMessage) {
//             let inputs = form.getElementsByClassName(className);
//             Array.from(inputs).forEach((input) => {
//                 input.addEventListener("input", () => {
//                     this.validateRealTimeInput(input, regex, errorMessage);
//                 });
//             });
//         }

//         validateRealTimeInput(input, regex, errorMessage) {
//             let value = input.value.trim();
//             let errorMsg = input.nextElementSibling;

//             if (!errorMsg || !errorMsg.classList.contains("error-message")) {
//                 errorMsg = document.createElement("span");
//                 errorMsg.classList.add("error-message");
//                 errorMsg.style.color = "red";
//                 input.parentNode.appendChild(errorMsg);
//             }

//             let isValid = regex.test(value);
//             errorMsg.textContent = isValid ? "" : errorMessage;
//         }

//         checkForErrors(form) {
//             let errorMessages = form.getElementsByClassName("error-message");
//             return Array.from(errorMessages).some(
//                 (span) => span.textContent.trim() !== ""
//             );
//         }
//     }

//     new FormValidator();
