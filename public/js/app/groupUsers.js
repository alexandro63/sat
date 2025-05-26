$(document).ready(function () {
    var groupUserTable = $("#group_user_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "group_users",
            type: "GET",
        },
        columns: [
            { data: "gru_nombre" },
            { data: "gru_obs" },
            { data: "gru_estado" },
            { data: "action", orderable: false, searchable: false },
        ],
    });

    registerAjaxForm(
        "form#add_group_user",
        "div.modal_group_user",
        groupUserTable
    );

    updateAjaxForm(
        "form#edit_group_user",
        "button.edit_group_user",
        "div.modal_group_user",
        groupUserTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_group_user",
        table: groupUserTable,
    });
});
