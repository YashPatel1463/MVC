$(function () {
    $(document).on("click", ".status", function (event) {
        // event.preventDefault(); 

        let regId = $(this).data("registration_id");
        let status = $(this).val();

        let data = {
            "event": {
                "registration_id": regId,
                "status": status
            }
        };

        // console.log(data);


        $.ajax({
            url: "http://localhost/mvcproject/ems/event/updateStatus",
            type: "POST",
            data: data,
            success: function (response) {
                // console.log("data updated");
                
                $("#grid-data").html($(response).find("#grid-data").html());
                $("#counts").html($(response).find("#counts").html());
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                alert("Failed to add product to cart!");
            }
        });
    });
});

