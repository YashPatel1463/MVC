$(function () {
    $(document).on("click", ".defaultAddress", function (event) {
        event.preventDefault();
        let id = $(this).attr('id');
        console.log(id);
        
        $.ajax({
            url: "http://localhost/mvcproject/customer/account_address/setDefault/", 
            type: "GET",
            data: {'address_id':id},
            // dataType: "json",
            success: function (response) {
                console.log("Response:" , response);
                
                let newContent = $(response).find("#addressGrid").html();
                if (newContent) {
                    $("#addressGrid").html(newContent);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    });
});