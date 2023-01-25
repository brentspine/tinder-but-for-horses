<?php

ob_start();
require $_SERVER["DOCUMENT_ROOT"] . "/include/users.php";
ob_end_clean();

// Fields missing
if(empty_any_params($_POST, "username", "password")) {
    echo get_json_answer(true, "missing_fields", [], [], $con);
    return;
}

$username = htmlspecialchars(strtolower($_POST["username"]));
$password = htmlspecialchars($_POST["password"]);
if($_POST["password"] != $password) {
    echo get_json_answer(true, "illegal_characters_password", [], [], $con);
    return;
}

$ps = $con -> prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$ps -> bind_param("ss", $username, $password);
$ps -> execute();
$result = $ps -> get_result();

if($result -> num_rows <= 0) {
    echo get_json_answer(true, "wrong_login", array("user"=>$username), [], $con);
    return;
}

// Password Ok, check if session is set
if(isset($_COOKIE["session"])) {
    $uid = get_user_by_session($con);
    $result = prepared_statement_result("SELECT * FROM sessions WHERE uid = ? AND token = ?", $con, true, "ss", $uid, $_COOKIE["session"]);
    if($result -> num_rows > 0) {

        // Set the username cookie
        $result = prepared_statement_result("SELECT * FROM users WHERE id = ?", $con, true, "s", $uid);
        setcookie("username", get_row_result($result, "username", $con), time() + 60*60*24*30, "/"); 

        echo get_json_answer(false, "login_successfull_redirect", [], [], $con);
        return;
    }
    clear_cookie("session");
}

$uid = get_user_by_username($username, $con);

// Clear old session keys
prepared_statement("DELETE FROM sessions WHERE uid = ?", $con, true, "s", $uid);

// Create new session token
$token = bin2hex(random_bytes(42));

// Insert token into database 
prepared_statement("INSERT INTO sessions (uid, token) VALUES (?, ?)", $con, true, "ss", $uid, $token);

// Set the session cookie (30d)
setcookie("session", $token, time() + 60*60*24*30, "/");  

// Set the username cookie
$result = prepared_statement_result("SELECT * FROM users WHERE id = ?", $con, true, "s", $uid);
setcookie("username", get_row_result($result, "username", $con), time() + 60*60*24*30, "/"); 

echo get_json_answer(false, "login_successfull_redirect", [], [], $con);

?>