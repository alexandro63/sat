$(document).ready(function () {
    var moduloTable = $("#modulo_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "modulos",
            type: "GET",
        },
        columns: [
            { data: "codigo" },
            { data: "nombre" },
            { data: "docente" },
            { data: "metodologia" },
            { data: "duracion" },
            { data: "descripcion" },
            { data: "fecha_inicio" },
            { data: "fecha_finalizacion" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm("form#add_modulo", "div.modal_modulo", moduloTable);

    updateAjaxForm(
        "form#edit_modulo",
        "button.edit_modulo",
        "div.modal_modulo",
        moduloTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_modulo",
        table: moduloTable,
    });

    $("div.modal_modulo").on("shown.bs.modal", function () {
        const id_docente = $("#id_docente");
        const id_metodologia = $("#id_metodologia");

        if (!id_docente.hasClass("select2-hidden-accessible")) {
            id_docente.select2({
                dropdownParent: $("div.modal_modulo"),
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
                            text: `(C.I. ${item.persona.carnet}) ${item.persona.nombres} ${item.persona.apellidopat} ${item.persona.apellidomat}`,
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

            const currentId = id_docente.val();
            const currentText = id_docente.find("option:selected").text();
            if (currentId && currentText) {
                const newOption = new Option(
                    currentText,
                    currentId,
                    true,
                    true
                );
                id_docente.append(newOption).trigger("change");
            }
        }

        if (!id_metodologia.hasClass("select2-hidden-accessible")) {
            id_metodologia.select2({
                dropdownParent: $("div.modal_modulo"),
                width: "100%",
                placeholder: LANG.select,
                allowClear: true,
                minimumInputLength: 1,
                ajax: {
                    url: "/registros/get-metodologias",
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
                            text: ` ${item.nombre}`,
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

            const currentId = id_metodologia.val();
            const currentText = id_metodologia.find("option:selected").text();
            if (currentId && currentText) {
                const newOption = new Option(
                    currentText,
                    currentId,
                    true,
                    true
                );
                id_metodologia.append(newOption).trigger("change");
            }
        }

    });
});
