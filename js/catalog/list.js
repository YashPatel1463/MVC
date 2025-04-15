class FilterApp {

    constructor() {
        this.baseUrl = $("#config").data("base-url");
        this.productContainer = $("#productContainer");
        this.checkboxes = $('.filter-checkbox');
        this.clearFilterBtn = $("#clearFilter");
        this.applyFilterBtn = $("#applyFilter");
        this.urlParams = new URLSearchParams(window.location.search);

        this.init();
    }

    init() {
        $("#applyFilter").on("click", () => this.filterProducts());
        this.setCheckboxesFromURL();
        this.checkboxes.on("change", () => {
            this.updateURL();
            this.fetchFilteredProducts();
        });
        this.clearFilterBtn.on("click", () => this.clearfilterProducts());

        $('#limit').on("change", function () {
            $(this).closest('form').trigger('submit');
        });
        this.generatePagination();
    }

    filterProducts() {
        const minPrice = parseFloat($("#minPrice").val()) || 0;
        const maxPrice = parseFloat($("#maxPrice").val()) || Infinity;

        $(".product-card").each(function () {
            const productPrice = parseFloat($(this).attr("data-price")) || 0;

            if (productPrice >= minPrice && productPrice <= maxPrice) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    updateURL() {
        let urlParams = new URLSearchParams(window.location.search);
        let filters = {};

        this.checkboxes.each(function () {
            let name = $(this).attr('name');
            if ($(this).is(':checked')) {
                if (!filters[name]) {
                    filters[name] = [];
                }
                filters[name].push($(this).val());
            } else {
                urlParams.delete(name);
            }
        });

        for (let key in filters) {
            if (filters[key].length > 0) {
                urlParams.set(key, filters[key].join(","));
            } else {
                urlParams.delete(key);
            }
        }

        window.history.pushState({}, "", "?" + urlParams.toString());
        return filters;
    }

    getUpdatedURL(newPage) {
        const urlParams = new URLSearchParams(window.location.search);
        // console.log(newParams);
        const limit = parseInt(this.urlParams.get('limit')) || 5;

        urlParams.set("page", newPage);
        urlParams.set("limit", limit);
        // console.log(urlParams.toString());

        return `?${urlParams.toString()}`;
    }

    setCheckboxesFromURL() {
        let filters = new URLSearchParams(window.location.search);
        let obj = {};

        filters.forEach((value, key) => {
            let valuesArray = value.includes(",") ? value.split(",") : value;
            obj[key] = obj[key] ? [].concat(obj[key], valuesArray) : valuesArray;
        });

        $.each(obj, function (key, value) {
            $('.filter-checkbox[name="' + key + '"]').each(function () {
                $(this).prop('checked', value.includes($(this).val()));
            });
        });
    }

    generatePagination() {
        const urlParams = new URLSearchParams(window.location.search);

        const limit = parseInt(urlParams.get('limit')) || 5;
        const page = parseInt(urlParams.get('page')) || 1;

        $('#limit').val(limit);

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

        if (page > 1) {
            $('.pagination').append(`<a href="${this.getUpdatedURL(1)}" class="prev-button"> <<</a>`);
            $('.pagination').append(`<a href="${this.getUpdatedURL(page - 1)}" class="prev-button"> <</a>`);
        }

        for (let i = startPage; i <= endPage; i++) {
            let activeClass = i === page ? 'active' : '';
            $('.pagination').append(`<a href="${this.getUpdatedURL(i)}" class="${activeClass} page-button">${i}</a>`);
        }

        if (page < totalPages) {
            $('.pagination').append(`<a href="${this.getUpdatedURL(page + 1)}" class="next-button"> ></a>`);
            $('.pagination').append(`<a href="${this.getUpdatedURL(totalPages)}" class="next-button"> >></a>`);
        }

        let startRecord = (page - 1) * limit + 1;
        let endRecord = Math.min(page * limit, totalRecords);
        $('.records-info').text(`Showing ${startRecord} to ${endRecord} of ${totalRecords} Entries`);
    }

    fetchFilteredProducts() {
        let queryObject = Object.fromEntries(new URLSearchParams(window.location.search));

        $.ajax({
            url: `${this.baseUrl}catalog/product/list/`,
            type: "GET",
            contentType: "application/json",
            data: queryObject,
            success: (response) => {

                let extractedContent = $(response).find("#productContainer").html();
                this.productContainer.empty().html(extractedContent);

                // console.log(response);
                this.generatePagination();
            },
            error: function (xhr, status, error) {
                console.error("Error fetching filtered products:", error);
            },
        });
    }

    clearfilterProducts() {
        let urlParams = new URLSearchParams(window.location.search);
        let obj = {};

        urlParams.forEach((value, key) => {
            let valuesArray = value.includes(",") ? value.split(",") : value;
            obj[key] = obj[key] ? [].concat(obj[key], valuesArray) : valuesArray;
        });

        $.each(obj, function (key) {
            if (key === "category_id") {
                return;
            }
            urlParams.delete(key);
        });

        window.history.pushState({}, "", "?" + urlParams.toString());
        this.checkboxes.prop("checked", false);
        this.fetchFilteredProducts(urlParams.toString());
    }
}

$(() => {
    new FilterApp();
});
