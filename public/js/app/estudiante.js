$(document).ready(function () {
    var estudianteTable = $("#estudiante_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "estudiantes",
            type: "GET",
        },
        columns: [
            { data: "estudiante" },
            { data: "programa_academico" },
            { data: "numero_matricula" },
            { data: "fecha_inscripcion" },
            { data: "estado" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm("form#add_estudiante", "div.modal_estudiante", estudianteTable);

    updateAjaxForm(
        "form#edit_estudiante",
        "button.edit_estudiante",
        "div.modal_estudiante",
        estudianteTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_estudiante",
        table: estudianteTable,
    });

    $("div.modal_estudiante").on("shown.bs.modal", function () {
        const per_id = $("#per_id");
        const id_programa_academico = $("#id_programa_academico");
        if (!per_id.hasClass("select2-hidden-accessible")) {
            per_id.select2({
                dropdownParent: $("div.modal_estudiante"),
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

            const currentId = per_id.val();
            const currentText = per_id.find("option:selected").text();
            if (currentId && currentText) {
                const newOption = new Option(
                    currentText,
                    currentId,
                    true,
                    true
                );
                per_id.append(newOption).trigger("change");
            }
        }
        if (!id_programa_academico.hasClass("select2-hidden-accessible")) {
            id_programa_academico.select2({
                dropdownParent: $("div.modal_estudiante"),
                width: "100%",
                placeholder: LANG.select,
                allowClear: true,
                minimumInputLength: 1,
                ajax: {
                    url: "/registros/get-programa-academico",
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
                            text: `(Código. ${item.codigo}) ${item.nombre_programa}`,
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

            const currentId = id_programa_academico.val();
            const currentText = id_programa_academico.find("option:selected").text();
            if (currentId && currentText) {
                const newOption = new Option(
                    currentText,
                    currentId,
                    true,
                    true
                );
                id_programa_academico.append(newOption).trigger("change");
            }
        }
    });
});
