<?php

ob_start();
require $_SERVER['DOCUMENT_ROOT'] . "/include/users.php";
ob_end_clean();

if($uid == -1) {
    echo get_json_answer(true, "not_signed_in", [], [], $con);
    return;
}

if(!isset_any_params($_GET, "query")) {
    echo get_json_answer(true, "missing_fields", [], [], $con);
    return;
}

$query = $_GET["query"];

$sql = '
(SELECT * FROM (SELECT CONCAT(CONCAT(first_name, " "), last_name) AS full_name, id, class FROM users) AS result WHERE full_name LIKE ?) UNION
(SELECT * FROM (SELECT CONCAT(CONCAT(first_name, " "), last_name) AS full_name, id, class FROM users) AS result WHERE full_name LIKE CONCAT(?, "%")) UNION
(SELECT CONCAT(CONCAT(first_name, " "), last_name), id, class AS full_name FROM users WHERE first_name LIKE ? OR last_name LIKE ?) UNION
(SELECT CONCAT(CONCAT(first_name, " "), last_name), id, class AS full_name FROM users WHERE first_name LIKE CONCAT(?, "%") OR last_name LIKE CONCAT(?, "%")) UNION
(SELECT CONCAT(CONCAT(first_name, " "), last_name), id, class AS full_name FROM users WHERE first_name LIKE CONCAT(CONCAT("%", ?), "%") OR last_name LIKE CONCAT(CONCAT("%", ?), "%")) LIMIT 15;';
$result = prepared_statement_result($sql, $con, true, "ssssssss", $query, $query, $query, $query, $query, $query, $query, $query);

$users =  get_multiple_database_entries_result($result, array("id", "full_name", "class"));

$response = [];
foreach($users as $c) {
    $user = [];
    $user["id"] = $c[0];
    $user["full_name"] = $c[1];
    $user["class"] = $c[2];
    $response[] = $user;
}
echo json_encode($response);

?>