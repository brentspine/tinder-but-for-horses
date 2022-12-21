<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/no_account_kick.php" ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/include/head_standard.php" ?>
    <link rel="stylesheet" href="/admin/admin.css">
    <script src="/admin/admin.js"></script>
    <title>Admin</title>
    <?php if(!has_user_permission($uid, "admin-panel", $con)) echo '<script>window.location.href = "/hub"</script>' ?>
</head>
<body>

    <div class="main">
        <div class="header">
            <div class="logged-in">
                Eingeloggt als: <?php echo get_database_entry_result(prepared_statement_result('SELECT CONCAT(CONCAT(first_name, " "), last_name) AS full_name FROM users WHERE id = ?', $con, true, "s", $uid), "full_name") ?>
            </div>
            <div class="flex-fill"></div>
            <a href="/hub" class="nolink" style="margin-right: 10px;">Zurück</a>
            <div class="logout pointer" onclick="logout()">
                Logout  
            </div>
        </div>
        <div class="flex-fill"></div>
        <div class="panel">
            <?php
                switch(empty($_GET["p"]) ? "" : $_GET["p"]) {
                    case "dashboard": case "add_user": case "change_phase":
                        include $_SERVER["DOCUMENT_ROOT"] . "/admin/" . $_GET["p"] . ".php";
                        break;
                    default:
                        include $_SERVER["DOCUMENT_ROOT"] . "/admin/dashboard.php";
                        break;
                }
            ?>
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