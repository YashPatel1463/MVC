$(function () {
    const urlParams = new URLSearchParams(window.location.search);

    function getCurrentParams() {
        return {
            limit: parseInt(urlParams.get('limit')) || 5,
            page: parseInt(urlParams.get('page')) || 1
        };
    }

    // Set initial dropdown value
    $('#limit').val(getCurrentParams().limit);

    // Handle limit change
    $(document).on('change', '#limit', function () {
        urlParams.set('limit', $(this).val());
        urlParams.set('page', 1);
        fetchAndUpdate();
    });

    // Handle pagination click
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page) {
            urlParams.set('page', page);
            fetchAndUpdate();
        }
    });

    function fetchAndUpdate() {
        const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
        window.history.pushState({}, '', newUrl);

        $.ajax({
            url: newUrl,
            type: 'GET',
            success: function (response) {
                $('.table-container').html($(response).find('.table-container').html());
                $('.content-wrapper').html($(response).find('.content-wrapper').html());
                buildPagination();
            },
            error: function () {
                alert('Failed to fetch data.');
            }
        });
    }

    function buildPagination() {
        const { limit, page } = getCurrentParams();
        const totalRecords = parseInt($('.records-info').data('total-records')) || 0;
        const totalPages = Math.ceil(totalRecords / limit);

        let startPage = Math.max(page - 1, 1);
        let endPage = Math.min(page + 1, totalPages);

        if (totalPages <= 3) {
            startPage = 1;
            endPage = totalPages;
        } else if (page === 1) {
            endPage = 3;
        } else if (page === totalPages) {
            startPage = totalPages - 2;
        }

        function buildURL(p) {
            const tempParams = new URLSearchParams(window.location.search);
            tempParams.set('page', p);
            // console.log(tempParams);
            
            return `?${tempParams.toString()}`;
        }

        $('.pagination').empty();

        if (page > 1) {
            $('.pagination').append(`<a href="${buildURL(1)}" data-page="1" class="prev-button"><<</a>`);
            $('.pagination').append(`<a href="${buildURL(page - 1)}" data-page="${page - 1}" class="prev-button"><</a>`);
        }

        for (let i = startPage; i <= endPage; i++) {
            const active = i === page ? 'active' : '';
            $('.pagination').append(`<a href="${buildURL(i)}" data-page="${i}" class="page-button ${active}">${i}</a>`);
        }

        if (page < totalPages) {
            $('.pagination').append(`<a href="${buildURL(page + 1)}" data-page="${page + 1}" class="next-button">></a>`);
            $('.pagination').append(`<a href="${buildURL(totalPages)}" data-page="${totalPages}" class="next-button">>></a>`);
        }

        const startRecord = (page - 1) * limit + 1;
        const endRecord = Math.min(page * limit, totalRecords);
        $('.records-info').text(`Showing ${startRecord} to ${endRecord} of ${totalRecords} Entries`);
    }

    buildPagination();
});
