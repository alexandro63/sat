$(document).ready(function () {
    /**SIDEBAR */
    if (
        !localStorage.getItem("sidebar_minimize") ||
        localStorage.getItem("sidebar_minimize") === "false"
    ) {
        $(".wrapper").removeClass("sidebar_minimize");
        $(".toggle-sidebar")
            .removeClass("toggled")
            .html('<i class="icon-menu"></i>');
    } else {
        // Si se guardó como minimizado, mantenerlo minimizado
        $(".wrapper").addClass("sidebar_minimize");
        $(".toggle-sidebar")
            .addClass("toggled")
            .html('<i class="icon-options-vertical"></i>');
    }

    // Manejo del click en el botón de toggle del sidebar
    $(".toggle-sidebar").on("click", function () {
        setTimeout(function () {
            if ($(".wrapper").hasClass("sidebar_minimize")) {
                localStorage.setItem("sidebar_minimize", "true");
            } else {
                localStorage.setItem("sidebar_minimize", "false");
            }
        }, 300);
    });


    /**COLLAPSE SUBMENU */
    $(".nav-itemm")
        .has(".collapse")
        .each(function () {
            var $item = $(this);
            var $toggle = $item.find('[data-toggle="collapse"]').first();
            var target = $toggle.attr("href");
            var $menu = $(target);

            // Cuando el ratón entra en el li.nav-item...
            $item.on("mouseenter", function () {
                // Abrimos el collapse
                $menu.collapse("show");
                // Ajustamos clases/atributos ARIA
                $toggle.removeClass("collapsed").attr("aria-expanded", "true");
            });

            // Cuando el ratón sale del li.nav-item...
            $item.on("mouseleave", function () {
                // Cerramos el collapse
                $menu.collapse("hide");
                // Ajustamos clases/atributos ARIA
                $toggle.addClass("collapsed").attr("aria-expanded", "false");
            });
        });

    /**PERMIT DATA INPUT IN NUMBER */
    $(document).on("input", ".input-number", function () {
        let value = $(this).val();
        value = value.replace(/[^0-9.]/g, "");
        const parts = value.split(".");
        if (parts.length > 2) {
            value = parts[0] + "." + parts.slice(1).join("");
        }
        $(this).val(value);
    });

    /**OPEN MODAL FROM BACKEND */
    $(document).on("click", ".btn-modal", function (e) {
        e.preventDefault();
        var container = $(this).data("container");

        $.ajax({
            url: $(this).data("href"),
            dataType: "html",
            success: function (result) {
                $(container).html(result).modal("show");
            },
        });
    });

    /**AUTOFOCUS MODAL */
    $(".modal").on("shown.bs.modal", function () {
        $(this).find("input[autofocus]").focus();
    });

    /**SELECT2 INITIALIZE MODAL */
    // $(document).on("shown.bs.modal", ".modal", function () {
    //     const modal = $(this);
    //     const select2Elements = modal.find(".select2");

    //     select2Elements.each(function () {
    //         const $select = $(this);
    //         if (!$select.hasClass("select2-hidden-accessible")) {
    //             const optionCount = $select.find("option").length;

    //             $select.select2({
    //                 width: "100%",
    //                 dropdownParent: modal,
    //                 minimumResultsForSearch: optionCount > 10 ? 0 : Infinity,
    //             });
    //         }
    //     });
    // });

    /**NOTIFICATION  */
    if ($('#status_span').length) {
        let status = $('#status_span').attr('data-status'),
            msg = $('#status_span').attr('data-msg');

        if (status === '1') {
            notify('success', msg);
        } else if (status === '0' || status === '') {
            notify('danger', msg);
        }
    }
});
