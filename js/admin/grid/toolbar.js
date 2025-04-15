$(function () {
    $(document).on('click', '.page-link2', function (e) {
        e.preventDefault();
        let page = $(this).data('page');
        if (page) {
            $('#page-input').val(page);
            loadPaginationData();
        }
    });

    $(document).on('change', '#limit', function () {
        console.log("in limit");

        $('#page-input').val(1);
        loadPaginationData();
    });
});

function loadPaginationData() {
    const paginationForm = $('#pagination-form');
    const filterForm = $('#filter-form');

    let filterData = filterForm.serializeArray();
    let paginationData = paginationForm.serializeArray();
    console.log(paginationData);

    let combinedData = [...filterData, ...paginationData];

    const data = $.param(combinedData);
    const url = paginationForm.attr('action');

    console.log(url);

    window.history.pushState({}, '', url + '?' + data);

    $.ajax({
        url: url,
        type: 'GET',
        data: data,
        success: function (response) {
            $(".toolbar-container").html($(response).find(".toolbar-container").html());
            $("#grid-data").html($(response).find("#grid-data").html());
        },
        error: function (xhr, status, error) {
            console.error('Pagination AJAX error:', error);
        }
    });
}