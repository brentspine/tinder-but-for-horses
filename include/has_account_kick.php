<?php

    ob_start();
    require $_SERVER['DOCUMENT_ROOT'] . "/include/users.php";
    ob_end_clean();

    if(isset($_COOKIE["session"])) {
        $result = prepared_statement_result("SELECT * FROM sessions WHERE token = ?", $con, true, "s", $_COOKIE["session"]);
        if($result -> num_rows > 0) {
            redirect_js("/hub", 0);
            return;
        }
    }
    
?>