<?php
session_start();
if(!isset($_SESSION['userid'])) {
    header("Location: /");
    exit();
}
session_destroy();
// alert(LOGOUT_SUCCESS);
header("Location: /");
exit();
?>