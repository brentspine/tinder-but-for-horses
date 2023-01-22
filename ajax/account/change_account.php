<?php

ob_start();
require $_SERVER['DOCUMENT_ROOT'] . "/include/users.php";
ob_end_clean();

if($uid == -1) {
    echo get_json_answer(true, "not_signed_in", [], [], $con);
    return;
}

if(!isset_any_params($_POST, "bio")) {
    echo get_json_answer(true, "missing_fields", [], [], $con);
    return;
}

$bio = $_POST["bio"];

if(strlen($bio) > 256) {
    echo get_json_answer(true, "bio_to_long", [], ["%length%", "256"], $con);
    return;
}

if(count(preg_split('/\n|\r/',$bio)) > 10) {
    echo get_json_answer(true, "bio_to_long_lines", [], ["%length%", "10"], $con);
    return;
}

prepared_statement_result("UPDATE users SET bio = ? WHERE id = ?", $con, true, "ss", $bio, $uid);
echo get_json_answer(false, "account_updated", [], [], $con);

?>