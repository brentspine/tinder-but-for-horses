<?php

ob_start();
require $_SERVER['DOCUMENT_ROOT'] . "/include/users.php";
ob_end_clean();

if($uid == -1) {
    echo get_json_answer(true, "not_signed_in", [], [], $con);
    return;
}

if(!has_user_permission($uid, "add-users", $con)) {
    echo get_json_answer(true, "not_enough_permissions", [], [], $con);
    return;
}

if(empty_any_params($_POST, "username", "firstname", "lastname")) {
    echo get_json_answer(true, "missing_fields", [], [], $con);
    return;
}

$username = $_POST["username"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$password = bin2hex(random_bytes(10));

if(prepared_statement_result("SELECT * FROM users WHERE username = ?", $con, true, "s", $username) -> num_rows > 0) {
    echo get_json_answer(true, "username_taken", [], [], $con);
    return;
}

$sql = "INSERT INTO users (username, first_name, last_name, password, permissions, role) VALUES (?, ?, ?, ?, 0, 0)";
prepared_statement_result($sql, $con, true, "ssss", $username, $firstname, $lastname, $password);
echo get_json_answer(false, "created_account", ["password" => $password], [], $con);

?>