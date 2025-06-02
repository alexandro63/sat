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
            { data: "area_conocimiento" },
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

    $(document).on("click", "button.revision_proyecto", function () {
        $("div.modal_proyecto").load($(this).data("href"), function () {
            $(this).modal("show");

            $("form#revision_proyecto").submit(function (e) {
                e.preventDefault();
                var $form = $(this),
                    valid = true;

                $form
                    .find(".form-group.required")
                    .removeClass("has-error")
                    .find(".help-block")
                    .hide();

                $form.find(".required :input").each(function () {
                    const $input = $(this);
                    const tag = $input.prop("tagName").toLowerCase();
                    const type = $input.attr("type");

                    let value = $input.val();
                    let inputValid = true;

                    if (Array.isArray(value)) {
                        value = value.length ? value.join(",") : "";
                    }

                    if (tag === "select") {
                        if (!value || value === "") {
                            inputValid = false;
                        }
                    } else if (
                        type === "text" ||
                        type === "date" ||
                        type === undefined
                    ) {
                        if (!value || value.toString().trim() === "") {
                            inputValid = false;
                        }
                    }

                    const $grp = $input.closest(".form-group");
                    if (!inputValid) {
                        $grp.addClass("has-error").find(".help-block").show();
                        valid = false;
                    } else {
                        $grp.removeClass("has-error")
                            .find(".help-block")
                            .hide();
                    }
                });

                if (!valid) {
                    notify(
                        "warning",
                        "Por favor, llene los campos requeridos."
                    );
                    return;
                }

                $.ajax({
                    method: "POST",
                    url: $(this).attr("action"),
                    dataType: "json",
                    data: $form.serialize(),
                    beforeSend: function () {
                        __disable_submit_button(
                            $form.find('button[type="submit"]')
                        );
                    },
                    success: function (res) {
                        if (res.success) {
                            $("div.modal_proyecto").modal("hide");
                            notify("success", res.msg);
                            proyectoTable.ajax.reload();
                        } else {
                            notify("error", res.msg);
                        }
                    },
                    error: function (xhr) {
                        var listMsg =
                            "<strong>Corrige los siguientes campos:</strong><ul>";
                        var errors = xhr.responseJSON.errors;
                        console.log(errors)
                        var $submitBtn = $form.find('button[type="submit"]');
                        $submitBtn.removeAttr("disabled");
                        $submitBtn.html("Actualizar");
                        $form
                            .find(".form-group")
                            .removeClass("has-error")
                            .find(".help-block");
                        $.each(errors, function (field, messages) {
                            var $field = $form.find('[name="' + field + '"]');

                            $field
                                .closest(".form-group")
                                .addClass("has-error")
                                .find(".help-block")
                                .show();

                            listMsg += `<li>${messages}</li>`;
                        });
                        listMsg += "</ul>";
                        notify("warning", listMsg, 2000);
                    },
                });
            });
        });
    });

     $(document).on("click", "button.view_proyecto", function () {
        $("div.modal_proyecto").load($(this).data("href"), function () {
            $(this).modal("show");
        });
    });
});
