<?php

ob_start();
require $_SERVER['DOCUMENT_ROOT'] . "/include/users.php";
ob_end_clean();

if($uid == -1) {
    echo get_json_answer(true, "not_signed_in", [], [], $con);
    return;
}

if(empty_any_params($_POST, "user")) {
    echo get_json_answer(true, "missing_fields", [], [], $con);
    return;
}

$user = $_POST["user"];

$result = prepared_statement_result("SELECT * FROM smash WHERE uid = ? AND target = ?", $con, true, "ss", $uid, $user);
if ($result -> num_rows <= 0) {
    echo get_json_answer(true, "not_marked_as_smash", [], [], $con);
    return;
}

$result = prepared_statement_result("DELETE FROM smash WHERE uid = ? AND target = ?", $con, true, "ss", $uid, $user);
echo get_json_answer(false, "removed_smash", [], [], $con);

?>