$(document).ready(function () {
    var groupAssignTable = $("#group_assign_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "group_assign",
            type: "GET",
        },
        columns: [
            { data: "gru_nombre" },
            { data: "usuario_info" },
            { data: "action", orderable: false, searchable: false },
        ],
    });

    registerAjaxForm(
        "form#add_group_assign",
        "div.modal_group_assign",
        groupAssignTable
    );

    updateAjaxForm(
        "form#edit_group_assign",
        "button.edit_group_assign",
        "div.modal_group_assign",
        groupAssignTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_group_assign",
        table: groupAssignTable,
    });

    $("div.modal_group_assign").on("show.bs.modal", function () {
        $("#gus_usu_id").select2({
            dropdownParent: $("div.modal_group_assign"),
            width: "100%",
            placeholder: LANG.select,
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: "/administration/get-users",
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
                            "(" +
                            item.user_name +
                            ") " +
                            item.persona_nombre +
                            " " +
                            item.persona_apellidopat +
                            " " +
                            item.persona_apellidomat,
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
        $("#gus_gru_id").select2({
            dropdownParent: $("div.modal_group_assign"),
            width: "100%",
            placeholder: LANG.select,
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: "/administration/get-groups",
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
                        id: item.gru_id,
                        text: item.gru_nombre,
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
