$(document).ready(function () {
    var adminsitrativeTable = $("#administrative_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "administrative",
            type: "GET",
        },
        columns: [
            { data: "documento" },
            { data: "administrativo" },
            { data: "adm_cargo" },
            { data: "estado" },
            { data: "adm_fec_ini" },
            { data: "adm_fec_fin" },
            { data: "action", orderable: false, searchable: false },
        ],
    });

    registerAjaxForm("form#add_administrative", "div.modal_administrative", adminsitrativeTable, true);

    updateAjaxForm(
        "form#edit_administrative",
        "button.edit_administrative",
        "div.modal_administrative",
        adminsitrativeTable,
        true
    );

    deleteAjaxConfirmation({
        selector: "button.delete_administrative",
        table: adminsitrativeTable,
    });

    stepFormModal("div.modal_administrative");

    schedule("div.modal_administrative");

    $("div.modal_administrative").on("show.bs.modal", function () {
        $("#adm_per_id").select2({
            dropdownParent: $("div.modal_administrative"),
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
                        text:
                            "( C.I. " +
                            item.per_ci +
                            ") " +
                            item.per_nombres +
                            " " +
                            item.per_apellidopat +
                            " " +
                            item.per_apellidomat,
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
