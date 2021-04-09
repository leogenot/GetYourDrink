$(document).ready(function () {
    $('#furniture > td').hide();
    $('thead').hide();
    $('.player-number > div').hide();

});

$(document).on('change', '#number-of-players', function () {

    var selected = $("#number-of-players option:selected");
    if ($(".player-" + selected.val()).length > 0) {
        $(".player-" + selected.val()).prevAll().show();
        $(".player-" + selected.val()).nextAll().hide();
        $(".player-" + selected.val()).show();
        $('thead').show();
    }
    else {
        $('.container > div').show();

    }
});