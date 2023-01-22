<script>
    var current_display = null;
    get_suggestion();

    function get_suggestion() { 
        $.get("/ajax/smash/get_suggestion.php", {},
            function (data, textStatus, jqXHR) {
                data = JSON.parse(jqXHR.responseText);
                if(document.readyState == "complete") {
                    display_user(data);
                    return;
                }
                $(document).ready(display_user(data));
            }
        );
    }

    function display_user(data) {
        current_display = data;
        console.log(data);
        if(!data.hasOwnProperty("id")) {
            $("#main-tinder").html("<h2>Du bist fertig</h2><p>Du hast das Hansenbergtinder abgeschlossen</p>")
        }
        $("#tinder-name").text(data["first_name"] + " " + data["last_name"]);
        $("#tinder-name").append('<span class="name-notice" id="tinder-age"></span>')
        $("#tinder-age").text(data["class"]);
        $("#tinder-bio").text(data["bio"]);
    }

    function reroll() {
        get_suggestion();
    }

    function smash() {
        id = current_display["id"];
        $.post("/ajax/smash/add_smash.php", {user: id},
            function (data, textStatus, jqXHR) {
                toast_json_answer(data);
                get_suggestion();
                /*data = JSON.parse(data);
                info = data.info;
                if(!data.hasOwnProperty("error")) {
                    $(".selected-users").append("<div data-id='"+info[2]+"'><span>"+info[0]+" "+info[1]+"</span>" + "<div class='flex-fill'></div>" + "<img src='/images/trash.svg' alt='Remove' height='18px' class='pointer' onclick='remove_smash(\""+info[2]+"\")'></div>")
                    $("#search-user-input").val("");
                }*/
            }
        );
    }


    function pass() {
        id = current_display["id"];
        $.post("/ajax/smash/add_pass.php", {user: id},
            function (data, textStatus, jqXHR) {
                toast_json_answer(data);
                get_suggestion();
            }
        );
    }

</script>
<div class="poll">
    <!-- 
        <div class="title">
            <h1>Hansenberg Tinder</h1>
            <p>Willkommen zum Hansenberg Tinder, gebe an wen du unbedingt schon einmal SMASHEN wolltest YEAH</p>
        </div> 
    -->
    <div class="main-tinder" id="main-tinder">
        <span class="tinder-name" id="tinder-name"> <span class="name-notice" id="tinder-age"></span></span>
        <p class="tinder-bio" id="tinder-bio" style="white-space: pre-line; min-height: 100px">
            
        </p>
        <div class="tinder-buttons">
            <img src="/images/tinder_reroll.png" alt="Next" title="Erhalte einen neuen Vorschlag" onclick="reroll()">
            <img src="/images/tinder_like.png" alt="Like" title="Smash" onclick="smash()">
            <img src="/images/tinder_no.png" alt="Pass" title="Pass" onclick="pass()">
        </div>
    </div>
    <div class="your-list-button">
        <a href="/hub?p=list">Deine Smashs und Passes</a>
    </div>
    <div class="selected-users" style="display: none;">
        <?php
            $sql = "SELECT users.first_name, users.last_name, users.id FROM smash LEFT JOIN users ON users.id & smash.target WHERE users.id = target AND smash.uid = ?";
            $result = prepared_statement_result($sql, $con, true, "s", $uid);
            foreach(get_multiple_database_entries_result($result, ["first_name", "last_name", "id"]) as $c) {
                echo "<div data-id='".$c[2]."'><span>".$c[0]." ".$c[1]."</span>" . "<div class='flex-fill'></div>" . "<img src='/images/trash.svg' alt='Remove' height='18px' class='pointer' onclick='remove_smash(\"".$c[2]."\")'></div>";
            }
        ?>
    </div>
</div>