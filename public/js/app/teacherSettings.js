$(document).ready(function () {
    var teacherSettingsTable = $("#teacher_settings_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "teacher_settings",
            type: "GET",
        },
        columns: [
            { data: "user_name" },
            { data: "per_id" },
            { data: "status" },
            { data: "action", orderable: false, searchable: false },
        ],
    });
    registerAjaxForm("form#add_teacher_setting", "div.modal_teacher_setting", teacherSettingsTable);

    updateAjaxForm(
        "form#edit_teacher_setting",
        "button.edit_teacher_setting",
        "div.modal_teacher_setting",
        teacherSettingsTable
    );

    deleteAjaxConfirmation({
        selector: "button.delete_teacher_setting",
        table: teacherSettingsTable,
    });

    /*  $("div.modal_teacher_settingS").on("show.bs.modal", function () {
          $("#per_id").select2({
              dropdownParent: $("div.modal_teacher_settingS"),
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
                              item.per_apellidopat,
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
      */
});
