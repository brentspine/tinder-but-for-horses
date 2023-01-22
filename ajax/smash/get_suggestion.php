<?php

ob_start();
require $_SERVER['DOCUMENT_ROOT'] . "/include/users.php";
ob_end_clean();

if($uid == -1) {
    echo get_json_answer(true, "not_signed_in", [], [], $con);
    return;
}

$sql = 'SELECT DISTINCT T1.id, T1.username, T1.first_name, T1.last_name, T1.bio, T1.class FROM users T1 WHERE T1.id NOT IN (SELECT target FROM pass WHERE uid = ?) AND T1.id NOT IN (SELECT target FROM smash WHERE uid = ?) AND T1.id != ? AND T1.id != "1" ORDER BY RAND() LIMIT 1';
$result = prepared_statement_result($sql, $con, true, "sss", $uid, $uid, $uid);

$user = get_multiple_database_entries_result($result, ["id", "username", "first_name", "last_name", "bio", "class"]);

$response = [];
if(sizeof($user) <= 0) {
    echo json_encode($response);
    return;
}
$user = $user[0];

$response["id"] = $user[0];
$response["username"] = ucfirst($user[1]);
$response["first_name"] = ucfirst($user[2]);
$response["last_name"] = ucfirst($user[3]);
if($user[4] == null || strlen($user[4]) <= 0)
    $response["bio"] = $response["first_name"] . " hat noch keine Bio angelegt...";
else
    $response["bio"] = $user[4];
$response["class"] = $user[5];

echo json_encode($response);

?>