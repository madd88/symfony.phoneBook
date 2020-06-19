
/**
 *  Поиск абонентов *
 */

var PhoneBook = (function () {

    var tableId = "phone_book_table";

    /**
     * init
     */
    function init() {
        bindEvents();
        $('#phone_book_table').bootstrapTable();
    }

    /**
     * bindEvents
     */
    function bindEvents() {
        $(document)
            .on('click', '#phone_search_button', filter)
    }

    /**
     * Поиск
     */
    function filter() {
        var fullName = $('input[name="full_name"]').val();
        var phone = $('input[name="phone"]').val();

        $.post("/filter",
            {
                full_name: fullName,
                phone: phone
            },
            function (data) {
                renderTable(data)
            }, "json");
        return false;
    }

    function renderTable(data) {
        $('#phone_book_table').bootstrapTable('load', data);
    }


    $(function () {
        init();
    });

    return {
        filter: filter
    }
})();