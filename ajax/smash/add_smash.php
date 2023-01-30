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

if($user == $uid) {
    echo get_json_answer(true, "cant_mark_yourself_as_smash", [], [], $con);
    return;
}

$result = prepared_statement_result("SELECT * FROM smash WHERE uid = ? AND target = ?", $con, true, "ss", $uid, $user);
if ($result -> num_rows > 0) {
    echo get_json_answer(true, "already_smash", [], [], $con);
    return;
}

$result = prepared_statement_result("SELECT * FROM pass WHERE uid = ? AND target = ?", $con, true, "ss", $uid, $user);
if ($result -> num_rows > 0) {
    echo get_json_answer(true, "already_pass_mark_smash", [], [], $con);
    return;
}

$result = prepared_statement_result("SELECT * FROM smash WHERE uid = ?", $con, true, "s", $uid);
if($result -> num_rows >= 15) {
    echo get_json_answer(true, "smash_limit_reached", [], [], $con);
    return;
}

$result = prepared_statement_result("INSERT INTO smash (uid, target) VALUES (?, ?)", $con, true, "ss", $uid, $user);
$result = prepared_statement_result("SELECT * FROM users WHERE id = ?", $con, true, "s", $user);
echo get_json_answer(false, "added_smash", get_multiple_database_entries_result($result, ["first_name", "last_name", "id"])[0], [], $con);

?>