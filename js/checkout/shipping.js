// $(function() {
//     $('input[name="shipping_method"], input[name="payment_method"]').on('change', function() {
//         $('#billing-form').trigger("submit");
//     });
// });

document.addEventListener("DOMContentLoaded", function () {
    const shippingMethods = document.querySelectorAll('input[name="shipping_method"]');
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const form = document.getElementById("billing-form");
    const placeOrderBtn = document.querySelector(".place-order-btn");

    function triggerSubmit() {
        form.submit();
    }

    [...shippingMethods, ...paymentMethods].forEach(input => {
        input.addEventListener("change", triggerSubmit);
    });

    placeOrderBtn.addEventListener("click", function (event) {
        const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
        
        if (!selectedShipping) {
            alert("Please select a shipping method before placing your order.");
            event.preventDefault(); // Prevent redirection
        }
    });
});

// document.addEventListener("DOMContentLoaded", function () {
//     const sameAsBillingCheckbox = document.getElementById("same_as_billing");
//     const form = document.getElementById("billing-form");

//     sameAsBillingCheckbox.addEventListener("change", function () {
//         toggleShippingAddress(this.checked);
//     });

//     // Attach validation to form submit event
//     form.addEventListener("submit", function (event) {
//         if (!validate("billing") || !validate("shipping")) {
//             event.preventDefault(); // Prevent form submission if validation fails
//         }
//     });


// function toggleShippingAddress(isChecked) {
//     const fields = [
//         "firstname",
//         "lastname",
//         "phone",
//         "address1",
//         "city",
//         "state",
//         "zip",
//         "country"
//     ];

//     fields.forEach(field => {
//         document.getElementById(`shipping_${field}`).value = isChecked 
//             ? document.getElementById(`billing_${field}`).value 
//             : "";
//     });
// }

// function setSpan(type, id, value) {
//     document.getElementById(type + "-" + id + "-error").innerHTML = value;
// }

// function validate(type) {
//     let email = document.getElementById('email').value.trim();
//     let fname = document.getElementById(`${type}_firstname`).value.trim();
//     let lastname = document.getElementById(`${type}_lastname`).value.trim();
//     let phone = document.getElementById(`${type}_phone`).value.trim();
//     let address = document.getElementById(`${type}_address1`).value.trim();
//     let city = document.getElementById(`${type}_city`).value.trim();
//     let state = document.getElementById(`${type}_state`).value.trim();
//     let country = document.getElementById(`${type}_country`).value.trim();
//     let zipcode = document.getElementById(`${type}_zip`).value.trim();

//     let isValid = true;
    
//     if (!email.match(/^\S+@\S+\.\S+$/)) {
//         document.getElementById("email-error").innerHTML = "Enter a valid email address.";
//         isValid = false;
//     } else {
//         document.getElementById("email-error").innerHTML = "";
//     }

//     if (!fname.match(/^[a-zA-Z]+$/)) {
//         setSpan(type, "fname", "First name cannot be empty and must not contain special characters or numbers.");
//         isValid = false;
//     } else {
//         setSpan(type, "fname","");
//     }

//     if (!lastname.match(/^[a-zA-Z]+$/)) {
//         setSpan(type, "lastname","Last name cannot be empty and must not contain special characters or numbers.");
//         isValid = false;
//     } else {
//         setSpan(type, "lastname","");
//     }

//     if (!phone.match(/^\d{10}$/)) {
//         setSpan(type, "phone", "Enter a valid 10-digit phone number.");
//         isValid = false;
//     } else {
//         setSpan(type, 'phone', "");
//     }

//     if (address === '' || !address.match(/^[a-zA-Z0-9 -]+$/)) {
//         setSpan(type, "address",'Address cannot be empty and cannot contain special character.');
//         isValid = false;
//     } else {
//         setSpan(type, 'address', '');
//     }

//     if (city === '' || !city.match(/^[a-zA-Z]+$/)) {
//         setSpan(type, 'city', "City cannot be empty and cannot contain special character.");
//         isValid = false;
//     } else {
//         setSpan(type, "city", "");
//     }

//     if (state === '' || !state.match(/^[a-zA-Z]+$/)) {
//         setSpan(type, "state", 'State cannot be empty and cannot contain special character.');
//         isValid = false;
//     } else {
//         setSpan(type, "state", "");
//     }

//     if (country === '' || !country.match(/^[a-zA-Z]+$/)) {
//         setSpan(type, "country", "Country cannot be empty and cannot contain special character.");
//         isValid = false;
//     } else {
//         setSpan(type, "country", "");
//     }

//     if (!zipcode.match(/^\d{6}$/)) {
//         setSpan(type, "zipcode", "Enter a valid ZIP code 6 digits.");
//         isValid = false;
//     } else {
//         setSpan(type, "zipcode", "");
//     }

//     return isValid;
// }

// });