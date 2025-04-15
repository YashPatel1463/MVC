$(function () {
    $("#change-password-form").on("submit", function (event) {
        event.preventDefault();

        let currentPw = $("#current_password").val();
        let newPw = $("#new_password").val();
        let confirmPw = $("#confirm_password").val();

        if (newPw !== confirmPw) {
            alert("New Password and Confirm Password do not match! (Case-sensitive)");
            return;
        }

        $.ajax({
            url: "http://localhost/mvcproject/customer/account/savePassword/", 
            type: "POST",
            data: {
                password: {
                    current_password: currentPw,
                    new_password: newPw,
                }
            },
            dataType: "json",       
            success: function (response) {
                console.log(response);
                
                if (response.success) {
                    alert("Password changed successfully!");
                    window.location.href = "http://localhost/mvcproject/customer/account/dashboard/";
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Something went wrong! See console for details.");
            }            
        });
    });
});
