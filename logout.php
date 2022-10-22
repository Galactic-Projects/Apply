<?php
session_start();
if(!isset($_SESSION['USERID'])) {
    alert(LOGOUT_ERROR);
    header("Location: /");
    exit();
}
session_destroy();
alert(LOGOUT_SUCCESS);
header("Location: /");
exit();
?>