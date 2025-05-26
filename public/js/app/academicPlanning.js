$(document).ready(function () {
    var academicPlanningTable = $("#academic_planning_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "academic_planning",
            type: "GET",
        },
        columns: [
            { data: "materia" },
            { data: "ambiente" },
            { data: "docente" },
            { data: "plan_fec_ini" },
            { data: "plan_fec_fin" },
            { data: "plan_hor_ini" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm(
        "form#add_academic_planning",
        "div.modal_academic_planning",
        academicPlanningTable,
        true
    );

    updateAjaxForm(
        "form#edit_academic_planning",
        "button.edit_academic_planning",
        "div.modal_academic_planning",
        academicPlanningTable,
        true
    );

    deleteAjaxConfirmation({
        selector: "button.delete_academic_planning",
        table: academicPlanningTable,
    });

    stepFormModal("div.modal_academic_planning");

    schedule("div.modal_academic_planning");

    $("div.modal_academic_planning").on("show.bs.modal", function () {
        $("#plan_mat_id").select2({
            dropdownParent: $("div.modal_academic_planning"),
            width: "100%",
            placeholder: LANG.select,
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: "/registration/get-subjects",
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
                        id: item.mat_id,
                        text: item.mat_nombre,
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

        $("#plan_doc_id").select2({
            dropdownParent: $("div.modal_academic_planning"),
            width: "100%",
            placeholder: LANG.select,
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: "/registration/get-teachers",
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
                        id: item.doc_id,
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

        $("#plan_amb_id").select2({
            dropdownParent: $("div.modal_academic_planning"),
            width: "100%",
            placeholder: LANG.select,
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: "/registration/get-classrooms",
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
                        id: item.amb_id,
                        text: item.amb_nombre,
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
