$(document).ready(function () {
    $('.delete').click(function (e) {
        e.preventDefault();
        $('.confirm').addClass('d-none');
        $(this).parents('.skill_info').children('.confirmation-delete').removeClass('d-none');

    });

    $('.edit').click(function (e) {
        e.preventDefault();
        $('.confirm').addClass('d-none');
        $(this).parents('.skill_info').children('.confirmation-update').removeClass('d-none');

    });

    $('.editLang').click(function (e) {
        e.preventDefault();
        $('.confirm').addClass('d-none');
        $(this).parents('.card-body').children('.confirmation-update').removeClass('d-none');

    });

    $('.cancel').click(function (e) {
        e.preventDefault();
        $(this).parents('.confirm').addClass('d-none');
    });


    $(".nav-link").click(function (e) {
        e.preventDefault();
        $(".nav-link").removeClass('active');
        $(".tab-pane").removeClass('active');
        $(".nav-link").attr('aria-selected', false);

        $(this).addClass('active');
        $(this).attr('aria-selected', true);
        var index = $(this).parent().index() + 1;
        $(".tab-content div:nth-child("+index+")").addClass('active');
    });


});
