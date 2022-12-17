<?php

    ob_start();
    require $_SERVER['DOCUMENT_ROOT'] . "/include/users.php";
    ob_end_clean();

    if(isset($_COOKIE["session"])) {
        $sql = "SELECT * FROM sessions WHERE token = '" .$_COOKIE["session"]. "'";
        if(get_amount_of_entries_sql($sql, $con) > 0) {
            redirect_js("/hub", 0);
            return;
        }
    }
    
?>