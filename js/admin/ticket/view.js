$(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const ticketId = urlParams.get('ticket_id');
    $(document).on('click', ".add-btn", function(event) {
        const prevTd = $(this).parent().prev('td');
        const parentId = prevTd.data('id');

        const input = $('<input type="text" name="comments[]">').addClass('comment-input form-control');
        const hidden = $('<input type="hidden" name="parent_ids[]">').val(parentId);
        $(this).parent().append('<br>').append(input).append(hidden);
    });

    $(document).on('click', "#saveAllBtn", function(e) {
        // e.preventDefault();

        let data = [];

        $('#commentTable tbody tr').each(function() {
            // console.log($(this));

            $(this).find('.addComment').each(function() {
                const textInputs = $(this).find('input[type="text"]');
                const hiddenInputs = $(this).find('input[type="hidden"]');

                textInputs.each(function(index) {
                    // console.log(index);

                    const commentText = $(this).val().trim();
                    const parentId = hiddenInputs.eq(index).val();

                    // console.log(commentText);
                    console.log(parentId);

                    if (commentText !== '') {
                        data.push({
                            'comment': commentText,
                            'parent_id': parentId == 0 ? null : parentId,
                            'ticket_id': ticketId
                        });
                    }
                });
            });
        });

        const finalPayload = {
            comment: data
        };

        console.log("Submitting:", finalPayload);

        $.ajax({
            url: "http://localhost/mvcproject/admin/ticket_index/saveComment",
            type: "POST",
            data: finalPayload,
            success: function(response) {
                console.log("data updated");
                console.log(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("Failed to add comment in table!");
            }
        });

    });

    $(document).on('click', ".complete", function(event) {
        // const prevTd = $(this).parent().prev('td');
        // const parentId = prevTd.data('id');

        const currentId = $(this).parent().data('id');
        // console.log(currentId);

        const data = {
            'comment_id': currentId
        };

        // console.log("Submitting:", data);
        $.ajax({
            url: "http://localhost/mvcproject/admin/ticket_index/saveComplete",
            type: "POST",
            data: data,
            success: function(response) {
                console.log("data updated");
                console.log(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("Failed to complete comment in table!");
            }
        });

    });

});