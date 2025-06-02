$(document).ready(function () {
    var pagoTable = $("#pago_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "pagos",
            type: "GET",
        },
        columns: [
            { data: "estudiante" },
            { data: "monto" },
            { data: "metodo" },
            { data: "fecha" },
            { data: "action", orderable: false, searchable: false },
        ],
    });

    $(document).on("submit", "form#add_pago", function (e) {
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
                $grp.removeClass("has-error").find(".help-block").hide();
            }
        });

        if (!valid) {
            notify("warning", "Por favor, llene los campos requeridos.");
            return;
        }

        $.ajax({
            type: "POST",
            url: $form.attr("action"),
            data: new FormData($form[0]),
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                __disable_submit_button($form.find('button[type="submit"]'));
            },
            success: function (res) {
                if (res.success) {
                    $("div.modal_pago").modal("hide");
                    $form.find('button[type="submit"]').attr("disabled", false);
                    $form[0].reset();
                    notify("success", res.msg);
                    pagoTable.ajax.reload();
                } else {
                    notify("danger", res.msg);
                }
            },
            error: function (xhr) {
                var listMsg =
                    "<strong>Corrige los siguientes campos:</strong><ul>";
                var errors = xhr.responseJSON.errors;
                var $submitBtn = $form.find('button[type="submit"]');
                $submitBtn.removeAttr("disabled");
                $submitBtn.html("Guardar");
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

    $(document).on("click", "button.edit_pago", function () {
        $("div.modal_pago").load($(this).data("href"), function () {
            $(this).modal("show");

            $("form#edit_pago").submit(function (e) {
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
                    data: new FormData($form[0]),
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        __disable_submit_button(
                            $form.find('button[type="submit"]')
                        );
                    },
                    success: function (res) {
                        if (res.success) {
                            $("div.modal_pago").modal("hide");
                            notify("success", res.msg);
                            pagoTable.ajax.reload();
                        } else {
                            notify("error", res.msg);
                        }
                    },
                    error: function (xhr) {
                        var listMsg =
                            "<strong>Corrige los siguientes campos:</strong><ul>";
                        var errors = xhr.responseJSON.errors;
                        var $submitBtn = $form.find('button[type="submit"]');
                        $submitBtn.removeAttr("disabled");
                        $submitBtn.html("Guardar");
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

    deleteAjaxConfirmation({
        selector: "button.delete_pago",
        table: pagoTable,
    });

    $("div.modal_pago").on("shown.bs.modal", function () {
        const id_estudiante = $("#id_estudiante");
        if (!id_estudiante.hasClass("select2-hidden-accessible")) {
            id_estudiante.select2({
                dropdownParent: $("div.modal_pago"),
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
});
