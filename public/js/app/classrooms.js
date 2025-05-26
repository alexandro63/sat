$(document).ready(function () {
    var classroomsTable = $("#classrooms_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "classrooms",
            type: "GET",
        },
        columns: [
            { data: "amb_nombre" },
            { data: "amb_capacidad" },
            { data: "amb_piso" },
            { data: "amb_descripcion" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm(
        "form#add_classroom",
        "div.modal_classroom",
        classroomsTable
    );

    updateAjaxForm(
        "form#edit_classroom",
        "button.edit_classroom",
        "div.modal_classroom",
        classroomsTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_classroom",
        table: classroomsTable,
    });
});
