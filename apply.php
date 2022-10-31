<?php
if(!file_exists("app/mysql.php")){
    header("Location: setup/index.php");
    exit;
}
if(!isset($_SESSION["userid"])) {
    header("login.php");
    exit();
}
require "app/mysql.php";
require "app/data.php";
require "app/languages/lang_en.php";
include "app/inc/header.php";
include "app/inc/navbar.php";


include "app/inc/footer.php";
?>