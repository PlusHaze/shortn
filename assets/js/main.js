$(function() {
    refreshStatistics();
    initializeAlertEvents();
});

function refreshStatistics() {

    $.get("api/stats/", function(response) {
        var stats = $.parseJSON(response);

        $("#totalShortened").html(stats["total_shortened"]);
        $("#shortenedToday").html(stats["shortened_today"]);
    });
}

function showAlert(alertId, message) {
    var element = $(alertId);
    element.html(message);

    if (element.parent().hasClass("hidden")) {
        element.parent().removeClass("hidden");
    }

    element.parent().fadeIn(1000);
}

function showSuccessAlert(message) {
    showAlert("#txtSuccess", message);
}

function showErrorAlert(message) {
    showAlert("#txtError", message);
}

function initializeAlertEvents() {

    $(".close").on("click", function(){
        $(this).parent().fadeOut(1000);
    });

    $("form").on("submit", function(e) {
        e.preventDefault();

        var url = $("#inputUrl").val();
        if (url.length == 0) {
            return;
        }

        $(e).addClass("disabled");

        $.post("api/mini/", {longUrl : url}, function(response) {

            $(e).removeClass("disabled");

            try {

                var json = $.parseJSON(response);

                if (json.success) {
                    showSuccessAlert($(location).attr('href') + json.code);
                } else {
                    showErrorAlert(json.message);
                }

            } catch (e) {
                showErrorAlert("An error occurred whilst trying to parse data!");
            }

            refreshStatistics();
        });
    });
}