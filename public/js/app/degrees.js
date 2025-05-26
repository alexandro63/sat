$(document).ready(function () {
    var degreesTable = $("#degrees_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "degrees",
            type: "GET",
        },
        columns: [
            { data: "car_nombre" },
            { data: "car_descripcion" },
            { data: "car_duracion" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm("form#add_degree", "div.modal_degree", degreesTable);

    updateAjaxForm(
        "form#edit_degree",
        "button.edit_degree",
        "div.modal_degree",
        degreesTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_degree",
        table: degreesTable,
    });
});
