$(document).ready(function () {
    var subjectsTable = $("#subjects_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "subjects",
            type: "GET",
        },
        columns: [
            { data: "car_nombre" },
            { data: "mat_nombre" },
            { data: "mat_descripcion" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm("form#add_subject", "div.modal_subject", subjectsTable);

    updateAjaxForm(
        "form#edit_subject",
        "button.edit_subject",
        "div.modal_subject",
        subjectsTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_subject",
        table: subjectsTable,
    });

    $("div.modal_subject").on("show.bs.modal", function () {
        const $select = $("#mat_car_id");

        if (!$select.hasClass("select2-hidden-accessible")) {
            $select.select2({
                dropdownParent: $("div.modal_subject"),
                width: "100%",
                placeholder: LANG.select,
                allowClear: true,
                minimumInputLength: 1,
                ajax: {
                    url: "/registration/get-degrees",
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
                            id: item.car_id,
                            text: item.car_nombre,
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
