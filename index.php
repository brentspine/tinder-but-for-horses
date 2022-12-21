<?php

include $_SERVER["DOCUMENT_ROOT"] . "/include/functions.php";

if(strlen(get_current_path()) <= 1) {
    echo '<script>window.location.href = "/login"</script>';
    return;
}
echo '<h1>404 Not Found</h1>';

?>