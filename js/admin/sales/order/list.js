// $(function () {
//     $(".orderStatus").on("change", function () {
//         $(this).closest(".status-form").trigger("submit");
//     });
// });


$(function () {
    $(".orderStatus").on("change", function (event) {
        event.preventDefault(); 

        // let form = $(this).closest("form");
        // console.log(form);
        
        // let formData = form.serialize(); 
        // console.log(formData);
        let orderId = $(this).data("order_id"); // Get order_id from data attribute
        let orderStatus = $(this).val();

        let data = { "order" : {
            "order_id": orderId,
            "order_status": orderStatus
        }};

        console.log(data);
        

        $.ajax({
            url: "http://localhost/mvcproject/admin/sales_order/updateStatus", 
            type: "POST",
            data: data,
            success: function (response) {
                // alert("Product added to cart successfully!");
                console.log("Response:", response);
                // Optional: Update cart count, UI, etc.
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                alert("Failed to add product to cart!");
            }
        });
    });
});

