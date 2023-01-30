<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/no_account_kick.php" ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/head_standard.php" ?>
    <link rel="stylesheet" href="/hub/hub.css">
    <title>Wilkommen</title>

    <?php

    $has_welcome = get_database_entry_result(prepared_statement_result("SELECT has_welcome FROM users WHERE id = ?", $con, true, "s", $uid), "has_welcome");
    if($has_welcome == "1") {
        echo "<script>window.location.href = '/hub'</script>";
        return;
    }

    ?>
    <script>
        $(document).ready(function () {
            type_text = "Hansenberg Tinder"
            for(i = 0; i < 18; i++) {
                setTimeout(animation_1, 100+100*i, "#h1-title-1", type_text, i);
            }

            $("#start-tour").click(function() {
                console.log("test");
                $("#h1-title-1-parent").css("transition", "1s");
                $("#h1-title-1").css("transition", "1s");
                $("#welcome-1-body").css("overflow", "hidden");
                $("#welcome-1-body").css("white-space", "nowrap");
                $("#welcome-1").width($("#welcome-1").width())
                $("#welcome-1-body").animate({"margin-left": "100%", opacity: 0}, 1000);
                setTimeout(function() {
                    $("#welcome-1").height($("#welcome-1").height())
                    $("#welcome-1-body").remove();
                    $("#welcome-1-body-2").show();
                    $("#welcome-1-body-2").animate({opacity: 1}, 700);
                }, 1000)
            })

            $("#next-1").click(function() {
                $("#welcome-1").fadeOut("slow");
                $("#welcome-2").css("display", "flex");
                $("#welcome-2").css("opacity", 0);
                setTimeout(function() {$("#welcome-2").animate({"opacity": 1}, 600)}, 600);
                setTimeout(function() {$("#tutorial-video")[0].play()}, 1200);
            });

            $("#next-2").click(function() {
                $("#welcome-2").fadeOut("slow");
                $("#welcome-3").css("display", "block");
                $("#welcome-3").css("opacity", 0);
                setTimeout(function() {$("#welcome-3").animate({"opacity": 1}, 600)}, 600);
                type_text = "Ein letzter Schritt"
                for(i = 0; i < 19; i++) {
                    setTimeout(animation_2, 100+100*i, "#one-last-step", type_text, i);
                }
            });

            password_shown = false;
            $("#toggle-password").click(function() {
                if(password_shown) {
                    $(this).attr("src", "/images/eye.svg");
                    $(this).parent().children("input").attr("type", "password");
                } else {
                    $(this).attr("src", "/images/eye-off.svg");
                    $(this).parent().children("input").attr("type", "text");
                }

                password_shown = !password_shown;
            });

            password_shown_2 = false;
            $("#toggle-password-2").click(function() {
                if(password_shown_2) {
                    $(this).attr("src", "/images/eye.svg");
                    $(this).parent().children("input").attr("type", "password");
                } else {
                    $(this).attr("src", "/images/eye-off.svg");
                    $(this).parent().children("input").attr("type", "text");
                }

                password_shown_2 = !password_shown_2;
            });
        });
        function animation_1(id, type_text, i) {
            $(id).append(type_text[i]);
            if(i == 17) {
                setTimeout(function() {$("#p-animation-1").slideDown(600);}, 100);
                setTimeout(function() {$("#p-animation-2").slideDown(600);}, 1500);
                setTimeout(function() {$("#start-tour").animate({opacity: 1}, 2000)}, 2200);
            }
        }
        function animation_2(id, type_text, i) {
            $(id).append(type_text[i]);
            if(i == 18) {
                type_text = "Ändere dein Passwort um loszulegen!"
                for(i = 0; i < 35; i++) {
                    setTimeout(animation_3, 100+100*i, "#one-last-step-2", type_text, i);
                }
            }
        }

        function animation_3(id, type_text, i) {
            $(id).append(type_text[i]);
        }

        function save_password(e) {
            $.post("/ajax/account/change_password.php", {new_password: $("#password-input").val(), confirm_password: $("#password-input-repeat").val()},
                function (data, textStatus, jqXHR) {
                    if(!JSON.parse(jqXHR.responseText).hasOwnProperty("error")) {
                        setTimeout(function() {window.location.href = "/hub"}, 500);
                    }
                    toast_json_answer(data);
                }
            );
            return false;
        }

    </script>
</head>

<body>

    <div class="main">
        <div id="welcome-1">
            <span id="h1-title-1-parent"><h1 id="h1-title-1" style="margin: 0;"></h1></span>
            <div id="welcome-1-body">
                <p  id="p-animation-1" style="display: none; margin-bottom: 0">Willkommen beim Hansenberg Tinder <?php $name = get_database_entry_result(prepared_statement_result('SELECT CONCAT(CONCAT(first_name, " "), last_name) AS full_name FROM users WHERE id = ?', $con, true, "s", $uid), "full_name"); echo htmlspecialchars(strlen($name) > 3 ? $name : get_database_entry_result(prepared_statement_result("SELECT username FROM users WHERE id = ?", $con, true, "s", $uid), "username")) ?></p>
                <p  id="p-animation-2" style="display: none; margin: 0">Lass uns eine kleine Tour nehmen</p>
                <div style="display: flex; justify-content: center">
                    <button id="start-tour" class="submit-button" style="opacity: 0">Starten</button>
                </div>
            </div>
            <div id="welcome-1-body-2" style="display: none; opacity: 0;">
                <p id="p-animation-3">Es ist ganz einfach, wie bei Tinder kriegst du Vorschläge die du als SMASH oder PASS markieren kannst</p>
                <div style="display: flex; justify-content: center">
                    <button id="next-1" class="submit-button" style="margin-top: 0">Nächstes</button>
                </div>
            </div>
        </div>
        <div id="welcome-2" style="display: none; transition: 5s; justify-content: center; align-items: center;">
            <div class="flex-fill"></div>
            <video id="tutorial-video" src="/images/Tinder_Tutorial.mp4?ngsw-bypass=true " style="max-height: 100vh; max-width: 100vw;" type="video/mp4" muted playsInline></video>
            <button id="next-2" class="submit-button" style="height: 50px; width: 50px; border-radius: 50px;">➜</button>
        </div>
        <div id="welcome-3" style="display: none;">
            <h1 id="one-last-step"></h1>
            <p id="one-last-step-2" class="grey-text"></p>
            <form action="" onsubmit="return save_password(event)">
                <div class="input-group" style="width: 250px">
                    <div class="input-group-item">
                        <div class="input-container">
                            <img src="/images/key.svg" class="icon" alt="">
                            <input class="noinput" id="password-input" type="password" placeholder="Passwort">
                            <img src="/images/eye.svg" class="eye" id="toggle-password"> 
                        </div>
                    </div>
                </div>
                <div class="input-group" style="width: 250px">
                    <div class="input-group-item">
                        <div class="input-container">
                            <img src="/images/key.svg" class="icon" alt="">
                            <input class="noinput" id="password-input-repeat" type="password" placeholder="Passwort wiederholen">
                            <img src="/images/eye.svg" class="eye" id="toggle-password-2"> 
                        </div>
                    </div>
                </div>
                <button class="submit-button" style="margin-top: 10px">Speichern</button>
            </form>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/snackbar.php" ?>
</body>
</html>