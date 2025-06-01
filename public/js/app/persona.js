$(document).ready(function () {
    var personTable = $("#people_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "personas",
            type: "GET",
        },
        columns: [
            { data: "carnet" },
            { data: "nombres" },
            { data: "apellidopat" },
            { data: "apellidomat" },
            { data: "estado" },
            { data: "action", orderable: false, searchable: false },
        ],
    });

    registerAjaxForm(
        "form#add_person",
        "div.modal_person",
        personTable
    );

    updateAjaxForm(
        "form#edit_person",
        "button.edit_person",
        "div.modal_person",
        personTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_person",
        table: personTable,
    });
});
