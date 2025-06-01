$(document).ready(function () {
    var teachersTable = $("#teachers_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "docentes",
            type: "GET",
        },
        columns: [
            { data: "numero_item" },
            { data: "documento" },
            { data: "docente" },
            { data: "especialidad" },
            { data: "estado" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm("form#add_teacher", "div.modal_teacher", teachersTable);

    updateAjaxForm(
        "form#edit_teacher",
        "button.edit_teacher",
        "div.modal_teacher",
        teachersTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_teacher",
        table: teachersTable,
    });

    $("div.modal_teacher").on("shown.bs.modal", function () {
        const $select = $("#per_id");

        if (!$select.hasClass("select2-hidden-accessible")) {
            $select.select2({
                dropdownParent: $("div.modal_teacher"),
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
                            text: `(C.I. ${item.carnet}) ${item.nombres} ${item.apellidopat} ${item.apellidomat}`,
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

            const currentId = $select.val();
            const currentText = $select.find("option:selected").text();
            if (currentId && currentText) {
                const newOption = new Option(
                    currentText,
                    currentId,
                    true,
                    true
                );
                $select.append(newOption).trigger("change");
            }
        }
    });
});
