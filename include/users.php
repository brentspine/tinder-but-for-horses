<?php

ob_start();
require $_SERVER['DOCUMENT_ROOT'] . "/include/functions.php";
ob_end_clean();

$uid = get_user_by_session($con);

function does_user_exist($name, $con) {
    $sql = "SELECT * FROM users WHERE username = '".$name."' OR mail = '".$name."'";
    if(get_amount_of_entries_sql($sql, $con) > 0)
        return true;

    return false;
}

function get_user_id($name, $con) {
    //if(!does_user_exist($name, $con)) return "User not found";
    
    $sql = "SELECT * FROM users WHERE username = '".$name."' OR mail = '".$name."'";
    $result = $con -> query($sql);
    if($result -> num_rows > 0)
        return get_database_entry_result($result, "id");

    return -1;
}

function is_session_available($uid, $con) {
    if(isset($_COOKIE["session"])) {
        $sql = "SELECT * FROM sessions WHERE uid = '" .$uid. "' AND token = '".$_COOKIE["session"]."'";
        if(get_amount_of_entries_sql($sql, $con) > 0)
            return true;
        setcookie("session", "");
    }
    return false;
}

function get_session() {
    return $_COOKIE["session"];
}

function get_user_by_session($con) {
    if(!isset($_COOKIE["session"])) return -1;
    $sql = "SELECT * FROM sessions WHERE token = '".$_COOKIE["session"]."'";
    $result = $con -> query($sql);
    return get_database_entry_result($result, "uid");
}

function get_user_entry($id, $column, $con) {
    $sql = "SELECT * FROM users WHERE id = '" .$id. "'";
    return get_row($sql, $column, $con);
}

function get_user_by_username($username, $con) {
    $ps = $con -> prepare("SELECT * FROM users WHERE username = ?");
    $ps -> bind_param("s", $username);
    $ps -> execute();
    return get_row_result($ps -> get_result(), "id");
}

?>