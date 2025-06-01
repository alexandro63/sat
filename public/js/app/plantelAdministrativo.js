$(document).ready(function () {
    var plantelTable = $("#plantel_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "plantel-administrativo",
            type: "GET",
        },
        columns: [
            { data: "documento" },
            { data: "plantel_administrativo" },
            { data: "cargo" },
            { data: "unidad" },
            { data: "estado" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm("form#add_plantel", "div.modal_plantel", plantelTable);

    updateAjaxForm(
        "form#edit_plantel",
        "button.edit_plantel",
        "div.modal_plantel",
        plantelTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_plantel",
        table: plantelTable,
    });

    $("div.modal_plantel").on("shown.bs.modal", function () {
        const $select = $("#per_id");
        if (!$select.hasClass("select2-hidden-accessible")) {
            $select.select2({
                dropdownParent: $("div.modal_plantel"),
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
