<?php

ob_start();
require $_SERVER['DOCUMENT_ROOT'] . "/include/users.php";
ob_end_clean();

if($uid == -1) {
    echo get_json_answer(true, "not_signed_in", [], [], $con);
    return;
}

if(empty_any_params($_POST, "new_password", "confirm_password")) {
    echo get_json_answer(true, "missing_fields", [], [], $con);
    return;
}

//$old_password = $_POST["old_password"];
$new_password = $_POST["new_password"];
$confirm_password = $_POST["confirm_password"];

/*if(prepared_statement_result("SELECT * FROM users WHERE uid = ? AND password = ?", $con, true, "ss", $uid, $old_password) -> num_rows <= 0) {
    echo get_json_answer(true, "wrong_login", [], [], $con);
    return;
}*/

if($new_password != $confirm_password) {
    echo get_json_answer(true, "unmatching_passwords", [], [], $con);
    return;
}

/*if($old_password == $new_password) {
    echo get_json_answer(true, "new_and_old_passwords_match", [], [], $con);
    return;
}*/

$has_welcome = get_database_entry_result(prepared_statement_result("SELECT has_welcome FROM users WHERE id = ?", $con, true, "s", $uid), "has_welcome");
if($has_welcome == "1") {
    echo get_json_answer(true, "not_allowed", [], [], $con);
    return;
}


if(strlen($new_password) < 8) {
    echo get_json_answer(true, "field_to_short", [], ["%field%", "Passwort", "%length%", "8"], $con);
    return;
}

$_1 = 1;
prepared_statement_result("UPDATE users SET password = ?, has_welcome = ? WHERE id = ? ", $con, true, "sss", $new_password, $_1, $uid);
echo get_json_answer(false, "updated_password", [], [], $con);

?>