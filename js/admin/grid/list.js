$(function () {
    let urlParams = new URLSearchParams(window.location.search);

    $(document).on("click", "#filter-btn", function(event) {
        event.preventDefault(); 

        let form = $("#filter-form");
        console.log(form);
        
        let filteredData = form.serializeArray().filter(function(field) {
            return field.value.trim() !== "";
        });
    
        let formData = $.param(filteredData);
        
        let path = window.location.pathname;
        let fullUrl = `${path}${formData ? '?' + formData : ''}`;
        window.history.pushState({}, '', fullUrl);

        // let url = window.location.pathname;

        $.ajax({
            url: `http://localhost${path}`, 
            type: "GET",
            data: formData,
            success: function (response) {
                $("#grid-data").empty().html($(response).find("#grid-data").html());
                $(".admin-toolbar").empty().html($(response).find(".admin-toolbar").html());
                // console.log("Response:", response);
                // $.getScript("http://localhost/mvcproject/js/admin/grid/toolbar.js")
                // .done(function(script, textStatus) {
                //     console.log("Script loaded successfully.");
                // })
                // .fail(function(jqxhr, settings, exception) {
                //     console.error("Script load failed.");
                // });
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                alert("Failed to add product to cart!");
            }
        });
    });


    //remove
    $(document).on("click", "#remove-filter-btn", function (event) {
        event.preventDefault();
    
        let path = window.location.pathname;
        $("#filter-form").find("input, select, textarea").val("");
        window.history.pushState({}, '', path);
        urlParams = new URLSearchParams(); 
    
        $.ajax({
            url: path,
            type: "GET",
            success: function (response) {
                $(".table-container").html($(response).find(".table-container").html());    
                $(".admin-toolbar").empty().html($(response).find(".admin-toolbar").html());
            },
            error: function () {
                alert("Something went wrong while clearing filters.");
            }
        });
    });
    
    
    
});

