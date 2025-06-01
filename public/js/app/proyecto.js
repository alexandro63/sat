$(document).ready(function () {
    var proyectoTable = $("#proyecto_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "proyectos",
            type: "GET",
        },
        columns: [
            { data: "docente_guia" },
            { data: "docente_revisor" },
            { data: "estudiante" },
            { data: "titulo" },
            { data: "linea_investigacion" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm("form#add_proyecto", "div.modal_proyecto", proyectoTable);

    updateAjaxForm(
        "form#edit_proyecto",
        "button.edit_proyecto",
        "div.modal_proyecto",
        proyectoTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_proyecto",
        table: proyectoTable,
    });

    $("div.modal_proyecto").on("shown.bs.modal", function () {
        const id_docente_guia = $("#id_docente_guia");
        const id_docente_revisor = $("#id_docente_revisor");
        const id_estudiante = $("#id_estudiante");
        if (!id_docente_guia.hasClass("select2-hidden-accessible")) {
            id_docente_guia.select2({
                dropdownParent: $("div.modal_proyecto"),
                width: "100%",
                placeholder: LANG.select,
                allowClear: true,
                minimumInputLength: 1,
                ajax: {
                    url: "/registros/get-docentes",
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

            const currentId = id_docente_guia.val();
            const currentText = id_docente_guia.find("option:selected").text();
            if (currentId && currentText) {
                const newOption = new Option(
                    currentText,
                    currentId,
                    true,
                    true
                );
                id_docente_guia.append(newOption).trigger("change");
            }
        }
        if (!id_docente_revisor.hasClass("select2-hidden-accessible")) {
            id_docente_revisor.select2({
                dropdownParent: $("div.modal_proyecto"),
                width: "100%",
                placeholder: LANG.select,
                allowClear: true,
                minimumInputLength: 1,
                ajax: {
                    url: "/registros/get-docentes",
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

            const currentId = id_docente_revisor.val();
            const currentText = id_docente_revisor.find("option:selected").text();
            if (currentId && currentText) {
                const newOption = new Option(
                    currentText,
                    currentId,
                    true,
                    true
                );
                id_docente_revisor.append(newOption).trigger("change");
            }
        }
        if (!id_estudiante.hasClass("select2-hidden-accessible")) {
            id_estudiante.select2({
                dropdownParent: $("div.modal_proyecto"),
                width: "100%",
                placeholder: LANG.select,
                allowClear: true,
                minimumInputLength: 1,
                ajax: {
                    url: "/registros/get-estudiantes",
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

            const currentId = id_estudiante.val();
            const currentText = id_estudiante.find("option:selected").text();
            if (currentId && currentText) {
                const newOption = new Option(
                    currentText,
                    currentId,
                    true,
                    true
                );
                id_estudiante.append(newOption).trigger("change");
            }
        }

    });
});
