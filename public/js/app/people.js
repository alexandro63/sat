$(document).ready(function () {
    var groupUserTable = $("#people_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "people",
            type: "GET",
        },
        columns: [
            { data: "per_ci" },
            { data: "per_nombres" },
            { data: "per_apellidopat" },
            { data: "per_apellidomat" },
            { data: "per_estado" },
            { data: "action", orderable: false, searchable: false },
        ],
    });

    registerAjaxForm(
        "form#add_person",
        "div.modal_person",
        groupUserTable
    );

    updateAjaxForm(
        "form#edit_person",
        "button.edit_person",
        "div.modal_person",
        groupUserTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_person",
        table: groupUserTable,
    });
});
