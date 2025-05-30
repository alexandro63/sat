$(document).ready(function () {
    var teachersTable = $("#teachers_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "teachers",
            type: "GET",
        },
        columns: [
            { data: "documento" },
            { data: "docente" },
            { data: "profesion" },
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
        const $select = $("#doc_per_id");

        if (!$select.hasClass("select2-hidden-accessible")) {
            $select.select2({
                dropdownParent: $("div.modal_teacher"),
                width: "100%",
                placeholder: LANG.select,
                allowClear: true,
                minimumInputLength: 1,
                ajax: {
                    url: "/administration/get-people",
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
                            id: item.per_id,
                            text: `(C.I. ${item.per_ci}) ${item.per_nombres} ${item.per_apellidopat} ${item.per_apellidomat}`,
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
