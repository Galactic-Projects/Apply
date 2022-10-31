<?php
if(!file_exists("app/mysql.php")){
    header("Location: setup/index.php");
    exit;
}
require "app/data.php";
require "app/languages/lang_en.php";
include "app/inc/header.php";
include "app/inc/navbar.php";

if(!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}
echo "logged in: " . $_SESSION["USERID"];