$(document).ready(function () {
    var studentEnrollmentTable = $("#student_enrollment_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "student_enrollments",
            type: "GET",
        },
        columns: [
            { data: "cedula" },
            { data: "alumno" },
            { data: "carrera" },
            { data: "alu_curso" },
            { data: "alu_turno" },
            { data: "alu_con_car" },
            { data: "alu_estado" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm(
        "form#add_student_enrollment",
        "div.modal_student_enrollment",
        studentEnrollmentTable
    );

    updateAjaxForm(
        "form#edit_student_enrollment",
        "button.edit_student_enrollment",
        "div.modal_student_enrollment",
        studentEnrollmentTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_student_enrollment",
        table: studentEnrollmentTable,
    });

    stepFormModal("div.modal_student_enrollment");

    $("div.modal_student_enrollment").on("show.bs.modal", function () {
        $("#alu_per_id").select2({
            dropdownParent: $("div.modal_student_enrollment"),
            width: "100%",
            placeholder: LANG.select,
            allowClear: true,
            minimumInputLength: 2,
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

        $("#alu_car_id").select2({
            dropdownParent: $("div.modal_student_enrollment"),
            width: "100%",
            placeholder: LANG.select,
            allowClear: true,
            minimumInputLength: 2,
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
    });
});
