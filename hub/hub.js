$(function () {

    $("#search-user-input").focus(function () { 
        $("#user-search-suggestions").css("display", "block");
    });
    $("#search-user-input").focusout(function () { 
        $("#user-search-suggestions").hide("1000");
    });

    $("#search-user-input").keyup(function() {
        $.get("/ajax/search/search_user_suggestions.php", 
            {
                query: $("#search-user-input").val()
            },
            function (data, textStatus, jqXHR) {
                data = JSON.parse(data);
                if(data.length > 0) {
                    $("#user-search-suggestions").html("");
                    data.forEach(c => {
                        $("#user-search-suggestions").append('<div class="suggestion" onclick="smash('+c["id"]+')"><span class="pointer">'+c["full_name"]+"</span></div>");
                    });
                } else {
                    $("#user-search-suggestions").html("No results");
                }
            }
        );
    })
});