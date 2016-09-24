$(function () {
    $("#adminmenu").addClass("inactive");
    $("#adminmenu .layer").bind("click", function () {
        if ($("#adminmenu").hasClass("inactive")) {
            $("#adminmenu").animate({bottom: "+=50"}, 500, function () {
                $(this).removeClass("inactive");
            });
        } else {
            $("#adminmenu").animate({bottom: "-=50"}, 500, function () {
                $(this).addClass("inactive");
            });
        }
    })
})