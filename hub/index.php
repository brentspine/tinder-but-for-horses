<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/no_account_kick.php" ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/head_standard.php" ?>
    <link rel="stylesheet" href="/hub/hub.css">
    <script src="/hub/hub.js"></script>
    <title>Hub</title>
</head>
<body>

    <div class="main">
        <div class="header">
            <div class="logged-in">
                Eingeloggt als: <?php echo get_database_entry_result(prepared_statement_result('SELECT CONCAT(CONCAT(first_name, " "), last_name) AS full_name FROM users WHERE id = ?', $con, true, "s", $uid), "full_name") ?>
            </div>
            <div class="flex-fill"></div>
            <div class="logout pointer" onclick="logout()">
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
                <div class="user-search-suggestions" id="user-search-suggestions">
                    Enter something
                </div>
            </div>
            <div class="selected-users">
                <?php
                    $sql = "SELECT users.first_name, users.last_name, users.id FROM smash LEFT JOIN users ON users.id & smash.target WHERE users.id = target AND smash.uid = ?";
                    $result = prepared_statement_result($sql, $con, true, "s", $uid);
                    foreach(get_multiple_database_entries_result($result, ["first_name", "last_name", "id"]) as $c) {
                        echo "<div data-id='".$c[2]."'><span>".$c[0]." ".$c[1]."</span>" . "<div class='flex-fill'></div>" . "<img src='/images/trash.svg' alt='Remove' height='18px' class='pointer' onclick='remove_smash(\"".$c[2]."\")'></div>";
                    }
                ?>
            </div>
        </div>
        <div class="flex-fill"></div>
        <div class="footer">
            <a href="https://github.com/brentspine" target="_blank" style="color: var(--bs-link-color);">Made by Brentspine</a>
            <div class="flex-fill"></div>
            <span>Auflösung am 6.9.2023</span>
        </div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/snackbar.php" ?>
</body>
</html>