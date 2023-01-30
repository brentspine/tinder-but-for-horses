<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/no_account_kick.php" ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/head_standard.php" ?>
    <link rel="stylesheet" href="/hub/hub.css">
    <script src="/hub/hub.js"></script>
    <title>Hub</title>
</head>
<?php

$has_welcome = get_database_entry_result(prepared_statement_result("SELECT has_welcome FROM users WHERE id = ?", $con, true, "s", $uid), "has_welcome");
if($has_welcome == "0") {
    echo "<script>window.location.href = '/welcome'</script>";
    return;
}

?>
<body>

    <div class="main">
        <div class="header">
            <div class="logged-in">
                Eingeloggt als: <?php $name = get_database_entry_result(prepared_statement_result('SELECT CONCAT(CONCAT(first_name, " "), last_name) AS full_name FROM users WHERE id = ?', $con, true, "s", $uid), "full_name"); echo htmlspecialchars(strlen($name) > 3 ? $name : get_database_entry_result(prepared_statement_result("SELECT username FROM users WHERE id = ?", $con, true, "s", $uid), "username")) ?>
            </div>
            <div class="header-logo">
                <img src="/images/logo.png" alt="Logo"> 
            </div>
            <div class="flex-fill"></div>
            <?php if(has_user_permission($uid, "admin-panel", $con)) echo '<a href="/admin" class="nolink" style="margin-right: 10px;">Dashboard</a>'; ?>
            <div class="account pointer" style="margin-right: 10px;"><a class="nolink" href="/hub?p=account">Account</a></div>
            <div class="logout pointer" onclick="logout()">
                Logout  
            </div>
        </div>
        <div class="flex-fill"></div>
        <?php 
            $p = !empty($_GET["p"]) ? $_GET["p"] : "";
            $pages = ["account", "list"];
            if(in_array($p, $pages)) {
                include $_SERVER["DOCUMENT_ROOT"] . "/hub/" . $p . ".php";
            }
            else {
                // add_users, poll, results
                $phase = get_database_entry_result(prepared_statement_result("SELECT val FROM settings WHERE name = 'phase'", $con, false, ""), "val");
                include $_SERVER["DOCUMENT_ROOT"] . "/hub/" . $phase . ".php";
            }
        ?>
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