$(document).ready(function () {
    var rolesTable = $("#roles_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "roles",
            type: "GET",
        },
        columns: [
            { data: "name" },
            { data: "action", orderable: false, searchable: false },
        ],
    });


    deleteAjaxConfirmation({
        selector: "button.delete_role",
        table: rolesTable,
    });

    $('#select_all').on('change', function () {
        const isChecked = $(this).is(':checked');
        $('.form-check-input').prop('checked', isChecked);
    });

    const startPath = $("#start_path");

    if (!startPath.val()) {
        if (!startPath.find("option[value='home']").length) {
            startPath.append(new Option("home", "home", true, true));
        }
        startPath.val("home").trigger("change");
    }

    startPath.select2({
        width: "100%",
        placeholder: LANG.select,
        allowClear: true,
        minimumInputLength: 1,
        ajax: {
            url: "/administration/get-routes",
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    term: params.term,
                    page: params.page || 1,
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                const formatted = data.data.map(item => ({
                    id: item.uri,
                    text: item.uri,
                }));
                return {
                    results: formatted,
                    pagination: {
                        more: data.last_page > params.page,
                    },
                };
            },
            cache: true,
            error: () => console.error("Fallo al cargar datos"),
        },
    });

});
