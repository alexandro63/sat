$(document).ready(function () {
    $('.form-check-input').on('change', function () {
        let status = $(this).prop('checked');
        let teacherAttendence = $('#teacher_attendence')
        let teacherReplaced = $('#teacher_replaced')
        if (status == true) {
            teacherReplaced.removeClass('d-none')
            teacherAttendence.addClass('d-none')
        }
        if (status == false) {
            teacherAttendence.removeClass('d-none')
            teacherReplaced.addClass('d-none')
        }
    })
});

