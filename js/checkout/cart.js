$(function(){
    $(document).on("click", "#coupon", function (event) {
    // $("#coupon").on("click", function(){    
        $.ajax({
            url: "http://localhost/mvcproject/checkout/cart/applyCoupon",
            type: "post",
            data: {coupon : {
                type : $("#coupon").val(),
                coupon_code: $("#cname").val(),
                subTotal: $("#subTotal").val()
            }},
            success: function(res) {
                let extractedContent = $(res).find(".cart-footer").html();
                $(".cart-footer").empty().html(extractedContent);
                // console.log("res: ", res);
            },
            error: function(error) {
                console.log(error);
            } 
        });
    });
});