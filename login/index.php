<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/has_account_kick.php" ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/head_standard.php" ?>
    <link rel="stylesheet" href="/login/login.css">
    <title>Login</title>

    <script>
        var password_shown = false;

        $(document).ready(function() {
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

            $("#login-form").submit(function() {
                user = $("#user-input").val();
                password = $("#password-input").val();

                $.post("/ajax/account/login.php",
                {
                    username: user,
                    password: password
                },
                function(data, status, jqXHR) {
                    if(!toast_json_answer(data))
                        setTimeout(function() { window.location.href = "/hub" }, 500);
                })
                return false;
            });
            
        })
    </script>
</head>
<body>
    <form id="login-form">
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-image">
                <img src="/images/bjs-custom.svg" alt="Logo" width="100px">
            </div>
            <div class="input-group" style="width: 250px">
                <div class="input-group-item"  style="width: 100%;">
                    <div class="input-container">
                        <img src="/images/user.svg" class="icon" alt="">
                        <input class="noinput" id="user-input" type="text" placeholder="Nutzername" value="<?php if(!empty($_COOKIE["username"])) echo htmlspecialchars($_COOKIE["username"]); ?>">
                    </div>
                </div>
            </div>
            <div class="input-group" style="width: 250px">
                <div class="input-group-item">
                    <div class="input-container">
                        <img src="/images/key.svg" class="icon" alt="">
                        <input class="noinput" id="password-input" type="password" placeholder="Passwort">
                        <img src="/images/eye.svg" class="eye" id="toggle-password"> 
                    </div>
                </div>
            </div>
            <button class="submit-button">Anmelden</button>
        </div>
    </div>
    </form>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/snackbar.php" ?>
</body>
</html>