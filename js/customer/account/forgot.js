
$(function () {
    $("#btn-sendOtp").on("click", function () {
        let email = $("#email").val().trim();
        if (!email.includes('@')) {
            $("#emailError").text("Enter a valid email!");
            return;
        }
        $.ajax({
            url: "http://localhost/mvcproject/customer/account/sendOtp",
            type: "POST",
            data: {
                email: email
            },
            success: function (response) {
                try {
                    let data = JSON.parse(response);
                    console.log("Response received:", data);
                    if (data.success) {
                        $("#content-1").hide();
                        $("#content-2").show();
                    } else {
                        $("#emailError").text(data.message);
                    }
                } catch (error) {
                    console.log("Error parsing JSON:", error);
                }
            },
            error: function (xhr) {
                console.log("Error:", xhr.responseText);
            }
        });
    });

    // Verify OTP
    $("#btn-verifyOtp").on("click", function () {
        let email = $("#email").val().trim();
        let otp = $("#otp1").val() + $("#otp2").val() + $("#otp3").val() +
            $("#otp4").val();

        if (otp.length !== 4) {
            $("#otpError").text("Enter a valid 6-digit OTP!");
            return;
        }
        $.ajax({
            url: "http://localhost/mvcproject/customer/account/verifyOtp",
            type: "POST",
            data: {
                email: email,
                otp: otp
            },
            success: function (response) {
                try {
                    let data = JSON.parse(response);
                    console.log("Response received:", data);
                    if (data.success) {
                        $("#content-2").hide();
                        $("#content-3").show();
                    } else {
                        $("#otpError").text(data.message);
                    }
                } catch (error) {
                    console.log("Error parsing JSON:", error);
                }
            },
            error: function (xhr) {
                console.log("Raw Error:", xhr.responseText);
                try {
                    let errorData = JSON.parse(xhr.responseText);
                    $("#emailError").text(errorData.message);
                } catch (e) {
                    console.log("JSON Parsing Error:", e);
                }
            }
        });
    });

    // Change Password
    $("#btn-resetPassword").on("click", function () {
        // console.log("pw change");
        
        // let email = $("#email").val().trim();
        let newPassword = $("#new-password").val();
        let confirmPassword = $("#confirm-password").val();

        if (newPassword.length < 8) {
            $("#passwordError").text("Password must be at least 8 characters long!");
            return;
        }
        if (newPassword !== confirmPassword) {
            $("#confirmError").text("Passwords do not match!");
            return;
        }

        $.ajax({
            url: "http://localhost/mvcproject/customer/account/change",
            type: "POST",
            data: {
                // email: email,
                password: newPassword
            },
            success: function (response) {
                try {
                    let data = JSON.parse(response);
                    console.log("Response received:", data);
                    if (data.success) {
                        $("#content-3").hide();
                        $("#content-4").show();
                    } else {
                        $("#passwordError").text(data.message);
                    }
                } catch (error) {
                    console.log("Error parsing JSON:", error);
                }
            },
            error: function (xhr) {
                console.log("Error:", xhr.responseText);
            }
        });
    });
});

// Move to the next OTP field
function moveNext(current, nextId) {
    if (current.value.length === 1) {
        document.getElementById(nextId)?.focus();
    }
}

// Ensure only numbers are entered in OTP fields
function validateNumber(input) {
    input.value = input.value.replace(/\D/g, '');
}

// Redirect to login page
function redirectToLogin() {
    window.location.href = "http://localhost/mvcproject/customer/account/login";
}
