<?php
if(!file_exists("../app/mysql.php")){
    header("Location: ../setup/index.php");
    exit;
}
session_start();
require "../app/data.php";
include "../app/inc/header.php";

if(!isset($_SESSION['userid'])){
    header("Location: ../login.php");
    exit;
}
$id = $_SESSION['userid'];
$email = getEmailById($id);
$language = 'en';
if(getLanguage($email) != null) {
    $language = getLanguage($email);
}
include "../app/languages/lang_" . $language . ".php";
if(getRank($email) <= 1) {
    die(ADMIN_ERROR_PERMISSION);
}

include "../app/inc/navbar.php";


include "../app/inc/footer.php";
?>