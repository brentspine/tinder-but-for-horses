<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/no_account_kick.php" ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/head_standard.php" ?>
    <link rel="stylesheet" href="/hub/hub.css">
    <title>Hub</title>
</head>
<body>

    <div class="main">
        <div class="header">
            <div class="logged-in">
                Eingeloggt als: <?php echo get_database_entry_result(prepared_statement_result('SELECT CONCAT(CONCAT(first_name, " "), last_name) AS full_name FROM users WHERE id = ?', $con, true, "s", $uid), "full_name") ?>
            </div>
            <div class="flex-fill"></div>
            <div class="logout pointer">
                Logout
            </div>
        </div>
        <div class="flex-fill"></div>
        <div class="poll">
            <h1>Hansenberg Tinder</h1>
            <p>Willkommen zum Hansenberg Tinder, gebe an wen du unbedingt schon einmal SMASHEN wolltest YEAH</p>
            <div class="input-group" style="width: unset!important;">
                <div class="input-container">
                    <img src="/images/search.svg" class="icon" alt="">
                    <input class="noinput" id="search-user-input" type="text" placeholder="Schüler suchen">
                </div>
            </div>
            <div class="selected-users">
                <div>A <div class="flex-fill"></div> <img src="/images/trash.svg" alt="" height="18px" class="pointer"></div>
                <div>B</div>
                <div>C</div>
                <div>D</div>
            </div>
        </div>
        <div class="flex-fill"></div>
        <div class="footer">
            <a href="https://github.com/brentspine" target="_blank" style="color: var(--bs-link-color);">Made by Brentspine</a>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/snackbar.php" ?>
</body>
</html>