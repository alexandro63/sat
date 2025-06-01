$(document).ready(function () {
    var usersTable = $("#users_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "usuarios",
            type: "GET",
        },
        columns: [
            { data: "user_name" },
            { data: "per_id" },
            { data: "status" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm("form#add_user", "div.modal_user", usersTable);

    updateAjaxForm(
        "form#edit_user",
        "button.edit_user",
        "div.modal_user",
        usersTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_user",
        table: usersTable,
    });

    $("div.modal_user").on("show.bs.modal", function () {
        $("#per_id").select2({
            dropdownParent: $("div.modal_user"),
            width: "100%",
            placeholder: LANG.select,
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: "/administracion/get-personas",
                type: "GET",
                dataType: "json",
                delay: 250,
                data: (params) => ({
                    term: params.term,
                    page: params.page || 1,
                }),
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    const formatted = data.data.map((item) => ({
                        id: item.id,
                        text:
                            "( C.I. " +
                            item.carnet +
                            ") " +
                            item.nombres +
                            " " +
                            item.apellidopat +
                            " " +
                            item.apellidomat,
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
});
