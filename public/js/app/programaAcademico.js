$(document).ready(function () {
    var programaAcademicoTable = $("#programa_academico_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "programa-academico",
            type: "GET",
        },
        columns: [
            { data: "codigo" },
            { data: "nombre_programa" },
            { data: "modalidad" },
            { data: "facultad" },
            { data: "nivel" },
            { data: "estado" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm("form#add_programa_academico", "div.modal_programa_academico", programaAcademicoTable);

    updateAjaxForm(
        "form#edit_programa_academico",
        "button.edit_programa_academico",
        "div.modal_programa_academico",
        programaAcademicoTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_programa_academico",
        table: programaAcademicoTable,
    });
});
