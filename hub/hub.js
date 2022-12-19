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

function smash(id) {
    $.post("/ajax/smash/add_smash.php", {user: id},
        function (data, textStatus, jqXHR) {
            toast_json_answer(data);
            data = JSON.parse(data);
            info = data.info;
            if(!data.hasOwnProperty("error")) {
                $(".selected-users").append("<div data-id='"+info[2]+"'><span>"+info[0]+" "+info[1]+"</span>" + "<div class='flex-fill'></div>" + "<img src='/images/trash.svg' alt='Remove' height='18px' class='pointer' onclick='remove_smash(\""+info[2]+"\")'></div>")
                $("#search-user-input").val("");
            }
        }
    );
}

function remove_smash(id) {
    $.post("/ajax/smash/remove_smash.php", {user: id},
        function (data, textStatus, jqXHR) {
            toast_json_answer(data);
            $(".selected-users div[data-id='"+id+"']").remove();
        }
    );
}
