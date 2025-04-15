$(function() {
    $('input[name="shipping_method"], input[name="payment_method"]').on('change', function() {
        let shippingMethod = $('input[name="shipping_method"]:checked').val();
        let paymentMethod = $('input[name="payment_method"]:checked').val();

        let dataToSend = {
            shipping_method: shippingMethod,
            payment_method: paymentMethod
        };

        $.ajax({
            url: "http://localhost/mvcproject/checkout/shipping/save",
            type: "POST",
            data: JSON.stringify(dataToSend), // Convert to JSON format
            contentType: "application/json", // Ensure correct content type
            success: function(response) {
                console.log("Response:", response);
                // Optional: Update UI if needed
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    });
});