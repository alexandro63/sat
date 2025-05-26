$(document).ready(function () {
    var otherIncomeTable = $("#other_income_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "other_income",
            type: "GET",
        },
        columns: [
            { data: "documento" },
            { data: "persona" },
            { data: "pag_fec_hor" },
            { data: "pag_monto" },
            { data: "pag_rof" },
            { data: "usuario" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm("form#add_other_income", "div.modal_other_income", otherIncomeTable);

    updateAjaxForm(
        "form#edit_other_income",
        "button.edit_other_income",
        "div.modal_other_income",
        otherIncomeTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_other_income",
        table: otherIncomeTable,
    });

    $("div.modal_other_income").on("show.bs.modal", function () {
        $("#pag_alu_id").select2({
            dropdownParent: $("div.modal_other_income"),
            width: "100%",
            placeholder: LANG.select,
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: "/registration/get-students",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: (params) => ({
                    term: params.term,
                    page: params.page || 1,
                }),
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    const formatted = data.data.map((item) => ({
                        id: item.alu_id,
                        text:
                            "( C.I. " +
                            item.people.per_ci +
                            ") " +
                            item.people.per_nombres +
                            " " +
                            item.people.per_apellidopat +
                            " " +
                            item.people.per_apellidomat,
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
    });
});
