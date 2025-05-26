/**DISABLED BUTTON SUBMIT */
function __disable_submit_button(element) {
    element.attr("disabled", "disabled");
    element.html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...'
    );
}

/**NOTIFICATION */
function notify(type = "default", message, timer) {
    const defaults = {
        success: "Éxito",
        danger: "Error",
        warning: "Advertencia",
        info: "Información",
        default: "Notificación",
    };

    const iconMap = {
        success: "fa fa-check",
        danger: "fa fa-times",
        warning: "fa fa-exclamation",
        info: "fa fa-info-circle",
        default: "fa fa-bell",
    };

    const state = type.toLowerCase();
    const title = defaults[state] || defaults.default;
    const icon = iconMap[state] || iconMap.default;

    $.notify(
        {
            title: title,
            message: message,
            icon: icon,
        },
        {
            type: state,
            allow_dismiss: false,
            newest_on_top: true,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right",
            },
            delay: 1000,
            timer: timer ?? 1000,
        }
    );
}

/**CREATE REGISTER IN MODAL */
function registerAjaxForm(
    formSelector,
    modalSelector,
    table,
    sheduleJson = false
) {
    $(document).on("submit", formSelector, function (e) {
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

        if (sheduleJson) {
            const jsonToStore = generateScheduleJson();
            $("#schedules_json").val(jsonToStore);
        }

        $.ajax({
            type: "POST",
            url: $form.attr("action"),
            data: $form.serialize(),
            dataType: "json",
            beforeSend: function () {
                __disable_submit_button($form.find('button[type="submit"]'));
            },
            success: function (res) {
                if (res.success) {
                    if (modalSelector) {
                        $(modalSelector).modal("hide");
                    }
                    $form.find('button[type="submit"]').attr("disabled", false);
                    $form[0].reset();
                    notify("success", res.msg);
                    table.ajax.reload();
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
}
/**EDIT REGISTER IN MODAL */
function updateAjaxForm(
    formSelector,
    buttonSelector,
    modalSelector,
    table,
    sheduleJson = false
) {
    $(document).on("click", buttonSelector, function () {
        $(modalSelector).load($(this).data("href"), function () {
            $(this).modal("show");

            $(formSelector).submit(function (e) {
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

                if (sheduleJson) {
                    const jsonToStore = generateScheduleJson();
                    $("#schedules_json").val(jsonToStore);
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
                            $(modalSelector).modal("hide");
                            notify("success", res.msg);
                            table.ajax.reload();
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
}

/**SHOW DATA MODAL */
function showAjaxData(modalSelector)
{

}

/**DELETED REGISTER ALERT*/
function deleteAjaxConfirmation({ selector, table = null }) {
    $(document).on("click", selector, function () {
        const $button = $(this);
        swal({
            title: LANG.sure_deleted,
            text: LANG.text_deleted,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                const href = $button.data("href");
                const data = $button.serialize();

                $.ajax({
                    method: "DELETE",
                    url: href,
                    dataType: "json",
                    data: data,
                    success: function (result) {
                        if (result.success === true) {
                            notify("success", result.msg);
                            if (table) {
                                table.ajax.reload();
                            }
                        } else {
                            notify("danger", result.msg);
                        }
                    },
                });
            }
        });
    });
}

/**STEP FORM MODAL */
function stepFormModal(modalSelector) {
    $(modalSelector).on("shown.bs.modal", function () {
        const $steps = $(".step"),
            total = $steps.length;
        let current = 1;

        function showStep(n) {
            $steps.hide();
            $steps.filter(`[data-step="${n}"]`).show();
            const pct = Math.round((n / total) * 100);
            $(".progress-bar")
                .css("width", pct + "%")
                .attr("aria-valuenow", pct);
            $("#step-indicator").text(`Paso ${n} de ${total}`);
            $("#prevBtn").toggle(n > 1);
            $("#nextBtn").toggle(n < total);
            $("#submitBtn").toggle(n === total);
        }

        function handleKeydown(e) {
            if (e.key === "ArrowRight" && current < total) {
                current++;
                showStep(current);
            } else if (e.key === "ArrowLeft" && current > 1) {
                current--;
                showStep(current);
            } else if (e.key === "Enter" && current === total) {
                $("#submitBtn").click();
            }
        }

        // Manejar clics
        $("#nextBtn").click(function () {
            if (current < total) {
                current++;
                showStep(current);
            }
        });

        $("#prevBtn").click(function () {
            if (current > 1) {
                current--;
                showStep(current);
            }
        });

        current = 1;
        showStep(current);
        $(document).on("keydown", handleKeydown);

        $(modalSelector).on("hide.bs.modal", function () {
            $(document).off("keydown", handleKeydown);
        });
    });
}

/**SCHEDULE */
function schedule(modalSelector) {
    $(modalSelector).on("show.bs.modal", function () {
        // Checkbox "Todos"
        $(".form-check-input").on("change", function () {
            const selectedValue = $(this).val().toLowerCase();
            const isChecked = $(this).prop("checked");

            if (selectedValue === "todos") {
                $(".form-check-input").each(function () {
                    const dayValue = $(this).val().toLowerCase();
                    if (dayValue === "todos") return;
                    if (isChecked) {
                        $(this).prop("checked", dayValue !== "domingo");
                    } else {
                        $(this).prop("checked", false);
                    }
                });
            } else {
                if (!isChecked) {
                    $('.form-check-input[value="todos"]').prop(
                        "checked",
                        false
                    );
                }
            }
        });

        generateScheduleRanges();

        $("#btnAdd").on("click", function () {
            const days = $(".day-checkbox:checked");
            const scheduleStart = $("#scheduleStart").val();
            const scheduleEnd = $("#scheduleEnd").val();

            if (days.length === 0 || !scheduleStart || !scheduleEnd) {
                swal({
                    title: LANG.ops,
                    text: LANG.text_selected_range,
                    icon: "error",
                });
                return;
            }

            days.each(function () {
                const day = $(this).val();
                let dayExist = false;

                $("#tableSchedule tbody tr").each(function () {
                    const dayInt = $(this).find("td:first").text().trim();
                    if (dayInt === day) {
                        dayExist = true;
                        return false;
                    }
                });

                if (!dayExist && day !== "todos") {
                    const row = `
                <tr>
                    <td>${day}</td>
                    <td>${scheduleStart}</td>
                    <td>${scheduleEnd}</td>
                    <td><button class="btn btn-xs btn-danger btnDeleted" title="Eliminar"> <i class="icon-trash"></i></button></td>
                </tr>`;
                    $("#tableSchedule tbody").append(row);
                }
            });
        });

        $("#tableSchedule").on("click", ".btnDeleted", function () {
            $(this).closest("tr").remove();
        });

        $("#btnClear").click(function () {
            $(".day-checkbox").prop("checked", false);
            $("#tableSchedule tbody").empty();
        });
    });
}
/**RANGE HOUR */
function generateScheduleRanges() {
    const $start = $("#scheduleStart").select2({
        minimumResultsForSearch: Infinity,
        width: "100%",
    });
    const $end = $("#scheduleEnd").select2({
        minimumResultsForSearch: Infinity,
        width: "100%",
    });

    // Limpiamos los selects
    $start.empty().append('<option value="">00:00</option>');
    $end.empty().append('<option value="">00:00</option>');

    // Generar opciones desde 06:00 hasta 22:00 cada 15 minutos
    for (let h = 6; h <= 22; h++) {
        for (let m of [0, 15, 30, 45]) {
            if (h === 22 && m > 0) break; // Último horario permitido es 22:00

            const hour = `${h.toString().padStart(2, "0")}:${m
                .toString()
                .padStart(2, "0")}`;
            $start.append(`<option value="${hour}">${hour}</option>`);
            $end.append(`<option value="${hour}">${hour}</option>`);
        }
    }

    // Escuchar el cambio en horario de inicio
    $start.on("change", function () {
        const start = $(this).val();
        if (!start) {
            $end.val(""); // Limpiar si no se selecciona nada
            return;
        }

        // Calcular una hora después
        const [h, m] = start.split(":").map(Number);
        let date = new Date();
        date.setHours(h);
        date.setMinutes(m + 60);

        // Redondear en bloques de 15 minutos si es necesario
        const hourFinal = date.getHours().toString().padStart(2, "0");
        const minEnd = date.getMinutes().toString().padStart(2, "0");
        const hourEnd = `${hourFinal}:${minEnd}`;

        // Solo seleccionar automáticamente si la hora está en el rango
        if ($end.find(`option[value="${hourEnd}"]`).length > 0) {
            $end.val(hourEnd).trigger("change");
        } else {
            $end.val("").trigger("change");
        }
    });
}
/**SHEDULE JSON GENERATE */
function generateScheduleJson() {
    const scheduleJson = {};

    $("#tableSchedule tbody tr").each(function () {
        const day = $(this).find("td:eq(0)").text().toLowerCase();
        const hourStart = $(this).find("td:eq(1)").text();
        const hourEnd = $(this).find("td:eq(2)").text();

        scheduleJson[day] = {
            hourStart: hourStart,
            hourEnd: hourEnd,
        };
    });

    return JSON.stringify(scheduleJson);
}
