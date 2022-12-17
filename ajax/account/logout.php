<?php

ob_start();
require $_SERVER['DOCUMENT_ROOT'] . "/include/users.php";
ob_end_clean();

$uid = get_user_by_session($con);

if($uid == -1) {
    echo get_json_answer(true, "already_logged_out", [], [], $con);
    return;
}

setcookie("session", "", 0, "/");
echo get_json_answer(false, "logged_out", [], [], $con);

?>