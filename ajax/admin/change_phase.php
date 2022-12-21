<?php

ob_start();
require $_SERVER['DOCUMENT_ROOT'] . "/include/users.php";
ob_end_clean();

if($uid == -1) {
    echo get_json_answer(true, "not_signed_in", [], [], $con);
    return;
}

if(!has_user_permission($uid, "change-phase", $con)) {
    echo get_json_answer(true, "not_enough_permissions", [], [], $con);
    return;
}

if(empty_any_params($_POST, "phase")) {
    echo get_json_answer(true, "missing_fields", [], [], $con);
    return;
}

$phase = $_POST["phase"];

if(prepared_statement_result("SELECT * FROM settings WHERE name = 'phase' AND val = ?", $con, true, "s", $phase) -> num_rows > 0) {
    echo get_json_answer(true, "nothing_changed", [], [], $con);
    return;
}

prepared_statement_result("UPDATE settings SET val = ? WHERE name = 'phase'", $con, true, "s", $phase);
echo get_json_answer(false, "changed_phase", [], [], $con);

?>