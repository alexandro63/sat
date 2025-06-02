$(document).ready(function () {
    var metodologiaTable = $("#metodologia_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "metodologias",
            type: "GET",
        },
        columns: [
            { data: "nombre" },
            { data: "descripcion" },
            { data: "objetivos" },
            { data: "numero_modulos" },
            { data: "fecha_inicio" },
            { data: "fecha_finalizacion" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm("form#add_metodologia", "div.modal_metodologia", metodologiaTable);

    updateAjaxForm(
        "form#edit_metodologia",
        "button.edit_metodologia",
        "div.modal_metodologia",
        metodologiaTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_metodologia",
        table: metodologiaTable,
    });
});
