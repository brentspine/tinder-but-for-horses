<?php

ob_start();
require $_SERVER['DOCUMENT_ROOT'] . "/include/users.php";
ob_end_clean();

$uid = get_user_by_session($con);

if($uid == -1) {
    echo get_json_answer(true, "not_signed_in", [], [], $con);
    return;
}

if(empty_any_params($_GET, "query")) {
    echo get_json_answer(true, "missing_fields", [], [], $con);
    return;
}

$query = $_GET["query"];

$sql = '
(SELECT * FROM (SELECT CONCAT(CONCAT(first_name, " "), last_name) AS full_name FROM users) AS result WHERE full_name LIKE ?) UNION
(SELECT * FROM (SELECT CONCAT(CONCAT(first_name, " "), last_name) AS full_name FROM users) AS result WHERE full_name LIKE CONCAT(?, "%")) UNION
(SELECT CONCAT(CONCAT(first_name, " "), last_name) AS full_name FROM users WHERE first_name LIKE ? OR last_name LIKE ?) UNION
(SELECT CONCAT(CONCAT(first_name, " "), last_name) AS full_name FROM users WHERE first_name LIKE CONCAT(?, "%") OR last_name LIKE CONCAT(?, "%")) UNION
(SELECT CONCAT(CONCAT(first_name, " "), last_name) AS full_name FROM users WHERE first_name LIKE CONCAT(CONCAT("%", ?), "%") OR last_name LIKE CONCAT(CONCAT("%", ?), "%"));';
$result = prepared_statement_result($sql, $con, true, "ssssssss", $query, $query, $query, $query, $query, $query, $query, $query);

$users =  get_database_entries_result($result, "full_name");

$response = [];
foreach($users as $c)
    $response[] = $c;
echo json_encode($response);

?>