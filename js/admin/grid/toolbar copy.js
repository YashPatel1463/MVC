    $(function() {
        const urlParams = new URLSearchParams(window.location.search);
        // console.log(urlParams);
        
        const limit = parseInt(urlParams.get('limit')) || 5;
        const page = parseInt(urlParams.get('page')) || 1;

        $('#limit').val(limit);

        $('#limit').on("change", function() {
            
            $(this).closest('form').trigger('submit');
        });

        $('.pagination').html('');

        const totalRecords = parseInt($('.records-info').attr('data-total-records'));
        const totalPages = Math.ceil(totalRecords / limit);

        let startPage, endPage;

        if (totalPages <= 3) {
            startPage = 1;
            endPage = totalPages;
        } else if (page === 1) {
            startPage = 1;
            endPage = 3;
        } else if (page === totalPages) {
            startPage = totalPages - 2;
            endPage = totalPages;
        } else {
            startPage = page - 1;
            endPage = page + 1;
        }

        function getUpdatedURL(newPage) {
            // const newParams = new URLSearchParams(window.location.search);
            // console.log(newParams);
            
            urlParams.set("page", newPage);
            urlParams.set("limit", limit);
            // console.log(urlParams.toString());
            
            return `?${urlParams.toString()}`;
        }
        

        if (page > 1) {
            $('.pagination').append(`<a href="${getUpdatedURL(1)}" class="prev-button"> <<</a>`);
            $('.pagination').append(`<a href="${getUpdatedURL(page - 1)}" class="prev-button"> <</a>`);
        }

        for (let i = startPage; i <= endPage; i++) {
            let activeClass = i === page ? 'active' : '';
            $('.pagination').append(`<a href="${getUpdatedURL(i)}" class="${activeClass} page-button">${i}</a>`);
        }

        if (page < totalPages) {
            $('.pagination').append(`<a href="${getUpdatedURL(page + 1)}" class="next-button"> ></a>`);
            $('.pagination').append(`<a href="${getUpdatedURL(totalPages)}" class="next-button"> >></a>`);
        }

        let startRecord = (page - 1) * limit + 1;
        let endRecord = Math.min(page * limit, totalRecords);
        $('.records-info').text(`Showing ${startRecord} to ${endRecord} of ${totalRecords} Entries`);
    });
